<?php
require_once($base_dir."/lib/database.php");

class SecurityManager {
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial about manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function login($user,$pass){

		try{

			$sql = "select u.*,r.title as role_name from users u inner join user_roles r on u.role_id = r.id ";
			$sql .= " where user_name = '$user' and pass_word = '$pass' ";

			log_debug("login > ". $sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Error Login = ".$e->getMessage();
		}

	}

	
	function login_log($items){
		
		try{

			$id = $items["id"];
			$user = $items["username"];
			$update_date = "current_timestamp";
			
			$sql = "insert login_log (username,status,update_date) ";
			$sql .= "values('$user','$status',$update_date); ";
			
			$result = $this->mysql->execute($sql);
			return $result;

		}
		catch(Exception $e){
			echo "Cannot Update Login Log: ".$e->getMessage();
		}
	}
	
}

?>