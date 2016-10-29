<?php
require_once("../lib/database.php");

class MenuManager {

	protected $mysql;

	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial registermanager.";

		}
		catch(Exception $e)
		{
			die("initial mainmenu error : ". $e->getMessage());
		}
	}

	function __destruct(){
		$this->mysql->disconnect();
	}

	function getmenu($lang)
	{

		try{
			/*
			$sql = "select m.id,m.".$lang." as name, m.seq,m.link ";
			$sql .= ",(select count(0) from menu_master s where s.parent=m.id and s.active=1) as child ";
			$sql .= " from menu_master m where active=1 and m.parent=0 order by m.seq ";*/

			$sql = "select m.id,m.".$lang." as name, m.seq,m.link,m.parent ";
			$sql .= " from menu_master m where active=1 order by m.parent,m.seq ";

			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			echo "Cannot get main menu : ".$e->getMessage();
		}
	}

	function getparentmenu($lang){
		try{
			/*
			$sql = "select m.id,m.".$lang." as name, m.seq,m.link ";
			$sql .= ",(select count(0) from menu_master s where s.parent=m.id and s.active=1) as child ";
			$sql .= " from menu_master m where active=1 and m.parent=0 order by m.seq ";*/

			$sql = "select m.id,m.".$lang." as name, m.seq,m.link,m.parent ";
			$sql .= " from menu_master m where active=1 and m.parent=0  order by m.seq ";

			$result = $this->mysql->execute($sql);

			return $result;
		}
		catch(Exception $e)
		{
			echo "Cannot get main menu : ".$e->getMessage();
		}
	}

	function getsubmenu($id,$lang)
	{

		try{
			$sql = "select id,".$lang." as name,link,seq ";
			$sql .= " from menu_master where active=1 and parent=".$id." order by seq ";
			$result = $this->mysql->execute($sql);

			return $result;
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
}

?>
