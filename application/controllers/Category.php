<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('Users_model');
	}
	
	public function index() {
		$result = array('error' => 'No method selected');
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	
	/* User profile */
	public function profile() {
		$id = isset($_REQUEST['uid'])?(int)$_REQUEST['uid']:0;
		$token = isset($_REQUEST['token'])?$_REQUEST['token']:'';
		$fields = isset($_REQUEST['fields'])?$_REQUEST['fields']:'';
		$res = (object) array('error'=>false, 'response'=>(object)array(), 'response_text'=>'', 'success'=>false);
		if ($id>0) {
			// if ($token) {
				// $auth = $this->Users_model->token($token);
				// if ($auth) {
					$user = $this->Users_model->profile($id, $fields);
					$res->response = $user;
					$res->response['follow']=0;
					if ($token) {
						$auth = $this->Users_model->token($token);
						if ($auth) {
							$follower = $this->db->get_where('followers', array('follower'=>$id, 'following'=>$auth['uid']));
							$following = $this->db->get_where('followers', array('follower'=>$auth['uid'], 'following'=>$id));
							if ($follower->num_rows>0) {
								$res->response['follow']=1;
							}
							if ($following->num_rows>0) {
								$res->response['follow']=2;
							}
						}
					}
					
					$res->success = true;
					
				// } else {
					// $res->error = true;
					// $res->response_text = 'Invalid access token';
				// }
			// } else {
				// $res->error = true;
				// $res->response_text = 'Unknown token';
			// }
			
		} else {
			$res->error = true;
			$res->response_text = 'Unknown user id';
		}
		header('Content-Type: application/json');
		echo json_encode($res);
	}
	
	
	/* Edit profile */
	public function editprofile() {
		$uid = isset($_REQUEST['uid'])?(int)$_REQUEST['uid']:'';
		$token = isset($_REQUEST['token'])?$_REQUEST['token']:'';
		$email = isset($_REQUEST['email'])?$_REQUEST['email']:'';
		$username = isset($_REQUEST['username'])?$_REQUEST['username']:'';
		$fullname = isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'';
		$bio = isset($_REQUEST['bio'])?$_REQUEST['bio']:'';
		//$avatar = isset($_REQUEST['avatar'])?$_REQUEST['avatar']:'';
		$cover = isset($_REQUEST['cover'])?$_REQUEST['cover']:'';
		$phone = isset($_REQUEST['phone'])?$_REQUEST['phone']:'';
		$gender = isset($_REQUEST['gender'])?$_REQUEST['gender']:'';
		$res = (object) array('error'=>false, 'response'=>(object)array(), 'response_text'=>'', 'success'=>false);
		if ($uid) {
			if ($token) {
				$auth = $this->Users_model->token($token);
				if ($auth) {
					if ($email) {
						if ($username) {
							$checkusername = $this->Users_model->checkusername($uid, $username);
							if ($checkusername==0) {
								$avatar = false;
								if (isset($_FILES['avatar'])&&$_FILES['avatar']) {
									$file = $_FILES['avatar'];
									$upload_url="uploads/users";
									$upload_path = $_SERVER['DOCUMENT_ROOT']."/uploads/users/";
									
									if($file['error']==0){
										$name = explode(".", $file['name']);
										$type = end($name);
										
										$uploadfile = $auth['uid']."_".substr(md5(date("Y-m-d H:i:s")), 0,10)."_1.".$type;
										if (move_uploaded_file($file['tmp_name'], $upload_path.$uploadfile)) {
										    $avatar = base_url().$upload_url."/".$uploadfile;
										} else {
										    $res->error = true;
											$res->response_text = 'Upload failed';
										}
									}
								}
								
								if (!$res->error) {
									$data = array(
										'email' => $email,
										'username' => $username,
										'fullname' => $fullname,
										'bio' => $bio,
										'phone' => $phone,
										'gender' => (int)$gender
									);
									if ($avatar) {
										$data['avatar'] = $avatar;
									}
									$edit = $this->Users_model->editprofile($uid, $data);
									
									if ($edit) {
										$res->success = true;
										$res->response_text = 'Profile information saved';
									} else {
										$res->error = true;
										$res->response_text = 'Edit profile error';
									}
								}
							} else {
								$res->error = true;
								$res->response_text = 'User name is not available';
							}
						} else {
							$res->error = true;
							$res->response_text = 'User name is empty';
						}
					} else {
						$res->error = true;
						$res->response_text = 'E-mail is empty';
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
	}

	/* Users list */
	public function lists() {
		$token = isset($_REQUEST['token'])?$_REQUEST['token']:'';
		$fields = isset($_REQUEST['fields'])?$_REQUEST['fields']:'';
		$page = isset($_REQUEST['p'])?$_REQUEST['p']:'';
		$q = isset($_REQUEST['q'])?$_REQUEST['q']:'';
		$count = isset($_REQUEST['count'])?$_REQUEST['count']:'';
		$sort = isset($_REQUEST['sort'])?$_REQUEST['sort']:'';
		$res = (object) array('error'=>false, 'response'=>(object)array(), 'response_text'=>'', 'success'=>false);
			
		if ($token) {
			$auth = $this->Users_model->token($token);
			if ($auth) {
				$followings = $this->Users_model->lists($fields, $page, $count, $q, $sort, $auth['uid']);
				$countfollowings = $this->Users_model->countlists($fields, $q);
				$res->success = true;
				$res->response = array('count'=>$countfollowings, 'list'=>$followings);
			} else {
				$res->error = true;
				$res->response_text = 'Invalid access token';
			}
		} else {
			$res->error = true;
			$res->response_text = 'Unknown token';
		}
		
		header('Content-Type: application/json');
		echo json_encode($res);
	}
	
	
}
