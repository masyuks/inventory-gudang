<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ModSuppliers');
		$this->load->model('ModUser');
	}
	public function index()
	{
		$q = $this->session->userdata('status');
		if($q != "login") {
			redirect('login','refresh');
		}
		
		$menu['login'] = $this->ModUser->edit($this->session->userdata('id_user'));
		$data['suppliers'] = $this->ModSuppliers->selectAll();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('supplier',$data);
		$this->load->view('template/footer');
	}
	public function detail($id)
	{
		$q = $this->session->userdata('status');
		if($q != "login") {
			redirect('login','refresh');
		}
		
		$menu['login'] = $this->ModUser->edit($this->session->userdata('id_user'));
		$data['transaksi'] = $this->ModTransaksiItems->selectAllById($id); 
		$data['data'] = $this->ModItems->getAllById($id);
		$data['id'] = $this->ModTransaksiItems->selectId($id); 
		$data['filter'] = $this->ModTransaksiItems->filter($id);
		// $data['tanggal'] = $this->ModOutputItems->getTanggal();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('detail',$data);
		$this->load->view('template/footer');
	}
	public function modal() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['cek'] = 0;
		$this->load->view('modal/supplier', $data);
	}
	public function add() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$cek2 = $this->ModSuppliers->cekSupplier();
		if ($cek2 == "TRUE") {
			$this->ModSuppliers->add();
		} else {
			$this->session->set_flashdata('cek', 'Supplier sudah terdaftar!');
		}
		echo json_encode(array("status" => TRUE));
	}
	public function edit($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['cek'] = 1;
		$data['supplier'] = $this->ModSuppliers->edit($id);
		$this->load->view('modal/supplier', $data);
	}
	public function delete($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$this->ModSuppliers->delete($id);
		echo json_encode(array("status" => TRUE));
	}
	public function update() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$this->ModSuppliers->update();
		echo json_encode(array("status" => TRUE));
	} 
	public function updateStok() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$this->ModItems->updateStok();
		echo json_encode(array("status" => TRUE));
	}
	// public function updateLimitStok() {
	// 	$q = $this->session->userdata('status');
	// 	if($q != "login") {
	// 		exit();
	// 	}
	// 	$this->ModItems->updateStokLimit();
	// 	echo json_encode(array("status" => TRUE));
	// }
}
