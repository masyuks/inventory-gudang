<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InputBaku extends CI_Controller {
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
		$data['input'] = $this->ModInputBaku->selectAll();
		$data['filter'] = $this->ModInputBaku->filter();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('inputBaku',$data);
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
		$data['input'] = $this->ModInputBaku->selectAll();
		$data['filter'] = $this->ModInputBaku->filter();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('inputBaku',$data);
		$this->load->view('template/footer');
	}
	public function modal() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['cek'] = 0;
		$data['baku'] = $this->ModInputBaku->listBaku();
		$data['supplier'] = $this->ModInputBaku->listSupplier();
		$this->load->view('modal/inputBaku', $data);
	}
	public function add() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$id_baku = $this->input->post('id_baku');
		$id_supplier = $this->input->post('id_supplier');
		$qty = $this->input->post('qty_input');
		$tanggal = $this->input->post('tgl_input');
		if ($id_baku=="0" && $id_supplier=="0") {
			$cek1 = $this->ModBaku->cekbaku();
			$cek2 = $this->ModSuppliersBaku->cekSupplier();
			if ($cek1 == "TRUE" && $cek2 == "TRUE") {
				$this->ModBaku->add();
				$this->ModSuppliersBaku->add();

				$id1 = $this->ModBaku->getId();
				$id2 = $this->ModSuppliersBaku->getId();

				$this->ModInputBaku->addTT($id1, $id2);

				// Last transaksi
				$this->ModSuppliersBaku->updateTerakhirTransaksi($id2);

				// transaksi baku
				$cekTanggal = $this->ModTransaksiBaku->cekTanggal($id1, $tanggal);
				if ($cekTanggal == 1) {
					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id1, $tanggal);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id1, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalSisaStokTi = $sisa_stokTi + $qty;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id1, $tanggal);
					$this->ModTransaksiBaku->getSisaAllStokKb($id1); 
				} else {
					$this->ModTransaksiBaku->addTanggalInput($id1);
					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id1, $tanggal);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id1, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalSisaStokTi = $sisa_stokTi + $qty;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id1, $tanggal);
					$this->ModTransaksiBaku->getSisaAllStokKb($id1); 
				}
			} else {
				$this->session->set_flashdata('cek', 'Barang & Supplier sudah terdaftar!');
			}
		}
		else if ($id_baku=="0" && $id_supplier!="0") {
			$cek1 = $this->ModBaku->cekbaku();
			if ($cek1 == "TRUE") {
				$this->ModBaku->add();

				$id1 = $this->ModBaku->getId();

				$this->ModInputBaku->addTbaku($id1);

				// Last transaksi
				$this->ModSuppliersBaku->updateTerakhirTransaksi($id_supplier);

				// transaksi baku
				$cekTanggal = $this->ModTransaksiBaku->cekTanggal($id1, $tanggal);
				if ($cekTanggal == 1) {
					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id1, $tanggal);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id1, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalSisaStokTi = $sisa_stokTi + $qty;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id1, $tanggal);
					$this->ModTransaksiBaku->getSisaAllStokKb($id1);  
				} else {
					$this->ModTransaksiBaku->addTanggalInput($id1);
					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id1, $tanggal);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id1, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$totalSisaStokTi = $sisa_stokTi + $qty;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id1, $tanggal);
					$this->ModTransaksiBaku->getSisaAllStokKb($id1); 
				}
			} else {
				$this->session->set_flashdata('cek', 'Barang sudah terdaftar!');
			}
		}
		else if ($id_baku!="0" && $id_supplier=="0") {
			$cek2 = $this->ModSuppliersBaku->cekSupplier();
			if ($cek2 == "TRUE") {
				$this->ModSuppliersBaku->add();

				$id2 = $this->ModSuppliersBaku->getId();

				$stok = $this->ModBaku->getStok($id_baku);
				$total = $stok + $qty;
				$totalStok = round($total, 5);
				$this->ModBaku->updateStok($totalStok);

				$this->ModInputBaku->addTsupplier($id2, $total);

				// Last transaksi
				$this->ModSuppliersBaku->updateTerakhirTransaksi($id2);

				// transaksi baku
				$cekTanggal = $this->ModTransaksiBaku->cekTanggal($id_baku, $tanggal);
				// $this->session->set_flashdata('cek', $cekTanggal);
				if ($cekTanggal == 1) {
					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggal);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggal);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

					$setStatus = $this->ModInputBaku->selectAllStatus($id_baku);
					foreach ($setStatus as $row){
					    $id_input = $row->id_input;
					    $id_baku = $row->id_baku;
					    $expired = $row->expired;
					    $status = $row->status;
					    $tgl_input = $row->tgl_input;
					    $qty_input = $row->qty_input;
					    $fifo = $row->fifo;
					    $today = date('Y-m-d');
					    $today_time = strtotime($today);
						$expired_time = strtotime($expired);
						$stok = $this->ModBaku->getStok($id_baku);

					    if ($expired_time <= $today_time && $status != "expired" && $status != "out") {
					    	$this->ModInputBaku->updateStatusExpired($id_input);
					    	$total = $stok - $qty_input;
							$this->ModBaku->updateStokWithId($total, $id_baku);
							$this->ModTransaksiBaku->updateKeteranganNoId($id_baku, $tgl_input);

							// transaksi
							$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tgl_input);
							$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tgl_input);
							$totalStokTi = $stokTi - $qty_input;
							$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tgl_input);
							$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);
					    }
						else if ($expired_time != $today_time && $status != "expired" && $status != "out") {
							if ($fifo <= 0) {
								$this->ModInputBaku->updateStatusOut($id_input);
							} else {
								$this->ModInputBaku->updateStatusHampir($id_input);
							}
					    }
					}
				} else {
					$this->ModTransaksiBaku->addTanggalInput($id_baku);
					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggal);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggal);
					$totalStokTi = $stokTi + $qty;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggal);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

					$setStatus = $this->ModInputBaku->selectAllStatus($id_baku);
					foreach ($setStatus as $row){
					    $id_input = $row->id_input;
					    $id_baku = $row->id_baku;
					    $expired = $row->expired;
					    $status = $row->status;
					    $tgl_input = $row->tgl_input;
					    $qty_input = $row->qty_input;
					    $fifo = $row->fifo;
					    $today = date('Y-m-d');
					    $today_time = strtotime($today);
						$expired_time = strtotime($expired);
						$stok = $this->ModBaku->getStok($id_baku);

					    if ($expired_time <= $today_time && $status != "expired" && $status != "out") {
					    	$this->ModInputBaku->updateStatusExpired($id_input);
					    	$total = $stok - $qty_input;
							$this->ModBaku->updateStokWithId($total, $id_baku);
							$this->ModTransaksiBaku->updateKeteranganNoId($id_baku, $tgl_input);

							// transaksi
							$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tgl_input);
							$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tgl_input);
							$totalStokTi = $stokTi - $qty_input;
							$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tgl_input);
							$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);
					    }
						else if ($expired_time != $today_time && $status != "expired" && $status != "out") {
							if ($fifo <= 0) {
								$this->ModInputBaku->updateStatusOut($id_input);
							} else {
								$this->ModInputBaku->updateStatusHampir($id_input);
							}
					    }
					}
				}
			} else {
				$this->session->set_flashdata('cek', 'Supplier sudah terdaftar!');
			}
		}
		else if ($id_baku!="0" && $id_supplier!="0") {
			$stok = $this->ModBaku->getStok($id_baku);
			$total = $stok + $qty;
			$totalStok = round($total, 5);
			$this->ModBaku->updateStok($totalStok);

			$this->ModInputBaku->add($total);

			// Last transaksi
			$this->ModSuppliersBaku->updateTerakhirTransaksi($id_supplier);

			// transaksi baku
			$cekTanggal = $this->ModTransaksiBaku->cekTanggal($id_baku, $tanggal);
			// $this->session->set_flashdata('cek', $cekTanggal);
			if ($cekTanggal == 1) {
				$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggal);
				$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggal);
				$totalStokTi = $stokTi + $qty;
				$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggal);
				$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

				$setStatus = $this->ModInputBaku->selectAllStatus($id_baku);
				foreach ($setStatus as $row){
				    $id_input = $row->id_input;
				    $id_baku = $row->id_baku;
				    $expired = $row->expired;
				    $status = $row->status;
				    $tgl_input = $row->tgl_input;
				    $qty_input = $row->qty_input;
				    $fifo = $row->fifo;
				    $today = date('Y-m-d');
				    $today_time = strtotime($today);
					$expired_time = strtotime($expired);
					$stok = $this->ModBaku->getStok($id_baku);

				    if ($expired_time <= $today_time && $status != "expired" && $status != "out") {
				    	$this->ModInputBaku->updateStatusExpired($id_input);
				    	$total = $stok - $qty_input;
						$this->ModBaku->updateStokWithId($total, $id_baku);
						$this->ModTransaksiBaku->updateKeteranganNoId($id_baku, $tgl_input);

						// transaksi
						$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tgl_input);
						$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tgl_input);
						$totalStokTi = $stokTi - $qty_input;
						$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tgl_input);
						$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);
				    }
					else if ($expired_time != $today_time && $status != "expired" && $status != "out") {
						if ($fifo <= 0) {
							$this->ModInputBaku->updateStatusOut($id_input);
						} else {
							$this->ModInputBaku->updateStatusHampir($id_input);
						}
				    }
				}
			} else {
				$this->ModTransaksiBaku->addTanggalInput($id_baku);
				$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggal);
				$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggal);
				$totalStokTi = $stokTi + $qty;
				$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggal);
				$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

				$setStatus = $this->ModInputBaku->selectAllStatus($id_baku);
				foreach ($setStatus as $row){
				    $id_input = $row->id_input;
				    $id_baku = $row->id_baku;
				    $expired = $row->expired;
				    $status = $row->status;
				    $tgl_input = $row->tgl_input;
				    $qty_input = $row->qty_input;
				    $fifo = $row->fifo;
				    $today = date('Y-m-d');
				    $today_time = strtotime($today);
					$expired_time = strtotime($expired);
					$stok = $this->ModBaku->getStok($id_baku);

				    if ($expired_time <= $today_time && $status != "expired" && $status != "out") {
				    	$this->ModInputBaku->updateStatusExpired($id_input);
				    	$total = $stok - $qty_input;
						$this->ModBaku->updateStokWithId($total, $id_baku);
						$this->ModTransaksiBaku->updateKeteranganNoId($id_baku, $tgl_input);

						// transaksi
						$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tgl_input);
						$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tgl_input);
						$totalStokTi = $stokTi - $qty_input;
						$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tgl_input);
						$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);
				    }
					else if ($expired_time != $today_time && $status != "expired" && $status != "out") {
						if ($fifo <= 0) {
							$this->ModInputBaku->updateStatusOut($id_input);
						} else {
							$this->ModInputBaku->updateStatusHampir($id_input);
						}
				    }
				}
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
		$data['baku'] = $this->ModInputBaku->listBaku();
		$data['supplier'] = $this->ModInputBaku->listSupplier();
		$data['inputEdit'] = $this->ModInputBaku->edit($id);
		$this->load->view('modal/inputBaku', $data);
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
				$totalStok = round($total, 5);
				$this->ModBaku->updateStokWithId($totalStok, $id_baku);

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
	public function update() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}

		$id_baku = $this->input->post('id_baku');
		$id_input = $this->input->post('id_input');

		$tanggalBaru = $this->input->post('tgl_input');
		$tanggalLama = $this->ModInputBaku->getTanggal($id_input);

		$qtyBaru = $this->input->post('qty_input');
		$qtyLama = $this->ModInputBaku->getStok($id_input);
		$stok = $this->ModBaku->getStok($id_baku);

		$total = $stok - ($qtyLama-$qtyBaru);

		if ($total < 0) {
			$this->session->set_flashdata('cek', 'Stok / Pack tidak mencukupi!');
		} else {
			$this->ModInputBaku->update();
			$this->ModInputBaku->update_H_Stok($total);
			$totalStok = round($total, 5);
			$this->ModBaku->updateStok($totalStok);

			if ($tanggalLama == $tanggalBaru) {
				$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggalBaru);
				$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalBaru);
				$totalStokTi = $stokTi - ($qtyLama-$qtyBaru);
				$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggalBaru);
				$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);
			} else {
				$cekTanggal = $this->ModTransaksiBaku->cekTanggal($id_baku, $tanggalBaru);
				if ($cekTanggal == 1) {
					$stokTi1 = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggalLama);
					$sisa_stokTi1 = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalLama);
					$totalStokTi1 = $stokTi1 - $qtyLama;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggalLama);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggalBaru);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalBaru);
					$totalStokTi = $stokTi + $qtyBaru;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggalBaru);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

					// cek hapus tanggal
					$this->ModTransaksiBaku->cekHapusTanggal($id_baku);
				} else {
					$this->ModTransaksiBaku->addTanggalInput($id_baku);
					$stokTi1 = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggalLama);
					$sisa_stokTi1 = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalLama);
					$totalStokTi1 = $stokTi1 - $qtyLama;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi1, $id_baku, $tanggalLama);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tanggalBaru);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalBaru);
					$totalStokTi = $stokTi + $qtyBaru;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tanggalBaru);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

					// cek hapus tanggal
					$this->ModTransaksiBaku->cekHapusTanggal($id_baku);
				}
			}

			// cek status
			$setStatus = $this->ModInputBaku->selectAllStatus($id_baku);
	        foreach ($setStatus as $row){
			    $id_input = $row->id_input;
			    $id_baku = $row->id_baku;
			    $expired = $row->expired;
			    $status = $row->status;
			    $tgl_input = $row->tgl_input;
			    $qty_input = $row->qty_input;
			    $fifo = $row->fifo;
			    $today = date('Y-m-d');
			    $today_time = strtotime($today);
				$expired_time = strtotime($expired);
				$stok = $this->ModBaku->getStok($id_baku);

			    if ($expired_time <= $today_time && $status != "expired" && $status != "out") {
			    	$this->ModInputBaku->updateStatusExpired($id_input);
			    	$total = $stok - $qty_input;
					$this->ModBaku->updateStokWithId($total, $id_baku);
					$this->ModTransaksiBaku->updateKeteranganNoId($id_baku, $tgl_input);

					// transaksi
					$stokTi = $this->ModTransaksiBaku->getStokMasuk($id_baku, $tgl_input);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tgl_input);
					$totalStokTi = $stokTi - $qty_input;
					$this->ModTransaksiBaku->updateStokMasuk($totalStokTi, $id_baku, $tgl_input);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);
			    }
				else if ($expired_time != $today_time && $status != "expired" && $status != "out") {
					if ($fifo <= 0) {
						$this->ModInputBaku->updateStatusOut($id_input);
					} else {
						$this->ModInputBaku->updateStatusHampir($id_input);
					}
			    }
			}
		}
		echo json_encode(array("status" => TRUE));
	}
	public function set_supplier($id) {
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
