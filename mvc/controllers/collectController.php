<?php 
/**
 * 
 */
require_once(CORE."data.php");
class collectController extends controller
{
	
	function __construct()
	{		
	}

	function receive(){		
		if(isset($_GET)){
			$data = $_GET;
			if(array_key_exists("url",$data)){
				unset($data['url']);
			}
			$data_keys = array_keys($data);
			$amount = count($data_keys);
			$data_string = "";
			$fileName = "receive.txt";
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$time = date('Y-m-d H:i:s');
			foreach ($data_keys as $key) {
				$data_string =  $time ."=".$key."=".$data[$key]."\n";
				$dataString = $this->dataProcess($data_string);
				$myfile = fopen(FILES.$fileName, "a+");			
				fwrite($myfile, $dataString."\n");        
				fclose($myfile); 
			}
			if($amount != 0){
				$read = file(FILES.$fileName);
				$len = count($read);
				for ($i = $len-$amount; $i < $len; $i++) {
					echo $read[$i];	
				}
			}
		}
		$read = file(FILES.$fileName);
		// echo $this->dataProcess($read[count($read) - 1]);
		// echo $read[count($read)-1];
	}

	function store()
	{
		if(isset($_GET)){
			$data = $_GET;
			if(array_key_exists("url",$data)){
				unset($data['url']);
			}
			$data_keys = array_keys($data);
			$amount = count($data_keys);
			$data_string = "";
			$fileName = "receive.txt";
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$time = date('Y-m-d H:i:s');
			$dataModel = new data;
			foreach ($data_keys as $key) {
				$data_string =  $time ."=".$key."=".$data[$key]."\n";
				$dataString = $this->dataProcess($data_string);
				$dataObj = json_decode($dataString,true);
				$dataModel->InsertObject("giatri",$dataObj);
			}
		}
	}

	function load($ma_tram){
		$dataObj = new data;
		$getSensorMeasures = "SELECT DISTINCT `ma_cambien`, `ma_dailuong` FROM giatri WHERE  `ma_tram` = '$ma_tram'";
		$number_of_sensors = "SELECT DISTINCT `ma_cambien` FROM `giatri` WHERE `ma_tram` = '$ma_tram'";	
		$result = $dataObj->execute($getSensorMeasures);	
		$result2 = $dataObj->execute($number_of_sensors);
		
		$cambienObject = $this->model("cambien");

		$listSensorMeasures = [];
		$listSensorOfStation = [];
		if($result2){
			while ($row = $result2->fetch_assoc()) {
				$sensorKey = $row['ma_cambien'];
				array_push($listSensorOfStation,json_decode($cambienObject->getByKey($sensorKey),true));
			}
		}

		if($result){
			while ($row = $result->fetch_assoc()) {				
				array_push($listSensorMeasures,$row);
			}	

			$nguoiquanlyObject = $this->model("nguoiquanly"); // mặc định vì phải có vì phải đang nhập mới sử dụng 
			$tramquantracObject = $this->model("tramquantrac");
			$donvido = $this->model("donvido");
			$nguoiquanlyObj = $nguoiquanlyObject->getByKey($_SESSION['taikhoan_nql'],$_SESSION['adm']);
			$tramquantracObj = $tramquantracObject->getByKey($ma_tram);
			$donvidoList = $donvido->listAll();
			//view			
			$model = "tramquantrac";
			$model_view = strtolower($model)."-view";		
			$pages		= "detail";

			$dataSend = [
				"model-view"=>$model_view, // cambien-view
				"model"		=>$model, // CamBien
				"pages"		=>$pages,					
				"nql_obj"   =>$nguoiquanlyObj,
				"tram_obj"  =>$tramquantracObj,
				"unitsList" =>$donvidoList,
				"sensorsStationList" =>json_encode($listSensorOfStation),
 				"sensorMeasuresList"=>json_encode($listSensorMeasures)
			];
			
			$this->view("masterLayout",$dataSend);
		}		
	}


	function get($ma_tram,$ma_cambien,$ma_dailuong)
	{
		$getLatestVal = "SELECT `giatri`,`thoigian` FROM `giatri` WHERE `ma_tram` = '$ma_tram' AND `ma_cambien` = '$ma_cambien' AND `ma_dailuong` = '$ma_dailuong' ORDER BY thoigian DESC LIMIT 1";
		$dataObj = new data;
		$result = $dataObj->execute($getLatestVal);		
		if($result->num_rows==1){
			$val = $result->fetch_assoc();
			$myVal = [
				"val"=>$val['giatri'],
				"time"=>$val['thoigian']
			];
			echo json_encode($myVal);
		}else{
			echo 'null';
		}
	}


