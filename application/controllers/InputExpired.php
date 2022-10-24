<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InputExpired extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ModInputBaku');
		$this->load->model('ModOutputBaku');
		$this->load->model('ModBaku');
		$this->load->model('ModTransaksiBaku');
		$this->load->model('ModSuppliersBaku');
	}
	public function index()
	{
		$q = $this->session->userdata('status');
		if($q != "login") {
			redirect('login','refresh');
		}

		$data['input'] = $this->ModInputBaku->listExpired();
		$data['filter'] = $this->ModInputBaku->filterExpired();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('inputExpired',$data);
		$this->load->view('template/footer');
	}
	public function v_index()
	{
		$q = $this->session->userdata('status');
		if($q != "login") {
			redirect('login','refresh');
		}
		$this->session->unset_userdata('startSession');
		$this->session->unset_userdata('endSession');
		$data['input'] = $this->ModInputBaku->listExpired();
		$data['filter'] = $this->ModInputBaku->filterExpired();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('inputExpired',$data);
		$this->load->view('template/footer');
	}
	
	public function delete($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$status = $this->ModInputBaku->getStatus($id);
		$tanggal = $this->ModInputBaku->getTanggal($id);
		$id_baku = $this->ModInputBaku->getIdbaku($id);
		$qtyLama = $this->ModInputBaku->getStok($id);
		$stok = $this->ModInputBaku->getStokByInput($id);
		$cekTotalStokInput = $this->ModInputBaku->getTotalQtyProduk($id_baku);
		$cekTotalStokOutput = $this->ModOutputBaku->getTotalQtyProduk($id_baku);
		$cekStokProduk = ($cekTotalStokInput-$qtyLama) - $cekTotalStokOutput;  

		if ($status != 'expired' && $status != 'out') {
			if ($cekStokProduk >= 0) {
				$total = $stok - $qtyLama;
				
				$this->ModBaku->updateStokWithId($total, $id_baku);


				// transaksi
				$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggal);
				$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggal);
				$totalStokTi = $stokTi - $qtyLama;
				$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggal);
				$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

				// $this->session->set_flashdata('cek', $total);
				$this->ModInputBaku->delete($id);

				// cek hapus tanggal
				$this->ModTransaksiBaku->cekHapusTanggal($id_baku);
			}
			else {
				$this->session->set_flashdata('cek', 'Quantity Stock Is Used!');	
			}
		}
		else if ($status == 'out') {
			$this->session->set_flashdata('cek', 'Quantity Stock Is Used!');
		}
		else {
			// $this->session->set_flashdata('cek', $total);
			$this->ModInputBaku->delete($id);

			$this->ModTransaksiBaku->updateKeteranganNoId($id_baku, $tanggal);
		}
		echo json_encode(array("status" => TRUE));
	}
	
	public function set_supplierBaku($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['supplier'] = $this->ModSuppliersBaku->edit($id);
		$this->load->view('modal/set-supplier', $data);
	}
	public function set_baku($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['baku'] = $this->ModBaku->edit($id);
		$this->load->view('modal/set-baku', $data);
	}
}
