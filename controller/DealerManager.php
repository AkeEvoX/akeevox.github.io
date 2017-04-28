<?php
require_once($base_dir."/lib/database.php");

class DealerManager{

	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial dealer manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getItem($id,$lang){

		try{

			$sql = "select id,title_".$lang." as title ,province_".$lang." as province ,zone_".$lang." as zone, mobile_".$lang." as mobile , ,link_".$lang." as link ";
			$sql .= "from dealer where active=1 order by title_".$lang." asc";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  dealer : ".$e->getMessage();
		}

	}

	function getListItem($lang){
			try{
			$sql = "select id,title_".$lang." as title ,province_".$lang." as province ,zone_".$lang." as zone, mobile_".$lang." as mobile ,link_".$lang." as link ";
			$sql .= " from dealer where active=1 ";
			$sql .= " order by title_".$lang." asc ";

			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get List dealer : ".$e->getMessage();
		}
	}

		function findName($lang,$name) {
			try{

				$sql = "select id,title_".$lang." as title ,province_".$lang." as province ,zone_".$lang." as zone, mobile_".$lang." as mobile ,link_".$lang." as link ";
				$sql .= " from dealer where active=1 ";
				$sql .= " and title_".$lang." like '%".$name."%' ";
				$sql .= " order by title_".$lang." asc ";

				$result = $this->mysql->execute($sql);
				return  $result;
			}
			catch(Exception $e){
				return "Cannot Get find dealer : " .$e->getMessage();
		 }
	}

	function get_fetch_list($start_fetch,$max_fetch){
			try{
			$sql = " select * from dealer  ";
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("Dealer > get_fetch_list > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get list dealer  : ".$e->getMessage();
		}
	}
	
		
	function get_dealer_info($id){
		try{

			$sql = "select * ";
			$sql .= " from dealer where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Dealer info: ".$e->getMessage();
		}
	}
	
	function insert_item($items){
		
		try{
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$province_th  =$items["province_th"];
			$province_en  =$items["province_en"];
			$zone_th  =$items["zone_th"];
			$zone_en  =$items["zone_en"];
			$link_th  =$items["link_th"];
			$link_en  =$items["link_en"];
			$mobile_th = $items["mobile_th"];
			$mobile_en = $items["mobile_en"];
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into dealer (title_th ,title_en,province_th,province_en,zone_th,zone_en,link_th,link_en,mobile_th,mobile_en ,active ,create_by ,create_date ) ";
			$sql .= "values('$title_th' ,'$title_en','$province_th'  ,'$province_en','$zone_th','$zone_en','$link_th','$link_en','$mobile_th','$mobile_en',$active ,$create_by,$create_date); ";
			$this->mysql->execute($sql);
			
			log_debug("dealer > insert  > " .$sql);
			
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert dealer : ".$e->getMessage();
		}
		
	}


	function update_item($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$province_th  =$items["province_th"];
			$province_en  =$items["province_en"];
			$zone_th  =$items["zone_th"];
			$zone_en  =$items["zone_en"];
			$mobile_th = $items["mobile_th"];
			$mobile_en = $items["mobile_en"];
			$link_th  ="";
			$link_en  ="";
			
			if($items["link_th"]){
				$link_th=" ,link_th='".$items["link_th"]."' ";	
			}
			
			if($items["link_en"]){
				$link_en=" ,link_en='".$items["link_en"]."' ";	
			}
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
			
			$sql = "update dealer set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,province_th='$province_th',province_en='$province_en',zone_th='$zone_th',zone_en='$zone_en',mobile_th='$mobile_th',mobile_en='$mobile_en' ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= $link_th ;
			$sql .= $link_en ;
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("Dealer > update > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Dealer  : ".$e->getMessage();
		}
	}

	function delete_item($id){
		
		try{
			$sql = "delete from dealer where id=$id ; ";
			log_debug("Delaer > delete > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Delaer : ".$e->getMessage();
		}
	}

}

?>
