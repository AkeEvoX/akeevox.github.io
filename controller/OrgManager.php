<?php
require_once("../lib/database.php");
//include("../../../controller/logger.php");

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
			$sql .= " from organization_executive where active=1 order by create_date desc ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get  Organization : ".$e->getMessage();
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





}

?>
