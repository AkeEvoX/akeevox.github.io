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
		catch(Exception $e)		{
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
	
	function getchart($lang){
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

	function getintermarket($lang){
		try{

			$sql = "select id, chart_".$lang."  as chart,update_date ";
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

	function getReferenceList($lang){
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

	function getReferalID($lang,$id){
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

	function get_refer_info($id){
		try{

			$sql = "select * ";
			$sql .= " from organization_reference where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Reference info: ".$e->getMessage();
		}
	}
	
	function get_project_info($id){
		try{

			$sql = "select * ";
			$sql .= " from project_reference where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Project info: ".$e->getMessage();
		}
	}
	
	function get_market_info($id){
		try{

			$sql = "select * ";
			$sql .= " from org_market_countries where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Market info: ".$e->getMessage();
		}
	}
	
	function get_award_info($id){
		try{

			$sql = "select * ";
			$sql .= " from award where id=$id ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Award info: ".$e->getMessage();
		}
	}

	function get_list_reference_fetch($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from organization_reference a ";
			$sql .= " order by id desc" ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("OrgManager > get_list_reference_fetch > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list reference  : ".$e->getMessage();
		}
	}
	
	function get_list_project_fetch($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from project_reference a ";
			$sql .= " order by id desc" ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("OrgManager > get_list_project_fetch > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list project  : ".$e->getMessage();
		}
	}
	
	function get_list_market_fetch($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from org_market_countries a ";
			$sql .= " order by id desc" ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("OrgManager > get_list_market_fetch > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list market  : ".$e->getMessage();
		}
	}
	
	function get_list_award_fetch($start_fetch,$max_fetch){
			try{

			$sql = " select * ";
			$sql .= " from award a ";
			$sql .= " order by id desc" ;
			$sql .= " LIMIT $start_fetch,$max_fetch ;";
			log_debug("OrgManager > get_list_award_fetch > ".$sql);
			$result = $this->mysql->execute($sql);
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  list award  : ".$e->getMessage();
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
	
	function insert_reference($items){
		
		try{
			
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$detail_th =$items["detail_th"];
			$detail_en =$items["detail_en"];
			$contury_th =$items["contury_th"];
			$contury_en =$items["contury_en"];
			$islocal  =$items["islocal"];
			$thumbnail= $items["thumbnail"];
			$image =  $items["image"];
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into organization_reference (title_th  ,title_en  ,detail_th ,detail_en ,contury_th ,contury_en ,thumbnail ,image  ,islocal  ,create_by  ,create_date  ,active ) ";
			$sql .= "values('$title_th'  ,'$title_en'  ,'$detail_th' ,'$detail_en' ,'$contury_th' ,'$contury_en' ,'$thumbnail' ,'$image'  ,$islocal  ,$create_by  ,$create_date  ,$active); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("OrgManager > insert_reference > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Organization Reference : ".$e->getMessage();
		}
		
	}
	
	function insert_project($items){
		
		try{
			
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$location_th =$items["location_th"];
			$location_en =$items["location_en"];
			$islocal  =$items["islocal"];
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into project_reference (title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date ) ";
			$sql .= "values('$title_th'  ,'$title_en'  ,'$location_th' ,'$location_en' ,$islocal  ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("OrgManager > insert_project  > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Organization Project : ".$e->getMessage();
		}
		
	}
	
	function insert_market($items){
		
		try{
			
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into org_market_countries (title_th ,title_en ,active ,create_by ,create_date ) ";
			$sql .= "values('$title_th'  ,'$title_en' ,$active ,$create_by  ,$create_date ); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("OrgManager > insert_market  > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Organization Market : ".$e->getMessage();
		}
		
	}
	
	function insert_award($items){
		
		try{
			
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$detail_th =$items["detail_th"];
			$detail_en =$items["detail_en"];
			$thumbnail= $items["thumbnail"];
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$create_by='0';
			$create_date='now()';
			
			$sql = "insert into award (title_th  ,title_en  ,detail_th ,detail_en ,thumbnail ,create_by  ,create_date  ,active ) ";
			$sql .= "values('$title_th'  ,'$title_en'  ,'$detail_th' ,'$detail_en' ,'$thumbnail'   ,$create_by  ,$create_date  ,$active); ";
			$this->mysql->execute($sql);
			//echo $sql;
			
			log_debug("OrgManager > insert_award > " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Insert Organization Award : ".$e->getMessage();
		}
		
	}
	
	function update_award($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$detail_th =$items["detail_th"];
			$detail_en =$items["detail_en"];
			$thumbnail= "";

			if($items["thumbnail"]){
				$thumbnail=",thumbnail='".$items["thumbnail"]."' ";	
			}
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
		
			$sql = "update award set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,detail_th='$detail_th' ,detail_en='$detail_en' ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date $thumbnail ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("OrgManager > update_award> " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Organization Award : ".$e->getMessage();
		}
	}
	
	function update_market($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
			//title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date
			
			$sql = "update org_market_countries set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ";
			$sql .= ",active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("OrgManager > update_market> " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Organization Market : ".$e->getMessage();
		}
	}
	
	function update_project($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$location_th =$items["location_th"];
			$location_en =$items["location_en"];
			$islocal  =$items["islocal"];
		
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
			//title_th ,title_en  ,location_th ,location_en  ,islocal ,active ,create_by ,create_date
			
			$sql = "update project_reference set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,location_th='$location_th' ,location_en='$location_en' ";
			$sql .= ",islocal='$islocal' ,active=$active ,update_by=$update_by ,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("OrgManager > update_project> " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Organization Project : ".$e->getMessage();
		}
	}
	
	function update_reference($items){
		try{
			$id = $items["id"];
			$title_th  =$items["title_th"];
			$title_en  =$items["title_en"];
			$detail_th =$items["detail_th"];
			$detail_en =$items["detail_en"];
			$contury_th =$items["contury_th"];
			$contury_en =$items["contury_en"];
			$islocal  =$items["islocal"];
			$thumbnail= $items["thumbnail"];
			$image = "";
			
			if($items["image"]){
				$image=",image='".$items["image"]."' ";	
			}
			
			if($items["thumbnail"]){
				$thumbnail=",thumbnail='".$items["thumbnail"]."' ";	
			}
		
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
		
			$sql = "update organization_reference set  ";
			$sql .= "title_th='$title_th' ,title_en='$title_en' ,detail_th='$detail_th' ,detail_en='$detail_en' ";
			$sql .= ",contury_th='$contury_th' ,contury_en='$contury_en' ,islocal='$islocal' ,active=$active ,update_by=$update_by ,update_date=$update_date  $image $thumbnail ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("OrgManager > update_reference> " .$sql);
			//get insert id
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Organization Reference : ".$e->getMessage();
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
			echo "Cannot Update Organization Personal : ".$e->getMessage();
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
	
	function update_market_page($items){
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
			
			$sql = "update organization_intermarket set  ";
			$sql .= "update_by=$update_by,update_date=$update_date " ;
			$sql .= $chart_th ;
			$sql .= $chart_en;
			$sql .= "where id=$id; ";
			$this->mysql->execute($sql);
			
			log_debug("OrgManager > InterMarket Page > " .$sql);

			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Organization InterMarket Page : ".$e->getMessage();
		}
	}
	
	function delete_award($id){
		
		try{
			$sql = "delete from award where id=$id ; ";
			log_debug("OrgManager > delete_award > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Organization Award : ".$e->getMessage();
		}
	}
	
	function delete_market($id){
		
		try{
			$sql = "delete from org_market_countries where id=$id ; ";
			log_debug("OrgManager > delete_market > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Organization Market : ".$e->getMessage();
		}
	}
	
	function delete_project($id){
		
		try{
			$sql = "delete from project_reference where id=$id ; ";
			log_debug("OrgManager > delete_project > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Organization Project : ".$e->getMessage();
		}
	}
	
	function delete_reference($id){
		
		try{
			$sql = "delete from organization_reference where id=$id ; ";
			log_debug("OrgManager > delete_reference > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Organization Reference : ".$e->getMessage();
		}
	}
	
	function delete_personal($id){
		
		try{

			$sql = "delete from organization_personal where id=$id ; ";
			log_debug("OrgManager > delete_personal > " .$sql);
			$result = $this->mysql->execute($sql);
			return $result;
		}
		catch(Exception $e){
			echo "Cannot Delete Organization Personal : ".$e->getMessage();
		}
	}

}

?>
