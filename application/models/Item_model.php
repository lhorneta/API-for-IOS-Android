<?php
/**
dopes
 */
class Item_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	public function search($search = '') {

		$this->db->select('*');
		$this->db->from('announcement');
		$this->db->like('title', $search);
		$this->db->like('text', $search);
		$this->db->order_by("id", "desc");
		$result = $this->db->get();
		$res = $result->result_array();
		return $res;
	}

	public function getallitems($page=1, $count=20) {
		//$this->output->enable_profiler(TRUE);
		$res = false;
		$start = $page * $count - $count;
		$this->db->select('
			 announcement.id,
			 announcement.title,
			 announcement.top_time,
			 announcement.date,
			 announcement_category.title,
			 announcement_mobile_img.img1_view,
			 announcement_mobile_img.img2_view,
			 announcement_mobile_img.img3_view,
			 announcement_mobile_img.img4_view,
			 announcement_mobile_img.img5_view
		');
		
		$this->db->from('announcement');
		$this->db->join('announcement_mobile_img', 'announcement_mobile_img.announcement_id = announcement.id','left');
		$this->db->join('announcement_category', 'announcement_category.id = announcement.id_category','left');
		$this->db->order_by("announcement.top_time", "desc");
		$this->db->limit($count, $start);
		$result = $this->db->get();
		$res = $result->result_array();
		if($res){
		return $res;}else{return false;}
	}
	
	public function getitembyid($id=0) {
		//$this->output->enable_profiler(TRUE);
		$res = false;
		$this->db->select('
			 announcement.id,
			 announcement.title,
			 announcement.top_time,
			 announcement.date,
			 announcement_category.title,
			 announcement_mobile_img.img1_view,
			 announcement_mobile_img.img2_view,
			 announcement_mobile_img.img3_view,
			 announcement_mobile_img.img4_view,
			 announcement_mobile_img.img5_view
		');
		
		$this->db->from('announcement');
		$this->db->join('announcement_mobile_img', 'announcement_mobile_img.announcement_id = announcement.id','left');
		$this->db->join('announcement_category', 'announcement_category.id = announcement.id_category','left');
		$this->db->order_by("announcement.top_time", "desc");
		$this->db->limit($count, $start);
		$result = $this->db->get();
		$res = $result->result_array();
		if($res){
		return $res;}else{return false;}
	}
	
	
}