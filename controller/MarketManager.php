<?php
require_once($base_dir."/lib/database.php");

class MarketManager{

	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)		{
			die("initial Market of organization manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}


	function get_info(){
		try{

			$sql = "select * ";
			$sql .= " from organization_intermarket ";
			$result = $this->mysql->execute($sql);

			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Get Organization Market info: ".$e->getMessage();
		}
	}
	
	
	function update_item($items){
		try{
			$id = $items["id"];
			
			if($items["chart_th"])
				$chart_th  = "chart_th='".$items["chart_th"] ."' ";
			
			if($items["chart_en"])
				$chart_en  = "chart_en='".$items["chart_en"] ."' ";
			
			$active='0';
			
			if(isset($items["active"]))	$active='1';
			
			$update_by='0';
			$update_date='now()';
			
			$sql = "update organization_intermarket set  ";
			$sql .= $chart_th;
			$sql .= $chart_en;
			$sql .= ",update_by=$update_by ,update_date=$update_date  ";
			$sql .= "where id=$id ;";
			$this->mysql->execute($sql);
			
			log_debug("Metket Manager > update > " .$sql);
			$result = $this->mysql->newid();
			
			return  $result;
		}
		catch(Exception $e){
			echo "Cannot Update Organization Market Cover : ".$e->getMessage();
		}
	}
	
}

?>
