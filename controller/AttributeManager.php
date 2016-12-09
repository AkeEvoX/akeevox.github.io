<?php
require_once($base_dir."/lib/database.php");

class AttributeManager {

	protected $mysql;

	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial registermanager.";
		}
		catch(Exception $e)
		{
			die("initial attribute error : ". $e->getMessage());
		}
	}

	function __destruct(){
		$this->mysql->disconnect();
	}

	function getmenu($lang)
	{
		try{
			$sql = " select id,name,".$lang." as title,seq from attribute_master ";
			$sql .= " where name like 'menu.%' ";
			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			return "Cannot get attribute menu : ".$e->getMessage();
		}
	}
	/*get attribute for page*/
	function getItems($lang,$type)
	{
		try{
			$sql = " select id,name,".$lang." as title,seq,options from attribute_master ";
			$sql .= " where name like '".$type.".%' or name like '%nav.%' order by seq ";
			log_warning($sql);
			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			return "Cannot get attributes : ".$e->getMessage();
		}
	}
	/*get attribute only*/
	function getattrs($lang,$type)
	{
		try{
			$sql = " select id,name,".$lang." as title,seq,options from attribute_master ";
			$sql .= " where name like '".$type.".%' order by seq";
			log_warning($sql);
			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			return "Cannot get attributes : ".$e->getMessage();
		}
	}
	
	function getattrs_ctrl($type)
	{
		try{
			$sql = " select * from attribute_master ";
			$sql .= " where name like '".$type.".%' order by seq";
			log_warning($sql);
			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			return "Cannot get attributes control : ".$e->getMessage();
		}
	}
	
	function update_attribute($data){
		
		try{
			$sql = " update attribute_master set th='".$data["th"]."' , en='".$data["en"]."' , options='".$data["options"]."' ";
			$sql .= " where id='".$data["id"]."' ";
			log_warning($sql);
			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			return "Cannot update attributes : ".$e->getMessage();
		}
		
	}

}

?>
