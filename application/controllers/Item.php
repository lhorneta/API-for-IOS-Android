<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('Item_model');
	}
	
	public function index() {
		$result = array('error' => 'No method selected');
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	
	/*public function lists() {
		$res = (object) array('error'=>false, 'response'=>(object) array(), 'response_text'=>'', 'success'=>false);
		if ($_SERVER['REQUEST_METHOD']==='GET') {
			$id = isset($_GET['uid'])?$_GET['uid']:0;
			$token = isset($_GET['token'])?$_GET['token']:'';
			$page = isset($_GET['p'])?$_GET['p']:'';
			$count = isset($_GET['count'])?$_GET['count']:'';
		} else {
			$id = isset($_POST['uid'])?$_POST['uid']:0;
			$token = isset($_POST['token'])?$_POST['token']:'';
			$page = isset($_POST['p'])?$_POST['p']:'';
			$count = isset($_POST['count'])?$_POST['count']:'';
		}
		if ($id) {
			if ($token){
				$auth = $this->Users_model->token($token);
				if ($auth) {
					if ($id==$auth['uid']) {
						$result = $this->Messages_model->dialogs($id, $page, $count);
						$res->success = true;
						$res->response = array('count'=>count($result), 'list'=>$result);
					} else {
						$res->error = true;
						$res->response_text = 'Access to another\'s dialogs is forbidden';
					}
				} else {
					$res->error = true;
					$res->response_text = 'Invalid access token';
				}
			} else {
				$res->error = true;
				$res->response_text = 'Unknown token';
			}
		} else {
			$res->error = true;
			$res->response_text = 'Unknown user id';
		}
		header('Content-Type: application/json');
		echo json_encode($res);
	}*/
	
	public function search() {
		$res = (object) array('error'=>false, 'response'=>(object) array(), 'response_text'=>'', 'success'=>false);
		if ($_SERVER['REQUEST_METHOD']==='GET') {
			$search = isset($_GET['search'])?$_GET['search']:0;
		} else {
			$search = isset($_POST['search'])?$_POST['search']:0;
		}
		
		if ($search) {
				$result = $this->Item_model->search($search);
				$res->success = true;
				$res->response = array('count'=>count($result), 'list'=>$result);
		
		} else {
			$res->error = true;
			$res->response_text = 'Not found any item';
		}
		
		header('Content-Type: application/json');
		echo json_encode($res);
	}

	public function lists($page=1, $count=20) {
		$res = (object) array('error'=>false, 'response'=>(object) array(), 'response_text'=>'', 'success'=>false);
		if ($_SERVER['REQUEST_METHOD']==='GET') {
			$page = isset($_GET['page'])?$_GET['page']:'';
			$count = isset($_GET['count'])?$_GET['count']:$count;
		} else {
			$page = isset($_GET['page'])?$_POST['page']:'';
			$count = isset($_GET['count'])?$_POST['count']:$count;
		}

		if ($page) {
			$result = $this->Item_model->getallitems($page, $count);
			$res->success = true;
			if(!$result){$res->response_text = 'Not found any item';}
			$res->response = array('count'=>count($result), 'list'=>$result);
		
		} else {
			$res->error = true;
			$res->response_text = 'Not found any item';
		}
		
		header('Content-Type: application/json');
		echo json_encode($res);
	}

	public function item($id=0) {
		$res = (object) array('error'=>false, 'response'=>(object) array(), 'response_text'=>'', 'success'=>false);
		if ($_SERVER['REQUEST_METHOD']==='GET') {
			$id = isset($_GET['id'])?$_GET['id']:'';
		} else {
			$id = isset($_GET['id'])?$_POST['id']:'';
		}

		if ($id) {
			$result = $this->Item_model->getitembyid($id);
			$res->success = true;
			if(!$result){$res->response_text = 'Not found any item';}
			$res->response = array('count'=>count($result), 'list'=>$result);
		
		} else {
			$res->error = true;
			$res->response_text = 'Not found any item';
		}
		
		header('Content-Type: application/json');
		echo json_encode($res);
	}
	
	
}
