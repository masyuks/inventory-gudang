<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ModLogin');
	}
	public function index()
	{
		if($_POST != NULL) {
			$this->ModLogin->log();
			$q = $this->session->userdata('status');
			if($q == "login") {
				echo "1";
			} else {
				echo "0";
			}
		} else {
			$this->load->view('template/header');
			$this->load->view('login');
			$this->load->view('template/footer');
		}
	}
}