	function addDL($ma_tram,$ma_cambien)
	{	

		$number_of_measures = "SELECT DISTINCT `ma_dailuong` FROM giatri WHERE `ma_tram` = '$ma_tram' AND `ma_cambien` = '$ma_cambien'";

		$dailuongdoObject = $this->model("dailuongdo");
		$cambienObject = $this->model("cambien");

		$dataObj = new data;
		$result = $dataObj->execute($number_of_measures);
		$list = [];

		if($result){
			while ($row = $result->fetch_assoc()) {			
				$measureKey = $row['ma_dailuong'];
				array_push($list,json_decode($dailuongdoObject->getByKey($measureKey),true));
			}

			$model = "dailuongdo";
			$model_view = strtolower($model)."-view";		
			$pages		= "add-form";
			$nguoiquanlyObject = $this->model("nguoiquanly"); // mặc định vì phải có vì phải đang nhập mới sử dụng 
			$tramquantracObject = $this->model("tramquantrac");
			$tramquantracObj = $tramquantracObject->getByKey($ma_tram);
			$nguoiquanlyObj = $nguoiquanlyObject->getByKey($_SESSION['taikhoan_nql'],$_SESSION['adm']);
			$cambienObj = $cambienObject->getByKey($ma_cambien);

			$dataSend = [
				"model-view"=>$model_view, // cambien-view
				"model"		=>$model, // CamBien
				"pages"		=>$pages,					
				"nql_obj"   =>$nguoiquanlyObj,
				"cb_obj"	=>$cambienObj,
				"tram_obj"  =>$tramquantracObj,
				"listMeasuresBySensor"=>json_encode($list)
			];
			
			$this->view("masterLayout",$dataSend);
		}
	}

	function addCB($ma_tram){
		$number_of_sensors = "SELECT DISTINCT `ma_cambien` FROM `giatri` WHERE `ma_tram` = '$ma_tram'";	
		$cambienObject = $this->model("cambien");
		$dataObj = new data;
		$result = $dataObj->execute($number_of_sensors);
		$list = [];

		if($result){
			while ($row = $result->fetch_assoc()) {
				$sensorKey = $row['ma_cambien'];
				array_push($list,json_decode($cambienObject->getByKey($sensorKey),true));
			}
			$model = "cambien";
			$model_view = strtolower($model)."-view";		
			$pages		= "add-form";
			$nguoiquanlyObject = $this->model("nguoiquanly"); // mặc định vì phải có vì phải đang nhập mới sử dụng 
			$tramquantracObject = $this->model("tramquantrac");


			$nguoiquanlyObj = $nguoiquanlyObject->getByKey($_SESSION['taikhoan_nql'],$_SESSION['adm']);
			$tramquantracObj = $tramquantracObject->getByKey($ma_tram);			

			$dataSend = [
				"model-view"=>$model_view, // cambien-view
				"model"		=>$model, // CamBien
				"pages"		=>$pages,					
				"nql_obj"   =>$nguoiquanlyObj,				
				"tram_obj"  =>$tramquantracObj,
				"listSensorsByStation"=>json_encode($list)
			];
			
			$this->view("masterLayout",$dataSend);
		}		
	}


	function editDL($ma_tram,$ma_dailuong)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && $ma_tram && $ma_dailuong){
			// print_r($_POST);
			$model = $this->model("dailuongdo");
			if(isset($_POST['key']) && isset($_POST['val'])){
				echo $model->edit($key,$_POST['key'],$_POST['val']);	
			}else{
				if(method_exists($model,"update"))
					$model->update($ma_dailuong,$_POST);					
				$this->load($ma_tram);
			}
		}
	}

	function chart($ma_tram,$ma_cambien,$ma_dailuong)
	{
		// thông tin mặc định cho một trang show
		$model = "tramquantrac";
		$model_view = strtolower($model)."-view";
		$pages		= "chart-type";
		$nguoiquanlyObject = $this->model("nguoiquanly");
		$nguoiquanlyObj = $nguoiquanlyObject->getByKey($_SESSION['taikhoan_nql'],$_SESSION['adm']);
		$keys = ["ma_tram"=>$ma_tram,"ma_cambien"=>$ma_cambien,"ma_dailuong"=>$ma_dailuong];
		$data = [
			"model-view" =>$model_view, //cambien-view
			"model"		 =>$model, //CamBien
			"pages"		 =>$pages,
			"keys"		 =>json_encode($keys),
			"nql_obj"	 =>$nguoiquanlyObj
		];
		$this->view("masterLayout",$data);
	}

	//input string : 2020-07-28 15:36:40=1_1_1=123
	private function dataProcess($dataString){
		$row = explode("=",$dataString);		
		$time = $row[0];
		$keys = explode("_",$row[1]);
		$resultData = [];
		$resultData["thoigian"] = $row[0];
		$resultData["ma_tram"] = $keys[0];
		$resultData["ma_cambien"] = $keys[1];
		$resultData["ma_dailuong"] = $keys[2];
		$resultData["giatri"] = trim($row[2]);
		return json_encode($resultData);
	}
}	
?>
