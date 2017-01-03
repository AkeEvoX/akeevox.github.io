<?php
require_once($base_dir."/lib/database.php");

class DownloadManager{
	
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

	function getType($lang,$id){
	try{

			$sql = " select id,".$lang." as name from download_type where active=1  ";

			if(isset($id) && !empty($id)) {
				$sql  .= " and id=".$id;
			}
			
			$sql .= " order by seq";
		
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Type Download : ".$e->getMessage();
		} 
		
	}
	function getTypeOption(){
	try{

			$sql = " select * from download_type ";
			$sql .= " order by id ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Option Type Download : ".$e->getMessage();
		} 
		
	}

	function getListItem($id,$lenght,$lang){
			try{
			
			$sql = " select id,title_".$lang." as title,thumbnail,link from downloads where active=1  and type = ".$id . " order by create_date";

			if(isset($lenght) && !empty($lenght)){
				$sql .= " limit ". $lenght;
			}

			
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Download : ".$e->getMessage();
		} 
	}
	
	
	function get_list_type_fetch($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from download_type  ";
			$sql .= " order by id desc" ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("DownloadManager > get_list_type_fetch > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get DownloadManager list type download  : ".$e->getMessage();
		}
	}
	
	function get_list_download_fetch($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from downloads  ";
			$sql .= " order by id desc" ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("DownloadManager > get_list_download_fetch > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  DownloadManager list download  : ".$e->getMessage();
		}
	}
	
	function get_download_type($id){
		try{

			$sql = "select * ";
			$sql .= " from download_type where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get DownloadManager Type info: ".$e->getMessage();
		}
	}
	
	function get_download_info($id){
		try{

			$sql = "select * ";
			$sql .= " from downloads where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get DownloadManager Download info: ".$e->getMessage();
		}
	}
	
	function insert_type_download($items){		
	
		try{
			
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into download_type (th ,en ,active ,create_by ,create_date) ";
			$sql .= "values('$title_th'  ,'$title_en' ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			
			
			log_debug("DownloadManager > insert_type_download  > " .$sql);
			
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert DownloadManager Type Download : ".$e->getMessage();
		}
		
	}
	
	function insert_download($items){
		
		try{
			$type  =$items["download_type"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$thumbnail= $items["thumbnail"];
			$link= $items["link"];
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into downloads (type,title_th  ,title_en ,thumbnail ,link ,create_by  ,create_date  ,active ) ";
			$sql .= "values($type,'$title_th'  ,'$title_en'  ,'$thumbnail'  ,'$link' ,$create_by  ,$create_date  ,$active); ";
			$this->mysql->execute($sql);
			
			log_debug("DownloadManager > insert_download > " .$sql);
			
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert DownloadManager Download : ".$e->getMessage();
		}
		
	}
	
	function update_download($items){
		try{
			$id = $items["id"];
			$type  =$items["download_type"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$thumbnail= "";
			$link= "";

			if($items["thumbnail"]){
				$thumbnail=",thumbnail='".$items["thumbnail"]."' ";	
			}
			
			if($items["link"]){
				$link=",link='".$items["link"]."' ";	
			}
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
		
			$sql = "update downloads set  ";
			$sql .= "type=$type ,title_th='$title_th' ,title_en='$title_en' ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date $thumbnail $link ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("DownloadManager > update_download> " .$sql);
			
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update DownloadManager Download  : ".$e->getMessage();
		}
	}
	
	function update_type_download($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
			
			$sql = "update download_type set  ";
			$sql .= "th='$title_th' ,en='$title_en' ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("DownloadManager > update_type_download > " .$sql);
			
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update DownloadManager Type Download : ".$e->getMessage();
		}
	}

	function delete_download($id){
		
		try{
			$sql = "delete from downloads where id=$id ; ";
			log_debug("DownloadManager > delete_download > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete DownloadManager Download : ".$e->getMessage();
		}
	}
	
	function delete_type_download($id){
		
		try{
			$sql = "delete from download_type where id=$id ; ";
			log_debug("OrgManager > delete_type_download > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete DownloadManager Type Download : ".$e->getMessage();
		}
	}
	
	
	
}

?>