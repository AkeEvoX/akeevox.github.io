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
	
	function get_list_contact_message(){
		
			try{
			
			$sql = " select contact_to,contact_alias ";
			$sql .= " from contact_list where c.active=1 ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  List Contact Message : ".$e->getMessage();
		} 
	}
	
	function get_list_contact_fetch($start_fetch,$max_fetch){
			try{
			
			$sql = " select c.*,t.`name` as typename ";
			$sql .= " from contacts c ";
			$sql .= " inner join contact_type t on c.type =t.id ";
			$sql .= " where type not in ('5','6') " ;
			$sql .= " order by c.id desc" ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("ContactManager > get_list_contact_fetch > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  ContactManager list contact  : ".$e->getMessage();
		}
	}
	
	function get_list_option(){
			
			try{
			
			$sql = " select * ";
			$sql .= " from contact_type where id not in ('5','6') ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  List Contact Option : ".$e->getMessage();
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
	
	function get_map_info(){
		
		try{
			$sql = "select * ";
			$sql .= " from contacts where id=9 ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get ContactManager > Map info: ".$e->getMessage();
		}
		
	}
	
	function insert_contact($items){
		
		try{
			
			$contact_type  =$items["contact_type"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$icon= $items["icon"];
			$link= $items["link"];
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into contacts (type,title_th ,title_en ,icon ,link ,create_by  ,create_date  ,active) ";
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
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,type=$contact_type ";
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
	
	function update_map($items){
		try{
			
			$map_th = "";
			$map_en = "";
			$id = $items["id"];
			if($items["title_th"]){
				$map_th=" ,title_th='".$items["title_th"]."' ";	
			}
			if($items["title_en"]){
				$map_en=" ,title_en='".$items["title_en"]."' ";	
			}
			
			$update_by='0';
			$update_date='now()';
			
			$sql = "update contacts set  ";
			$sql .= "update_by=$update_by,update_date=$update_date " ;
			$sql .= $map_th ;
			$sql .= $map_en ;
			$sql .= "where id=9; ";
			$this->mysql->execute($sql);
			
			log_debug("Contact > update map > " .$sql);

			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Contact Update  Map : ".$e->getMessage();
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