<?php
/**
tools
 */
class Tools extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	
	function clean($string=false)	{
		if ($string!=false) {
			$q = str_replace("\n","", $string);
			$q = str_replace("\r","", $q);
			$q = str_replace("\\","", $q);
			$q = str_replace("/","", $q);
			$q = str_replace('<br>', ' ', $q);
			$q = str_replace('<p>', '', $q);
			$q = strip_tags($q);
			$q = str_replace('*', '', $q);
			$q = str_replace('-', '', $q);
			//$q = str_replace('.', '', $q);
			$q = str_replace(',', '', $q);
			$q = str_replace('!', '', $q);
			$q = str_replace('?', '', $q);
			$q = str_replace(':', '', $q);
			$q = str_replace(';', '', $q);
			$q = str_replace(')', '', $q);
			$q = str_replace('(', '', $q);
			$q = str_replace('\'', '', $q);
			$q = str_replace('`', '', $q);
			$string = str_replace('"', '', $q);
			return $string;
		} else {
			return false;
		}
	}
	
	function thisurl() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"])&&$_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	function setting($key='') {
		$res = false;
		if ($key) {
			$setting = $this->db->get_where('settings', array('key'=>$key));
			$setting = $setting->row_array();
			$res = $setting['value'];
		}
		return $res;
	}
	
	function table($table='') {
		$res = false;
		if ($table) {
			$query = $this->db->query("SHOW COLUMNS FROM ".$table)->result_array();
			foreach ($query as $k => $q) {
				$res[] = $q['Field'];
			}
		}
		return $res;
	}
	
	function processresponse($response='') {
		$res = false;
		if ($response) {
			$pattern = '/\{(.*)\}/i';
			$replacement = '<span class="string">{$1}</span>';
			$response = str_replace(",", ",<br/>&emsp;&emsp;&emsp;", $response);
			$response = str_replace("{", "{<br/>&emsp;&emsp;&emsp;", $response);
			$response = str_replace("}", "<br/>}", $response);
			$response = str_replace(":{", ":&emsp;{", $response);
			$response = str_replace(":[{", ":&emsp;[{", $response);
			$response = str_replace("},", "&emsp;&emsp;&emsp;},", $response);
			$response = str_replace("}]", "&emsp;&emsp;&emsp;}]", $response);
			
			$response = preg_replace($pattern, $replacement, $response);
			$response = preg_replace("/true/", '<span class="operator">true</span>', $response);
			$response = preg_replace("/false/", '<span class="operator">false</span>', $response);
			$response = preg_replace("/null/", '<span class="operator">null</span>', $response);
			$response = preg_replace("/:/", '<span class="addit">:</span>', $response);
			$response = preg_replace("/,/", '<span class="addit">,</span>', $response);
			$response = preg_replace("/{/", '<span class="addit">{</span>', $response);
			$response = preg_replace("/}/", '<span class="addit">}</span>', $response);
			// $response = preg_replace("/[/", '<span class="addit">[</span>', $response);
			// $response = preg_replace("/]/", '<span class="addit">]</span>', $response);
			$res = $response;
		}
		return $res;
	}
	
	function generatepassword($number) {  
		$arr = array('a','b','c','d','e','f',  
		             'g','h','i','j','k','l',  
		             'm','n','o','p','r','s',  
		             't','u','v','x','y','z',  
		             'A','B','C','D','E','F',  
		             'G','H','I','J','K','L',  
		             'M','N','O','P','R','S',  
		             'T','U','V','X','Y','Z',  
		             '1','2','3','4','5','6',  
		             '7','8','9','0');  
		$pass = "";  
		for($i = 0; $i < $number; $i++)  
		{  
		  $index = rand(0, count($arr) - 1);  
		  $pass .= $arr[$index];  
		}  
		return $pass;  
	}
	
	function unreadreports() {
		$reports = $this->db->get_where('reports', array('is_read'=>0));
		$reports = $reports->num_rows();
		return $reports;
	}
	
	function pagescount($page=1, $q='') {
		if ($q) {
			$this->db->like('title', $q);
			$this->db->or_like('mini_desc', $q);
			$this->db->or_like('description', $q);
		}
		$pages = $this->db->get_where('pages');
		$res = $pages->num_rows();
		return $res;
	}
	
	function pages($page=1, $q='')	{
		$count=20;
		$start = $page * $count - $count;
		if ($q) {
			$this->db->like('title', $q);
			$this->db->or_like('mini_desc', $q);
			$this->db->or_like('description', $q);
		}
		$pages = $this->db->get_where('pages', array(), $count, $start);
		$res = $pages->result_array();
		return $res;
	}
	
	function page($id=0) {
		$page = $this->db->get_where('pages', array('id'=>$id));
		$res = $page->row_array();
		return $res;
	}
	
	
	function reportscount($page=1, $q='') {
		if ($q) {
			$this->db->like('report', $q);
		}
		$reports = $this->db->get_where('reports');
		$res = $reports->num_rows();
		return $res;
	}
	
	function reports($page=1, $q='')	{
		$count=20;
		$start = $page * $count - $count;
		if ($q) {
			$this->db->like('report', $q);
		}
		$this->db->order_by('id', 'desc');
		$reports = $this->db->get_where('reports', array(), $count, $start);
		$res = $reports->result_array();
		return $res;
	}
	
	function report($id=0) {
		$report = $this->db->get_where('reports', array('id'=>$id));
		$res = $report->row_array();
		return $res;
	}
	
	
	
}