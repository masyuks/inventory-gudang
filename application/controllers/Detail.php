<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ModUser');
		$this->load->model('ModItems');
		$this->load->model('ModInputItems');
		$this->load->model('ModOutputItems');
		$this->load->model('ModTransaksiItems');
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
		$this->ModItems->add();
		echo json_encode(array("status" => TRUE));
	}
	public function edit($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['cek'] = 1;
		$data['transaksi_items'] = $this->ModTransaksiItems->edit($id);
		$this->load->view('modal/detail', $data);
	}
	public function delete($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$this->ModItems->delete($id);
		echo json_encode(array("status" => TRUE));
	}
	public function update() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		// $this->ModItems->update();
		$this->ModTransaksiItems->update();
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
	public function sinkronisasi($id_item) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$this->ModTransaksiItems->updateSinkronisasiAwal($id_item);
		$getStokMasuk = $this->ModInputItems->getSinkronisasiStok($id_item);
		if ($getStokMasuk != 0) {
	        foreach ($getStokMasuk as $row){
			    $tanggal = $row->tgl_input;
			    $stok_m = $row->stok_masuk;
			    $kb_masuk = $row->kb_masuk;
			    $stok_masuk = round($stok_m, 5);

			    $cekTanggal = $this->ModTransaksiItems->cekTanggal($id_item, $tanggal);
				if ($cekTanggal == 1) {
					$this->ModTransaksiItems->updateStokMasuk($stok_masuk, $id_item, $tanggal);
					$this->ModTransaksiItems->updateKbMasuk($kb_masuk, $id_item, $tanggal); 
				} else {
					$this->ModTransaksiItems->addTanggal($id_item, $tanggal);
					$this->ModTransaksiItems->updateStokMasuk($stok_masuk, $id_item, $tanggal);
					$this->ModTransaksiItems->updateKbMasuk($kb_masuk, $id_item, $tanggal);
				}
			}
		}
		$getStokKeluar = $this->ModOutputItems->getSinkronisasiStok($id_item);
		if ($getStokKeluar != 0) {
	        foreach ($getStokKeluar as $row){
			    $tanggal = $row->tgl_output;
			    $stok_k = $row->stok_keluar;
			    $kb_keluar = $row->kb_keluar;
	            $stok_keluar = round($stok_k, 5);
	            
			    $cekTanggal = $this->ModTransaksiItems->cekTanggal($id_item, $tanggal);
				if ($cekTanggal == 1) {
					$this->ModTransaksiItems->updateStokKeluar($stok_keluar, $id_item, $tanggal);
					$this->ModTransaksiItems->updateKbKeluar($kb_keluar, $id_item, $tanggal); 
				} else {
					$this->ModTransaksiItems->addTanggal($id_item, $tanggal);
					$this->ModTransaksiItems->updateStokKeluar($stok_keluar, $id_item, $tanggal);
					$this->ModTransaksiItems->updateKbKeluar($kb_keluar, $id_item, $tanggal);
				}
			}
		}
		$this->ModTransaksiItems->cekHapusTanggal($id_item);
		$this->ModTransaksiItems->getSisaAllStokKb($id_item);
		redirect($_SERVER['HTTP_REFERER']); 
	}
}
