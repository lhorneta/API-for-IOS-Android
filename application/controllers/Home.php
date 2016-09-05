<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		$result = array('error' => 'No method selected');
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
