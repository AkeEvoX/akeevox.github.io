<?php
require_once($base_dir."/lib/database.php");

class GalleryManager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial press manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function get_gallery($lang,$id){
		
		try{

			$sql = "select id,title_".$lang." as title ,thumbnail,image ";
			$sql .= ",( case when update_date is null then create_date else update_date end ) as data_date ";
			$sql .= "from gallery where active=1 and id='".$id."' order by create_date desc ";
			$result = $this->mysql->execute($sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Gallery : ".$e->getMessage();
		}
		
	}

	function get_list_gallery($lang,$id)
	{
			try{
			
			$sql = "select id,title_".$lang." as title ,thumbnail,image";
			$sql .= ",( case when update_date is null then create_date else update_date end ) as data_date ";
			$sql .= "from gallery where active=1 and album_id = ".$id." order by create_date desc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Gallery : ".$e->getMessage();
		}
	}
	
	function get_list_album($lang){
			try{
			
			$sql = "select id,title_".$lang." as title ,cover";
			$sql .= ",( case when update_date is null then create_date else update_date end ) as data_date ";
			$sql .= "from gallery_album where active=1 order by title_".$lang." ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List Album : ".$e->getMessage();
		}
	}
	
	function get_option_album(){
			try{
			
			$sql = "select * ";
			$sql .= "from gallery_album where active=1 order by title_th ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Option Album : ".$e->getMessage();
		}
	}
	
	
	function get_fetch_list($start_fetch,$max_fetch){
			try{
			$sql = " select g.*,a.title_th as album_th ,a.title_en as album_en from gallery g  ";
			$sql .= " inner join gallery_album a on g.album_id = a.id ";
			$sql .= " order by g.id desc " ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("Gallery > get_fetch_list > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list gallery  : ".$e->getMessage();
		}
	}
	
	function get_fetch_list_album($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from gallery_album ";
			$sql .= " order by id desc " ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("Gallery > get_fetch_list_album > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list gallery album  : ".$e->getMessage();
		}
	}
	
	function get_gallery_info($id){
		try{

			$sql = "select * ";
			$sql .= " from gallery where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Gallery info: ".$e->getMessage();
		}
	}
	
	function get_album_info($id){
		try{

			$sql = "select * ";
			$sql .= " from gallery_album where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Gallery Album info: ".$e->getMessage();
		}
	}
	
	function insert_item($items){
		
		try{
			$album_type  =$items["album_type"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$image = $items["image"];
			$thumbnail = $items["thumbnail"];

			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into gallery (album_id, title_th ,title_en ,image,thumbnail ,active ,create_by ,create_date ) ";
			$sql .= "values($album_type , '$title_th'  ,'$title_en','$image'  ,'$thumbnail' ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			
			log_debug("Gallery > insert  > " .$sql);
			
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Gallery : ".$e->getMessage();
		}
		
	}
	
	function insert_album($items){
		
		try{
			
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$cover = $items["cover"];

			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into gallery_album (title_th ,title_en ,cover ,active ,create_by ,create_date ) ";
			$sql .= "values('$title_th'  ,'$title_en','$cover' ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("Gallery > insert  > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Gallery : ".$e->getMessage();
		}
		
	}
	
	function update_item($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$album_type  =$items["album_type"];
			$image = "";
			$thumbnail = "";
			
			if($items["image"]){
				$image=" ,image='".$items["image"]."' ";	
			}
			
			if($items["thumbnail"]){
				$thumbnail=" ,thumbnail='".$items["thumbnail"]."' ";	
			}
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
			//title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date
			
			$sql = "update gallery set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,album_id=$album_type ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= $image ." " . $thumbnail;
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("Gallery > update > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Gallery  : ".$e->getMessage();
		}
	}
	
	function update_album($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$cover = "";
			
			if($items["cover"]){
				$cover=",cover='".$items["cover"]."' ";	
			}
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';

			$sql = "update gallery_album set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= $cover ;
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("Gallery album> update > " .$sql);
			
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Gallery Album : ".$e->getMessage();
		}
	}
	
	function delete_item($id){
		
		try{
			$sql = "delete from gallery where id=$id ; ";
			log_debug("Gallery > delete > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Gallery : ".$e->getMessage();
		}
	}
	
	function delete_album($id){
		
		try{
			$sql = "delete from gallery_album where id=$id ; ";
			log_debug("Gallery > delete > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Gallery : ".$e->getMessage();
		}
	}
	
}

?>
