<?php
require_once($base_dir."/lib/database.php");

class ContactManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
//			echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial registermanager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getContact($lang){
		
		try{
			
			$sql = " select c.id,title_".$lang." as title,c.icon,c.link,t.name as typename ";
			$sql .= " from contacts c inner join contact_type t on c.type = t.id where c.active=1 ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Contact : ".$e->getMessage();
		} 
		
	}
	
	function get_list_contact_fetch($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from contacts  ";
			$sql .= " order by id desc" ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("ContactManager > get_list_contact_fetch > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  ContactManager list contact  : ".$e->getMessage();
		}
	}
	
	function get_contact_info($id){
		try{

			$sql = "select * ";
			$sql .= " from contacts where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get ContactManager Contact info: ".$e->getMessage();
		}
	}
	
	function insert_contact($items){
		
		try{
			
			$contact_type  =$items["contact_type"];
			$th  =$items["title_th"];
			$en  =$items["title_en"];
			$icon= $items["icon"];
			$link= $items["link"];
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into contacts (type,title_th  ,title_en ,icon ,link ,create_by  ,create_date  ,active ) ";
			$sql .= "values($contact_type,'$title_th'  ,'$title_en'  ,'$icon'  ,'$link' ,$create_by  ,$create_date  ,$active); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("ContactManager > insert_contact > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert ContactManager Contact : ".$e->getMessage();
		}
		
	}
	
	function update_contact($items){
		try{
			$id = $items["id"];
			$contact_type  =$items["contact_type"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$icon= "";
			$link= "";

			if($items["icon"]){
				$icon=",icon='".$items["icon"]."' ";	
			}
			
			if($items["link"]){
				$link=",link='".$items["link"]."' ";	
			}
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
		
			$sql = "update contacts set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date $icon $link ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("ContactManager > update_contact> " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update ContactManager Contact  : ".$e->getMessage();
		}
	}
	
	function delete_contact($id){
		
		try{
			$sql = "delete from contacts where id=$id ; ";
			log_debug("ContactManager > delete_contact > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete ContactManager Contact : ".$e->getMessage();
		}
	}
	
	
}

?>