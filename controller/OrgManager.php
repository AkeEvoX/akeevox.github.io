<?php
require_once($base_dir."/lib/database.php");

class OrgManager{

	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial Organization manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function getlistItem($lang){

		try{

			$sql = "select id,name_".$lang." as name,position_".$lang." as position, education_".$lang." as education ,work_".$lang." as work,shareholder,image,age ";
			$sql .= " from organization_personal where active=1 order by create_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Organization : ".$e->getMessage();
		}

	}

	function getPersonalList(){

		try{

			$sql = "select * ";
			$sql .= " from organization_personal order by create_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Perosonal List : ".$e->getMessage();
		}

	}
	
	function getPersonal($id){
		
			try{

			$sql = "select * from organization_personal ";
			$sql .= "where id=$id order by create_date desc ";
			$result = $this->mysql->execute($sql);
			log_debug("OrgManager > getPersonal > " .$sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Perosonal : ".$e->getMessage();
		}
	}
	
	function getchart($lang)
	{
		try{

			$sql = "select id, chart_".$lang." as chart ,update_date ";
			$sql .= " from organization_chart where active=1 order by update_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Chart: ".$e->getMessage();
		}

	}
	
	function get_chart_info($id){
		try{

			$sql = "select id,chart_th,chart_en ";
			$sql .= " from organization_chart where active=1 order by update_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Chart info: ".$e->getMessage();
		}
	}


	function getintermarket()
	{
		try{

			$sql = "select id, chart ,update_date ";
			$sql .= " from organization_intermarket where active=1 order by update_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization InterMarket : ".$e->getMessage();
		}

	}
	
	function getmarketcontury($lang){
		try{

			$sql = "select id, title_".$lang." title";
			$sql .= " from org_market_countries where active=1 order by update_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Market Contury : ".$e->getMessage();
		}
	}

	function getReferenceList($lang)
	{
		try{

			$sql = "select id,title_".$lang." as title , detail_".$lang." as detail ,contury_".$lang." as contury , thumbnail,image , update_date ,islocal ";
			$sql .= " from organization_reference where active=1 order by update_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Reference: ".$e->getMessage();
		}
	}

	function getReferalID($lang,$id)
	{
		try{

			$sql = "select id,title_".$lang." as title , detail_".$lang." as detail ,contury_".$lang." as contury ,thumbnail,image , update_date ,islocal ";
			$sql .= " from organization_reference where active=1 and id=".$id." order by update_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Reference by id : ".$e->getMessage();
		}
	}

	function getProjectList($lang,$local){

		try{

		
			$sql = " select id,title_".$lang." as title  ,location_".$lang." as location ";
			$sql .= " from project_reference where active=1 and islocal=".$local." order by title_".$lang." ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Reference Project List : ".$e->getMessage();
		}

	}
	
	function insert_personal($items){
		
		try{
			
			$name_th =$items["name_th"];
			$position_th=$items["position_th"];
			$education_th=$items["education_th"];
			$work_th=$items["work_th"];
			$name_en=$items["name_en"];
			$position_en=$items["position_en"];
			$education_en=$items["education_en"];
			$work_en=$items["work_en"];
			$shareholder=$items["shareholder"];
			$image=$items["image"];
			$age=$items["age"];
			
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into organization_personal (name_th,position_th,education_th,work_th,name_en,position_en,education_en,work_en,shareholder,image,active,create_by,create_date) ";
			$sql .= "values('$name_th','$position_th','$education_th','$work_th','$name_en','$position_en','$education_en','$work_en','$shareholder','$image',$active,$create_by,$create_date); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("OrgManager > insert_personal > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Organization Personal : ".$e->getMessage();
		}
		
	}
	
	function update_personal($items){
		try{
			$id = $items["id"];
			$name_th =$items["name_th"];
			$position_th=$items["position_th"];
			$education_th=$items["education_th"];
			$work_th=$items["work_th"];
			$name_en=$items["name_en"];
			$position_en=$items["position_en"];
			$education_en=$items["education_en"];
			$work_en=$items["work_en"];
			$shareholder=$items["shareholder"];
			$image = "";
			
			if($items["image"]){
				$image=",image='".$items["image"]."' ";	
			}
			
			$age=$items["age"];
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
			
			$sql = "update organization_personal set  ";
			$sql .= "name_th='$name_th',position_th='$position_th',education_th='$education_th',work_th='$work_th' ";
			$sql .= ",name_en='$name_en',position_en='$position_en',education_en='$education_en',work_en='$work_en' $image ,active=$active,update_by=$update_by,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("OrgManager > update_personal > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Organization Personal : ".$e->getMessage();
		}
	}
	
	function update_chart($items){
		try{
			
			$chart_th = "";
			$chart_en = "";
			$id = $items["id"];
			if($items["chart_th"]){
				$chart_th=" ,chart_th='".$items["chart_th"]."' ";	
			}
				if($items["chart_en"]){
				$chart_en=" ,chart_en='".$items["chart_en"]."' ";	
			}
			
			$update_by='0';
			$update_date='now()';
			
			$sql = "update organization_chart set  ";
			$sql .= "update_by=$update_by,update_date=$update_date " ;
			$sql .= $chart_th ;
			$sql .= $chart_en;
			$sql .= "where id=$id; ";
			$this->mysql->execute($sql);
			
			log_debug("OrgManager > update_chart > " .$sql);

			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Organization Chart : ".$e->getMessage();
		}
	}
	
	function delete_personal($id){
		
		try{
			/*flag delete 
			** can delete manual with your self. prevent data is lost
			*/
			$sql = "delete from organization_personal where id=$id ; ";
			log_debug("OrgManager > delete_personal > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete personal : ".$e->getMessage();
		}
	}

	
}

?>
