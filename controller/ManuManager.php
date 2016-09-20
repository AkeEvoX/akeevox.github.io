<?php
require_once("lib/database.php");

class MenuManager {


	public $lang = "th";//default lang
	protected $mysql;


	function __construct(){

		try{
			
			$this->mysql = new database();
			echo "initial registermanager.";

		}
		catch(Exception $e)
		{
			die("initial registermanager error : ". $e->getMessage());
		}
	}

	function __destruct(){

	}

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

	function setlang($data)
	{
		$this->lang=$data;
	}

}

?>