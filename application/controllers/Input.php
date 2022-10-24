<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ModInputItems');
		$this->load->model('ModOutputItems');
		$this->load->model('ModItems');
		$this->load->model('ModTransaksiItems');
		$this->load->model('ModSuppliers');
	}
	public function index()
	{
		$q = $this->session->userdata('status');
		if($q != "login") {
			redirect('login','refresh');
		}

		$data['input'] = $this->ModInputItems->selectAll();
		$data['filter'] = $this->ModInputItems->filter();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('input',$data);
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
		$data['input'] = $this->ModInputItems->selectAll();
		$data['filter'] = $this->ModInputItems->filter();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('input',$data);
		$this->load->view('template/footer');
	}
	public function modal() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['cek'] = 0;
		$data['item'] = $this->ModInputItems->listItems();
		$data['supplier'] = $this->ModInputItems->listSupplier();
		$this->load->view('modal/input', $data);
	}
	public function add() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$id_item = $this->input->post('id_item');
		$id_supplier = $this->input->post('id_supplier');
		$qty = $this->input->post('qty_input');
		$kb_input = $this->input->post('kb_input');
		$tanggal = $this->input->post('tgl_input');
		if ($id_item=="0" && $id_supplier=="0") {
			$cek1 = $this->ModItems->cekItem();
			$cek2 = $this->ModSuppliers->cekSupplier();
			if ($cek1 == "TRUE" && $cek2 == "TRUE") {
				$this->ModItems->add();
				$this->ModSuppliers->add();

				$id1 = $this->ModItems->getId();
				$id2 = $this->ModSuppliers->getId();

				$this->ModInputItems->addTT($id1, $id2);

				// Last transaksi
				$this->ModSuppliers->updateTerakhirTransaksi($id2);

				// transaksi item
				$cekTanggal = $this->ModTransaksiItems->cekTanggal($id1, $tanggal);
				if ($cekTanggal == 1) {
					$stokTi = $this->ModTransaksiItems->getStokMasuk($id1, $tanggal);
					$kbTi = $this->ModTransaksiItems->getKbMasuk($id1, $tanggal);
					$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id1, $tanggal);
					$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id1, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalKbTi = $kbTi + $kb_input;
					$totalSisaStokTi = $sisa_stokTi + $qty;
					$totalSisaKbTi = $sisa_kbTi + $kb_input;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id1, $tanggal);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id1, $tanggal);
					$this->ModTransaksiItems->getSisaAllStokKb($id1); 
				} else {
					$this->ModTransaksiItems->addTanggalInput($id1);
					$stokTi = $this->ModTransaksiItems->getStokMasuk($id1, $tanggal);
					$kbTi = $this->ModTransaksiItems->getKbMasuk($id1, $tanggal);
					$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id1, $tanggal);
					$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id1, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalKbTi = $kbTi + $kb_input;
					$totalSisaStokTi = $sisa_stokTi + $qty;
					$totalSisaKbTi = $sisa_kbTi + $kb_input;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id1, $tanggal);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id1, $tanggal);
					$this->ModTransaksiItems->getSisaAllStokKb($id1); 
				}
			} else {
				$this->session->set_flashdata('cek', 'Barang & Supplier sudah terdaftar!');
			}
		}
		else if ($id_item=="0" && $id_supplier!="0") {
			$cek1 = $this->ModItems->cekItem();
			if ($cek1 == "TRUE") {
				$this->ModItems->add();

				$id1 = $this->ModItems->getId();

				$this->ModInputItems->addTitem($id1);

				// Last transaksi
				$this->ModSuppliers->updateTerakhirTransaksi($id_supplier);

				// transaksi item
				$cekTanggal = $this->ModTransaksiItems->cekTanggal($id1, $tanggal);
				if ($cekTanggal == 1) {
					$stokTi = $this->ModTransaksiItems->getStokMasuk($id1, $tanggal);
					$kbTi = $this->ModTransaksiItems->getKbMasuk($id1, $tanggal);
					$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id1, $tanggal);
					$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id1, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalKbTi = $kbTi + $kb_input;
					$totalSisaStokTi = $sisa_stokTi + $qty;
					$totalSisaKbTi = $sisa_kbTi + $kb_input;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id1, $tanggal);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id1, $tanggal);
					$this->ModTransaksiItems->getSisaAllStokKb($id1);  
				} else {
					$this->ModTransaksiItems->addTanggalInput($id1);
					$stokTi = $this->ModTransaksiItems->getStokMasuk($id1, $tanggal);
					$kbTi = $this->ModTransaksiItems->getKbMasuk($id1, $tanggal);
					$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id1, $tanggal);
					$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id1, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalKbTi = $kbTi + $kb_input;
					$totalSisaStokTi = $sisa_stokTi + $qty;
					$totalSisaKbTi = $sisa_kbTi + $kb_input;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id1, $tanggal);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id1, $tanggal);
					$this->ModTransaksiItems->getSisaAllStokKb($id1); 
				}
			} else {
				$this->session->set_flashdata('cek', 'Barang sudah terdaftar!');
			}
		}
		else if ($id_item!="0" && $id_supplier=="0") {
			$cek2 = $this->ModSuppliers->cekSupplier();
			if ($cek2 == "TRUE") {
				$this->ModSuppliers->add();

				$id2 = $this->ModSuppliers->getId();

				$stok = $this->ModItems->getStok($id_item);
				$total = $stok + $qty;
				$totalStok = round($total, 5);
				$this->ModItems->updateStok($totalStok);

				$kb = $this->ModItems->getKb($id_item);
				$totalKb = $kb + $kb_input;
				$this->ModItems->updateKb($totalKb);

				$this->ModInputItems->addTsupplier($id2, $total);

				// Last transaksi
				$this->ModSuppliers->updateTerakhirTransaksi($id2);

				// transaksi item
				$cekTanggal = $this->ModTransaksiItems->cekTanggal($id_item, $tanggal);
				if ($cekTanggal == 1) {
					$stokTi = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggal);
					$kbTi = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggal);
					$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id_item, $tanggal);
					$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id_item, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalKbTi = $kbTi + $kb_input;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggal);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggal);
					$this->ModTransaksiItems->getSisaAllStokKb($id_item);
				} else {
					$this->ModTransaksiItems->addTanggalInput($id_item);
					$stokTi = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggal);
					$kbTi = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggal);
					$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id_item, $tanggal);
					$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id_item, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalKbTi = $kbTi + $kb_input;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggal);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggal);
					$this->ModTransaksiItems->getSisaAllStokKb($id_item);  
				}
			} else {
				$this->session->set_flashdata('cek', 'Supplier sudah terdaftar!');
			}
		}
		else if ($id_item!="0" && $id_supplier!="0") {
			$stok = $this->ModItems->getStok($id_item);
			$total = $stok + $qty;
			$totalStok = round($total, 5);
			$this->ModItems->updateStok($totalStok);

			$kb = $this->ModItems->getKb($id_item);
			$totalKb = $kb + $kb_input;
			$this->ModItems->updateKb($totalKb);

			$this->ModInputItems->add($total);

			// Last transaksi
			$this->ModSuppliers->updateTerakhirTransaksi($id_supplier);

			// transaksi item
			$cekTanggal = $this->ModTransaksiItems->cekTanggal($id_item, $tanggal);
			if ($cekTanggal == 1) {
				$stokTi = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggal);
				$kbTi = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggal);
				$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id_item, $tanggal);
				$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id_item, $tanggal);
				$totalStokTi = $stokTi + $qty;
				$totalKbTi = $kbTi + $kb_input;
				$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggal);
				$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggal);
				$this->ModTransaksiItems->getSisaAllStokKb($id_item);
			} else {
				$this->ModTransaksiItems->addTanggalInput($id_item);
				$stokTi = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggal);
				$kbTi = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggal);
				$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id_item, $tanggal);
				$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id_item, $tanggal);
				$totalStokTi = $stokTi + $qty;
				$totalKbTi = $kbTi + $kb_input;
				$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggal);
				$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggal);
				$this->ModTransaksiItems->getSisaAllStokKb($id_item);
			}
		}
		echo json_encode(array("status" => TRUE));
	}

	public function edit($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['cek'] = 1;
		$data['item'] = $this->ModInputItems->listItems();
		$data['supplier'] = $this->ModInputItems->listSupplier();
		$data['inputEdit'] = $this->ModInputItems->edit($id);
		$this->load->view('modal/input', $data);
	}
	public function delete($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$tanggal = $this->ModInputItems->getTanggal($id);
		$id_item = $this->ModInputItems->getIdItem($id);
		$qtyLama = $this->ModInputItems->getStok($id);
		$kbLama = $this->ModInputItems->getKb($id);
		$stok = $this->ModInputItems->getStokByInput($id);
		$kb = $this->ModInputItems->getKbByInput($id);
		$cekTotalStokInput = $this->ModInputItems->getTotalQtyProduk($id_item);
		$cekTotalStokOutput = $this->ModOutputItems->getTotalQtyProduk($id_item);
		$cekStokProduk = ($cekTotalStokInput-$qtyLama) - $cekTotalStokOutput;  
		if ($cekStokProduk >= 0) {
			$total = $stok - $qtyLama;
			$totalKb = $kb - $kbLama;
			$totalStok = round($total, 5);
			$this->ModItems->updateStokWithId($totalStok, $id_item);
			$this->ModItems->updateKbWithId($totalKb, $id_item);

			$stokTi = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggal);
			$kbTi = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggal);
			$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id_item, $tanggal);
			$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id_item, $tanggal);
			$totalStokTi = $stokTi - $qtyLama;
			$totalKbTi = $kbTi - $kbLama;
			$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggal);
			$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggal);
			$this->ModTransaksiItems->getSisaAllStokKb($id_item);

			// $this->session->set_flashdata('cek', $total);
			$this->ModInputItems->delete($id);

			// cek hapus tanggal
			$this->ModTransaksiItems->cekHapusTanggal($id_item);
		}
		else {
			$this->session->set_flashdata('cek', 'Quantity Stock Is Used!');	
		}
		echo json_encode(array("status" => TRUE));	
	}
	public function update() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}

		$id_item = $this->input->post('id_item');
		$id_input = $this->input->post('id_input');

		$tanggalBaru = $this->input->post('tgl_input');
		$tanggalLama = $this->ModInputItems->getTanggal($id_input);

		$qtyBaru = $this->input->post('qty_input');
		$qtyLama = $this->ModInputItems->getStok($id_input);
		$stok = $this->ModItems->getStok($id_item);

		$kbBaru = $this->input->post('kb_input');
		$kbLama = $this->ModInputItems->getKb($id_input);
		$kb = $this->ModItems->getKb($id_item);

		$total = $stok - ($qtyLama-$qtyBaru);
		$totalKb = $kb - ($kbLama-$kbBaru);

		if ($total < 0 || $totalKb < 0) {
			$this->session->set_flashdata('cek', 'Stok / Koli tidak mencukupi!');
		} else {
			$this->ModInputItems->update();
			$this->ModInputItems->update_H_Stok($total);
			$totalStok = round($total, 5);
			$this->ModItems->updateStok($totalStok);	
			$this->ModItems->updateKb($totalKb);

			if ($tanggalLama == $tanggalBaru) {
				$stokTi = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggalBaru);
				$kbTi = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggalBaru);
				$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id_item, $tanggalBaru);
				$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id_item, $tanggalBaru);
				$totalStokTi = $stokTi - ($qtyLama-$qtyBaru);
				$totalKbTi = $kbTi - ($kbLama-$kbBaru);
				$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggalBaru);
				$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggalBaru);
				$this->ModTransaksiItems->getSisaAllStokKb($id_item);
			} else {
				$cekTanggal = $this->ModTransaksiItems->cekTanggal($id_item, $tanggalBaru);
				if ($cekTanggal == 1) {
					$stokTi1 = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggalLama);
					$kbTi1 = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggalLama);
					$sisa_stokTi1 = $this->ModTransaksiItems->getStokSisa($id_item, $tanggalLama);
					$sisa_kbTi1 = $this->ModTransaksiItems->getKbSisa($id_item, $tanggalLama);
					$totalStokTi1 = $stokTi1 - $qtyLama;
					$totalKbTi1 = $kbTi1 - $kbLama;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggalLama);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggalLama);
					$this->ModTransaksiItems->getSisaAllStokKb($id_item);

					$stokTi = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggalBaru);
					$kbTi = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggalBaru);
					$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id_item, $tanggalBaru);
					$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id_item, $tanggalBaru);
					$totalStokTi = $stokTi + $qtyBaru;
					$totalKbTi = $kbTi + $kbBaru;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggalBaru);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggalBaru);
					$this->ModTransaksiItems->getSisaAllStokKb($id_item);

					// cek hapus tanggal
					$this->ModTransaksiItems->cekHapusTanggal($id_item);
				} else {
					$this->ModTransaksiItems->addTanggalInput($id_item);
					$stokTi1 = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggalLama);
					$kbTi1 = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggalLama);
					$sisa_stokTi1 = $this->ModTransaksiItems->getStokSisa($id_item, $tanggalLama);
					$sisa_kbTi1 = $this->ModTransaksiItems->getKbSisa($id_item, $tanggalLama);
					$totalStokTi1 = $stokTi1 - $qtyLama;
					$totalKbTi1 = $kbTi1 - $kbLama;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi1, $id_item, $tanggalLama);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi1, $id_item, $tanggalLama);
					$this->ModTransaksiItems->getSisaAllStokKb($id_item);

					$stokTi = $this->ModTransaksiItems->getStokMasuk($id_item, $tanggalBaru);
					$kbTi = $this->ModTransaksiItems->getKbMasuk($id_item, $tanggalBaru);
					$sisa_stokTi = $this->ModTransaksiItems->getStokSisa($id_item, $tanggalBaru);
					$sisa_kbTi = $this->ModTransaksiItems->getKbSisa($id_item, $tanggalBaru);
					$totalStokTi = $stokTi + $qtyBaru;
					$totalKbTi = $kbTi + $kbBaru;
					$this->ModTransaksiItems->updateStokMasuk($totalStokTi, $id_item, $tanggalBaru);
					$this->ModTransaksiItems->updateKbMasuk($totalKbTi, $id_item, $tanggalBaru);
					$this->ModTransaksiItems->getSisaAllStokKb($id_item);

					// cek hapus tanggal
					$this->ModTransaksiItems->cekHapusTanggal($id_item);
				}
			}
			$this->ModInputItems->update();
		}
		echo json_encode(array("status" => TRUE));
	}
	public function set_supplier($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['supplier'] = $this->ModSuppliers->edit($id);
		$this->load->view('modal/set-supplier', $data);
	}
	public function set_item($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['items'] = $this->ModItems->edit($id);
		$this->load->view('modal/set-item', $data);
	}
}
