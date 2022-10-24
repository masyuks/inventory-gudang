<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ModUser');
		$this->load->model('ModItems');
		$this->load->model('ModTransaksiItems');
		$this->load->model('ModInputItems');
		$this->load->model('ModOutputItems');
		$this->load->model('ModSuppliers');
	}
	public function index()
	{
		$q = $this->session->userdata('status');
		if($q != "login") {
			redirect('login','refresh');
		}
		
		$menu['login'] = $this->ModUser->edit($this->session->userdata('id_user'));
		$data['items'] = $this->ModItems->selectAll();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('item',$data);
		$this->load->view('template/footer');
	}
	public function detail($id)
	{
		$q = $this->session->userdata('status');
		if($q != "login") {
			redirect('login','refresh');
		}
		$stok = $this->ModItems->getStok($id);
		$sisa_stok = $this->ModTransaksiItems->getSinkronisasiSisaStok($id);
		if ($stok != $sisa_stok) {
		   $this->session->set_flashdata('sinkronisasi', 'Detail transaksi tidak valid, anda perlu melakukan sinkronisasi');
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
	public function v_detail($id)
	{
		$q = $this->session->userdata('status');
		if($q != "login") {
			redirect('login','refresh'); 
		}
		$stok = $this->ModItems->getStok($id);
		$sisa_stok = $this->ModTransaksiItems->getSinkronisasiSisaStok($id);
		if ($stok != $sisa_stok) {
		   $this->session->set_flashdata('sinkronisasi', 'Detail transaksi tidak valid, anda perlu melakukan sinkronisasi');
		}
		$this->session->unset_userdata('startSession');
		$this->session->unset_userdata('endSession');
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
		$this->load->view('modal/items', $data);
	}
	public function add() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$cek1 = $this->ModItems->cekItem();
		if ($cek1 == "TRUE") {
			$this->ModItems->addNoStok();
		} else {
			$this->session->set_flashdata('cek', 'Barang sudah terdaftar!');
		}
		echo json_encode(array("status" => TRUE));
	}
	public function edit($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['cek'] = 1;
		$data['items'] = $this->ModItems->edit($id);
		$this->load->view('modal/items', $data);
	}
	public function delete($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$this->ModItems->delete($id);
		$this->ModInputItems->deleteByItem($id);
		$this->ModOutputItems->deleteByItem($id);
		$this->ModTransaksiItems->deleteByItem($id);
		echo json_encode(array("status" => TRUE));
	}
	public function update() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		// $this->ModItems->update();
		$this->ModItems->updateStokLimit();
		$this->ModInputItems->updateItems();
		$this->ModOutputItems->updateItems();
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
}
