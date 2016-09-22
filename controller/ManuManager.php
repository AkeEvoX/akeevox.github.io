<?php
include("../lib/database.php");

class MenuManager {


	public $lang = "th";//default lang
	protected $mysql;


	function __construct(){

		try{
			
			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial registermanager.";

		}
		catch(Exception $e)
		{
			die("initial registermanager error : ". $e->getMessage());
		}
	}

	function __destruct(){
		$this->mysql->disconnect();
	}

	function getmenu($lang)
	{

		try{
			$sql = "select id,".$lang." as name,seq ";
			$sql .= "from menu_master where active=1 and parent=0 order by seq ";
			$result = $this->mysql->execute($sql);
		}
		catch(Exception $e)
		{
			echo "Cannot get main menu : ".$e->getMessage();
		}
	}
	function getsubmenu($id)
	{

		try{
			$sql = "select id,".$lang." as name,seq ";
			$sql .= "from menu_master where active=1 and parent=".$id." order by seq ";
			$result = $this->mysql->execute($sql);
		}
		catch(Exception $e)
		{
			echo "Cannot get sub menu : ".$e->getMessage();
		}
	}
/*
	function getList(){

		try{

		$this->mysql->connect();

		echo $result;

		$sql = "call getmenus(?);";
		$types="s";
		$datas->lang = $this->lang;

		$result = $this->mysql->procedure($sql,$types,$datas);

		$this->mysql->disconect();

		return $result;

		}catch(Exception $e){
			echo "Cannot insert register".$e->getMessage();
		}

	}
*/
	function setlang($data)
	{
		$this->lang=$data;
	}

}

?>