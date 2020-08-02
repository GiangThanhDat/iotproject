<?php 
/**
 * 
 */
class ajaxController extends controller
{

	/*method for model*/

	function add($modelName){
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			$model = $this->model("$modelName");
			echo $model->add($_POST);
		}
	}

	function edit($modelName, $key){
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && $key){
			// print_r($_POST);
			$model = $this->model($modelName);
			if(isset($_POST['key']) && isset($_POST['val'])){
				echo $model->edit($key,$_POST['key'],$_POST['val']);	
			}else{
				if(method_exists($model,"update"))
					$model->update($key,$_POST);
				$controller;
				require_once "adminController.php";
				$adminController = new adminController;
				$adminController->edit($modelName, $key);
			}
		}
	}

	function del($modelName, $key){
		if($modelName && $key){
			$model = $this->model("$modelName");
			echo $model->remove($key);	
		}else
			echo 0;
	}

	function getListByFK($modelName, $FK){
		if($modelName){
			$model = $this->model($modelName);
			echo $model->listFkey($FK);
		}
	}

	function register(){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$nguoiquanlyObj = $this->model("nguoiquanly");
			echo $nguoiquanlyObj->add($_POST);
		}	
	}

	function validation(){
		if($_SERVER['REQUEST_METHOD'] === "POST"){
			$taikhoan_nql = $_POST['taikhoan_nql'];
			echo $this->model("nguoiquanly")->duplicateValidation($taikhoan_nql);
		}
	}	

	function login(){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$nguoiquanlyObj = $this->model("nguoiquanly");
			if(isset($_POST['adminitrator']) && $_POST['adminitrator'] == "on"){	
				unset($_POST['adminitrator']);
				$taikhoan_nql = $nguoiquanlyObj->loginCheck($_POST,true);
				$_SESSION['adm'] = true;
				if ($taikhoan_nql != false) {	
					if(!array_key_exists("taikhoan_nql", $_SESSION)){
						$_SESSION['taikhoan_nql'] = $taikhoan_nql;				
						echo $taikhoan_nql;
					}
				}else{
					echo 0;
				}						
			}else{
				$taikhoan_nql = $nguoiquanlyObj->loginCheck($_POST);		
				$_SESSION['adm'] = false;
				if ($taikhoan_nql != false) {	
					if(!array_key_exists("taikhoan_nql", $_SESSION)){
						$_SESSION['taikhoan_nql'] = $taikhoan_nql;				
						echo $taikhoan_nql;
					}
				}else{
					echo 0;
				}		
			}	
		}
	}
}
?>