<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OutputBaku extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ModOutputBaku');
		$this->load->model('ModInputBaku');
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
		$data['notif'] = $this->ModInputBaku->getHampirExpired();
		$data['output'] = $this->ModOutputBaku->selectAll();
		$data['filter'] = $this->ModOutputBaku->filter();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('output-baku',$data);
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
		$data['notif'] = $this->ModInputBaku->getHampirExpired();
		$data['output'] = $this->ModOutputBaku->selectAll();
		$data['filter'] = $this->ModOutputBaku->filter();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('output-baku',$data);
		$this->load->view('template/footer');
	}
	public function modal() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['cek'] = 0;
		$data['baku'] = $this->ModOutputBaku->listBaku();
		$data['supplier'] = $this->ModOutputBaku->listSupplier();
		$this->load->view('modal/outputBaku', $data);
	}
	public function add() {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$qty = $this->input->post('qty_output');
		$id_baku = $this->input->post('id_baku');
		$stok = $this->ModBaku->getStok($id_baku);
		$tanggal = $this->input->post('tgl_output');

		if ($qty > $stok) {
			$this->session->set_flashdata('stok', 'Stok / Pack tidak mencukupi!');
		} else {
			$total = $stok - $qty;
			$totalStok = round($total, 5);
			$this->ModBaku->updateStok($totalStok);
			$this->ModOutputBaku->add($total);

			// transaksi baku
			$cekTanggal = $this->ModTransaksiBaku->cekTanggal($id_baku, $tanggal);
			if ($cekTanggal == 1) {
				$stokTi = $this->ModTransaksiBaku->getStokKeluar($id_baku, $tanggal);
				$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggal);
				$totalStokTi = $stokTi + $qty;
				$this->ModTransaksiBaku->updateStokKeluar($totalStokTi, $id_baku, $tanggal);
				$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

				// fifo logic
				$quantity = $qty;
				$getInput = $this->ModInputBaku->getByStatusAsc($id_baku);
		        foreach ($getInput as $row){
				    $id_input = $row->id_input;
				    $fifo = $row->fifo;
				    $status = $row->status;

				    if ($quantity > $fifo) {
				    	$quantity = $quantity - $fifo;
				    	$this->ModInputBaku->updateStatusOut($id_input);
				    	$this->ModInputBaku->updateFifo($id_input, 0);
				    }
					else {
						$fifo = $fifo - $quantity;
				    	$this->ModInputBaku->updateFifo($id_input, $fifo);
				    	$quantity = 0;
				    }
				}

				// set status Add
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
				$this->ModTransaksiBaku->addTanggalOutput($id_baku);
				$stokTi = $this->ModTransaksiBaku->getStokKeluar($id_baku, $tanggal);
				$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggal);
				$totalStokTi = $stokTi + $qty;
				$this->ModTransaksiBaku->updateStokKeluar($totalStokTi, $id_baku, $tanggal);
				$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

				// fifo logic
				$quantity = $qty;
				$getInput = $this->ModInputBaku->getByStatusAsc($id_baku);
		        foreach ($getInput as $row){
				    $id_input = $row->id_input;
				    $fifo = $row->fifo;
				    $status = $row->status;

				    if ($quantity > $fifo) {
				    	$quantity = $quantity - $fifo;
				    	$this->ModInputBaku->updateStatusOut($id_input);
				    	$this->ModInputBaku->updateFifo($id_input, 0);
				    }
					else {
						$fifo = $fifo - $quantity;
				    	$this->ModInputBaku->updateFifo($id_input, $fifo);
				    	$quantity = 0;
				    }
				}

				// set status Add
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
		$data['baku'] = $this->ModOutputBaku->listBaku();
		$data['supplier'] = $this->ModOutputBaku->listSupplier();
		$data['outputEdit'] = $this->ModOutputBaku->edit($id);
		$this->load->view('modal/outputBaku', $data);
	}
	public function delete($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$id_baku = $this->ModOutputBaku->getIdbaku($id);

		$tanggal = $this->ModOutputBaku->getTanggal($id);

		$qtyLama = $this->ModOutputBaku->getStok($id);
		$stok = $this->ModOutputBaku->getStokByOutput($id);
		$total = $stok + $qtyLama;

		$totalStok = round($total, 5);
		$this->ModBaku->updateStokWithId($totalStok, $id_baku);

		$stokTi = $this->ModTransaksiBaku->getStokKeluar($id_baku, $tanggal);
		$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggal);
		$totalStokTi = $stokTi - $qtyLama;
		$this->ModTransaksiBaku->updateStokKeluar($totalStokTi, $id_baku, $tanggal);

		// fifo logic
		$quantity = $qtyLama;
		$getInput = $this->ModInputBaku->getByStatusDesc($id_baku);
        foreach ($getInput as $row){
		    $id_input = $row->id_input;
		    $qty_input = $row->qty_input;
		    $fifo = $row->fifo;
		    $selisih = $qty_input-$fifo;

		    if ($quantity > $selisih) {
		    	$quantity = $quantity - $selisih;
		    	$this->ModInputBaku->updateStatusTersedia($id_input);
		    	$this->ModInputBaku->updateFifo($id_input, $qty_input);
		    }
			else {
				$fifo = $fifo + $quantity;
				$this->ModInputBaku->updateStatusTersedia($id_input);
		    	$this->ModInputBaku->updateFifo($id_input, $fifo);
		    	$quantity = 0;
		    }
		}

		$this->ModOutputBaku->delete($id);
		$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

		// cek hapus tanggal
		$this->ModTransaksiBaku->cekHapusTanggal($id_baku);

		// set status
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
		echo json_encode(array("status" => TRUE));
	}
	public function update() {
		$q = $this->session->userdata('status');
		if ($q != "login") {
			exit();
		}
		$id_baku = $this->input->post('id_baku');
		$id_output = $this->input->post('id_output');

		$tanggalBaru = $this->input->post('tgl_output');
		$tanggalLama = $this->ModOutputBaku->getTanggal($id_output);

		$qtyBaru = $this->input->post('qty_output');
		$qtyLama = $this->ModOutputBaku->getStok($id_output);
		$stok = $this->ModBaku->getStok($id_baku);

		$total = $stok + ($qtyLama-$qtyBaru);

		if ($total < 0) {
			$this->session->set_flashdata('stok', 'Stok / Pack tidak mencukupi!');
		} else {
			$this->ModOutputBaku->update();
			$this->ModOutputBaku->update_H_Stok($total);
			$totalStok = round($total, 5);
			$this->ModBaku->updateStok($totalStok);

			// transaksi items
			if ($tanggalLama == $tanggalBaru) {
				$stokTi = $this->ModTransaksiBaku->getStokKeluar($id_baku, $tanggalBaru);
				$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalBaru);
				$totalStokTi = $stokTi - ($qtyLama-$qtyBaru);
				$this->ModTransaksiBaku->updateStokKeluar($totalStokTi, $id_baku, $tanggalBaru);
				$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

				// fifo logic Dell
				$quantity = $qtyLama;
				$getInput = $this->ModInputBaku->getByStatusDesc($id_baku);
		        foreach ($getInput as $row){
				    $id_input = $row->id_input;
				    $qty_input = $row->qty_input;
				    $fifo = $row->fifo;
				    $selisih = $qty_input-$fifo;

				    if ($quantity > $selisih) {
				    	$quantity = $quantity - $selisih;
				    	$this->ModInputBaku->updateStatusTersedia($id_input);
				    	$this->ModInputBaku->updateFifo($id_input, $qty_input);
				    }
					else {
						$fifo = $fifo + $quantity;
						$this->ModInputBaku->updateStatusTersedia($id_input);
				    	$this->ModInputBaku->updateFifo($id_input, $fifo);
				    	$quantity = 0;
				    }
				}

				// fifo logic Add
				$quantity = $qtyBaru;
				$getInput = $this->ModInputBaku->getByStatusAsc($id_baku);
		        foreach ($getInput as $row){
				    $id_input = $row->id_input;
				    $fifo = $row->fifo;
				    $status = $row->status;

				    if ($quantity > $fifo) {
				    	$quantity = $quantity - $fifo;
				    	$this->ModInputBaku->updateStatusOut($id_input);
				    	$this->ModInputBaku->updateFifo($id_input, 0);
				    }
					else {
						$fifo = $fifo - $quantity;
				    	$this->ModInputBaku->updateFifo($id_input, $fifo);
				    	$quantity = 0;
				    }
				}

				// set status
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
				$cekTanggal = $this->ModTransaksiBaku->cekTanggal($id_baku, $tanggalBaru);
				if ($cekTanggal == 1) {
					$stokTi1 = $this->ModTransaksiBaku->getStokKeluar($id_baku, $tanggalLama);
					$sisa_stokTi1 = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalLama);
					$totalStokTi1 = $stokTi1 - $qtyLama;
					$this->ModTransaksiBaku->updateStokKeluar($totalStokTi, $id_baku, $tanggalLama);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

					$stokTi = $this->ModTransaksiBaku->getStokKeluar($id_baku, $tanggalBaru);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalBaru);
					$totalStokTi = $stokTi + $qtyBaru;
					$this->ModTransaksiBaku->updateStokKeluar($totalStokTi, $id_baku, $tanggalBaru);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);

					// cek hapus tanggal
					$this->ModTransaksiBaku->cekHapusTanggal($id_baku);
				} 
				else {
					$this->ModTransaksiBaku->addTanggalOutput($id_baku);
					$stokTi1 = $this->ModTransaksiBaku->getStokKeluar($id_baku, $tanggalLama);
					$sisa_stokTi1 = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalLama);
					$totalStokTi1 = $stokTi1 - $qtyLama;
					$this->ModTransaksiBaku->updateStokKeluar($totalStokTi, $id_baku, $tanggalLama);

					$stokTi = $this->ModTransaksiBaku->getStokKeluar($id_baku, $tanggalBaru);
					$sisa_stokTi = $this->ModTransaksiBaku->getStokSisa($id_baku, $tanggalBaru);
					$totalStokTi = $stokTi + $qtyBaru;
					$this->ModTransaksiBaku->updateStokKeluar($totalStokTi, $id_baku, $tanggalBaru);
					$this->ModTransaksiBaku->getSisaAllStokKb($id_baku);
					
					// cek hapus tanggal
					$this->ModTransaksiBaku->cekHapusTanggal($id_baku);
				}

				// fifo logic Dell
				$quantity = $qtyLama;
				$getInput = $this->ModInputBaku->getByStatusDesc($id_baku);
		        foreach ($getInput as $row){
				    $id_input = $row->id_input;
				    $qty_input = $row->qty_input;
				    $fifo = $row->fifo;
				    $selisih = $qty_input-$fifo;

				    if ($quantity > $selisih) {
				    	$quantity = $quantity - $selisih;
				    	$this->ModInputBaku->updateStatusTersedia($id_input);
				    	$this->ModInputBaku->updateFifo($id_input, $qty_input);
				    }
					else {
						$fifo = $fifo + $quantity;
						$this->ModInputBaku->updateStatusTersedia($id_input);
				    	$this->ModInputBaku->updateFifo($id_input, $fifo);
				    	$quantity = 0;
				    }
				}

				// fifo logic Add
				$quantity = $qtyBaru;
				$getInput = $this->ModInputBaku->getByStatusAsc($id_baku);
		        foreach ($getInput as $row){
				    $id_input = $row->id_input;
				    $fifo = $row->fifo;
				    $status = $row->status;

				    if ($quantity > $fifo) {
				    	$quantity = $quantity - $fifo;
				    	$this->ModInputBaku->updateStatusOut($id_input);
				    	$this->ModInputBaku->updateFifo($id_input, 0);
				    }
					else {
						$fifo = $fifo - $quantity;
				    	$this->ModInputBaku->updateFifo($id_input, $fifo);
				    	$quantity = 0;
				    }
				}

				// set status
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
	public function set_baku($id) {
		$q = $this->session->userdata('status');
		if($q != "login") {
			exit();
		}
		$data['baku'] = $this->ModBaku->edit($id);
		$this->load->view('modal/set-bakuOutput', $data);
	}
}
