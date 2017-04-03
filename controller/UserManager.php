<?php
require_once($base_dir."/lib/database.php");

class UserManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial user manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getItem($id,$lang){
		
		// try{

			// $sql = " select id,title_".$lang." as title,detail_".$lang." as detail ,thumbnail ,update_date ";
			// $sql .= "from award where active=1 and id='".$id."' order by update_date desc ";
			// $result = $this->mysql->execute($sql);
			
			// return  $result;
		// }
		// catch(Exception $e){
			// echo "Cannot Get  Award : ".$e->getMessage();
		// }
		
	}
	
	function get_user_info($id){
		
		try{

			$sql = " select * ";
			$sql .= " from users   ";
			$sql .= " where id='".$id."' ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  User Info : ".$e->getMessage();
		}
		
	}

	function getListItem($lang)
	{
			try{
			
			$sql = "select id,thumbnail,update_date,type ";
			$sql .= "from award where active=1 order by update_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Award : ".$e->getMessage();
		}
	}
	
	function get_fetch_list($start_fetch,$max_fetch){
			try{

			$sql = " select u.id,concat(u.firstname,' ',u.lastname) as fullname ";
			$sql .= " ,u.update_by,update_date,u.active ";
			$sql .= " ,r.title as role_name from users u " ;
			$sql .= " inner join user_roles r on u.role_id=r.id " ;
			$sql .= " where u.id !=0  " ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("User > get_fetch_list > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  List User  : ".$e->getMessage();
		}
	}
	
	function insert_item($items){
		
		try{
			
			$firstname  =$items["firstname"];
			$lastname  =$items["lastname"];
			$role_id = $items["role_type"];
			$user_name =$items["user_name"];
			$pass_word =md5($items["pass_word"]);
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into users (firstname ,lastname  ,role_id ,user_name ,pass_word ,active ,create_by ,create_date ) ";
			$sql .= "values('$firstname'  ,'$lastname'  ,$role_id ,'$user_name','$pass_word' ,$active ,$create_by ,$create_date ); ";
			$this->mysql->execute($sql);
			
			log_debug("UserManager > insert  > " .$sql);
			
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert User : ".$e->getMessage();
		}
		
	}
	
	function update_item($items){
		try{
			$id = $items["id"];
			$firstname  =$items["firstname"];
			$lastname  =$items["lastname"];
			$role_id = $items["role_type"];
			$user_name =$items["user_name"];
			$pass_word ="";
			if($items["pass_word"] != "")
				$pass_word =",pass_word='".md5($items["pass_word"])."' " ;
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by=$_SESSION["profile"]->id;
			$update_date='now()';
			
			$sql = "update users set  ";
			$sql .= "firstname='$firstname' ,lastname='$lastname' ,role_id=$role_id ,user_name='$user_name' ";
			$sql .= $pass_word ;
			$sql .= " ,active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("User > update > " .$sql);
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update User : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		
		try{
			$sql = "delete from users where id=$id ; ";
			log_debug("User > delete > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete User : ".$e->getMessage();
		}
	}
	
}

?>
