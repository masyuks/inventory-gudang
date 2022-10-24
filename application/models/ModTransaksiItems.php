<?php
class ModTransaksiItems extends CI_model {
	public function selectAll() {
		$this->db->order_by('tanggal', 'desc');
        return $this->db->get('transaksi_items')->result();
	} 

	public function selectAllById($id) {
		$this->db->where('id_item', $id);
		$this->db->order_by('tanggal', 'asc');
		return $this->db->get('transaksi_items')->result();
		
	}
	public function selectId($id) {
		$this->db->where('id_item', $id);
		return $this->db->get('transaksi_items')->row();
	}
	public function filter($id) {
		
		$start = $this->input->post('start');
		$end = $this->input->post('end'); 
		if($this->session->userdata('startSession')==null && $this->session->userdata('endSession')==null){
			$this->session->set_userdata('startSession', $start);
			$this->session->set_userdata('endSession', $end);
		}else if($this->session->userdata('startSession')!=null && $this->session->userdata('endSession')!=null && $start!=null && $end!=null){
			$this->session->set_userdata('startSession', $start);
			$this->session->set_userdata('endSession', $end);
		}
		$stSession = $this->session->userdata('startSession');
		$enSession =  $this->session->userdata('endSession');
		$this->db->where('id_item', $id);
		if($this->session->userdata('startSession') != null && $this->session->userdata('endSession') != null){
			$this->db->where("tanggal BETWEEN ' $stSession 'AND' $enSession'");
		}else{
			$this->db->where("tanggal BETWEEN '$start 'AND' $end'");
		}
		return $this->db->get('transaksi_items')->result();
		
	}
	public function cekTanggal($id_item, $tanggal) {
		$data = array('id_item'=>$id_item, 'tanggal'=>$tanggal);
		$cek = $this->db->get_where('transaksi_items', $data)->num_rows();
		if($cek > 0) {
			return 1;
		}
	}
	public function addTanggal($id_item, $tanggal) {
		$data = array('tanggal' => $tanggal,'id_item' => $id_item);
		$this->db->insert('transaksi_items', $data);
	}
	public function addTanggalInput($id_item) {
		$id_item = $id_item;
		$tanggal = $this->input->post('tgl_input');
		
		$data = array('tanggal' => $tanggal,'id_item' => $id_item);
		$this->db->insert('transaksi_items', $data);
	}
	public function addTanggalOutput($id_item) {
		$id_item = $id_item;
		$tanggal = $this->input->post('tgl_output');
		
		$data = array('tanggal' => $tanggal,'id_item' => $id_item);
		$this->db->insert('transaksi_items', $data);
	}
	public function delete($id){
		$this->db->where('id_ti', $id);
		$this->db->delete('transaksi_items');
	}

	public function deleteByItem($id_item){
		$this->db->where('id_item', $id_item);
		$this->db->delete('transaksi_items');
	}

	public function deleteByTanggal($id, $tanggal){
		$this->db->where('id_item', $id);
		$this->db->where('tanggal', $tanggal);
		$this->db->delete('transaksi_items');
	}
	public function edit($id){
		$this->db->where('id_ti', $id);
		return $this->db->get('transaksi_items')->row();
	}
	public function update(){
		$id = $this->input->post('id_ti');
		$keterangan = $this->input->post('keterangan');

		$data = array('keterangan' => $keterangan);
		$this->db->where('id_ti', $id);
		$this->db->update('transaksi_items', $data);
	}

	public function getStokMasuk($id_item, $tanggal){
        $query = $this->db->query("SELECT stok_masuk from transaksi_items where id_item= '$id_item' AND tanggal= '$tanggal'");
        $hasil = $query->row();
        return $hasil->stok_masuk;
	}

	public function getKbMasuk($id_item, $tanggal){
        $query = $this->db->query("SELECT kb_masuk from transaksi_items where id_item= '$id_item' AND tanggal= '$tanggal'");
        $hasil = $query->row();
        return $hasil->kb_masuk;
	}

	public function getStokKeluar($id_item, $tanggal){
        $query = $this->db->query("SELECT stok_keluar from transaksi_items where id_item= '$id_item' AND tanggal= '$tanggal'");
        $hasil = $query->row();
        return $hasil->stok_keluar;
	}

	public function getKbKeluar($id_item, $tanggal){
        $query = $this->db->query("SELECT kb_keluar from transaksi_items where id_item= '$id_item' AND tanggal= '$tanggal'");
        $hasil = $query->row();
        return $hasil->kb_keluar;
	}

	public function getStokSisa($id_item, $tanggal){
        $query = $this->db->query("SELECT sisa_stok from transaksi_items where id_item= '$id_item' AND tanggal= '$tanggal'");
        $hasil = $query->row();
        return $hasil->sisa_stok;
	}

	public function getKbSisa($id_item, $tanggal){
        $query = $this->db->query("SELECT sisa_kb from transaksi_items where id_item= '$id_item' AND tanggal= '$tanggal'");
        $hasil = $query->row();
        return $hasil->sisa_kb;
	}

	// public function getIdTanggal($id_item){
	// 	$this->db->where('id_item', $id_item);
 //        return $this->db->get('transaksi_items')->result();
	// }

	public function getSisaAllStokKb($id_item){
		$query = $this->db->query("SELECT * FROM transaksi_items WHERE id_item= '$id_item'");
        foreach ($query->result() as $row){
		    $id_item = $row->id_item;
		    $tanggal = $row->tanggal;

		    $query1 = $this->db->query("SELECT SUM(stok_masuk) AS stok_masuk FROM transaksi_items WHERE id_item= '$id_item' AND tanggal <= '$tanggal'");
	        $hasil1 = $query1->row();
	        $asm = $hasil1->stok_masuk;

	        $query2 = $this->db->query("SELECT SUM(stok_keluar) AS stok_keluar FROM transaksi_items WHERE id_item= '$id_item' AND tanggal <= '$tanggal'");
	        $hasil2 = $query2->row();
	        $ask = $hasil2->stok_keluar;

	        $query3 = $this->db->query("SELECT SUM(kb_masuk) AS kb_masuk FROM transaksi_items WHERE id_item= '$id_item' AND tanggal <= '$tanggal'");
	        $hasil3 = $query3->row();
	        $akm = $hasil3->kb_masuk;

	        $query4 = $this->db->query("SELECT SUM(kb_keluar) AS kb_keluar FROM transaksi_items WHERE id_item= '$id_item' AND tanggal <= '$tanggal'");
	        $hasil4 = $query4->row();
	        $akk = $hasil4->kb_keluar;

	        $ss = $asm - $ask;
	        $sk = $akm - $akk;
	        $sisa_stok = round($ss, 5);

			$dataStok = array('sisa_stok' => $sisa_stok);
			$this->db->where('id_item', $id_item);
			$this->db->where('tanggal', $tanggal);
			$this->db->update('transaksi_items', $dataStok);

			$dataKb = array('sisa_kb' => $sk);
			$this->db->where('id_item', $id_item);
			$this->db->where('tanggal', $tanggal);
			$this->db->update('transaksi_items', $dataKb);
		}
	}

	public function cekHapusTanggal($id_item){
		$query = $this->db->query("SELECT * FROM transaksi_items WHERE id_item= '$id_item'");
        foreach ($query->result() as $row){
		    $id_item = $row->id_item;
		    $tanggal = $row->tanggal;

		    $query1 = $this->db->query("SELECT stok_masuk FROM transaksi_items WHERE id_item= '$id_item' AND tanggal = '$tanggal'");
	        $hasil1 = $query1->row();
	        $asm = $hasil1->stok_masuk;

	        $query2 = $this->db->query("SELECT stok_keluar FROM transaksi_items WHERE id_item= '$id_item' AND tanggal = '$tanggal'");
	        $hasil2 = $query2->row();
	        $ask = $hasil2->stok_keluar;

	        if ($asm <= 0 && $ask <= 0) {
	        	$this->db->where('id_item', $id_item);
				$this->db->where('tanggal', $tanggal);
				$this->db->delete('transaksi_items');
	        }
		}
	}

	public function getAllStokMasuk($id_item, $tanggal){
        $query = $this->db->query("SELECT SUM(stok_masuk) AS stok_masuk FROM transaksi_items WHERE id_item= '$id_item' AND tanggal <= '$tanggal'");
        $hasil = $query->row();
        return $hasil->stok_masuk;
	}

	public function getAllStokKeluar($id_item, $tanggal){
        $query = $this->db->query("SELECT SUM(stok_keluar) AS stok_keluar FROM transaksi_items WHERE id_item= '$id_item' AND tanggal <= '$tanggal'");
        $hasil = $query->row();
        return $hasil->stok_keluar;
	}

	public function getAllKbMasuk($id_item, $tanggal){
        $query = $this->db->query("SELECT SUM(kb_masuk) AS kb_masuk FROM transaksi_items WHERE id_item= '$id_item' AND tanggal <= '$tanggal'");
        $hasil = $query->row();
        return $hasil->kb_masuk;
	}

	public function getAllKbKeluar($id_item, $tanggal){
        $query = $this->db->query("SELECT SUM(kb_keluar) AS kb_keluar FROM transaksi_items WHERE id_item= '$id_item' AND tanggal <= '$tanggal'");
        $hasil = $query->row();
        return $hasil->kb_keluar;
	}
 
	public function updateStokMasuk($stok, $id_item, $tanggal){
		$stok_masuk = $stok;

		$data = array('stok_masuk' => $stok_masuk);
		$this->db->where('id_item', $id_item);
		$this->db->where('tanggal', $tanggal);
		$this->db->update('transaksi_items', $data);
	}

	public function updateKbMasuk($kb, $id_item, $tanggal){
		$kb_masuk = $kb;

		$data = array('kb_masuk' => $kb_masuk);
		$this->db->where('id_item', $id_item);
		$this->db->where('tanggal', $tanggal);
		$this->db->update('transaksi_items', $data);
	}

	public function updateStokKeluar($stok, $id_item, $tanggal){
		$stok_keluar = $stok;

		$data = array('stok_keluar' => $stok_keluar);
		$this->db->where('id_item', $id_item);
		$this->db->where('tanggal', $tanggal);
		$this->db->update('transaksi_items', $data);
	}

	public function updateKbKeluar($kb, $id_item, $tanggal){
		$kb_keluar = $kb;

		$data = array('kb_keluar' => $kb_keluar);
		$this->db->where('id_item', $id_item);
		$this->db->where('tanggal', $tanggal);
		$this->db->update('transaksi_items', $data);
	}

	public function updateStokSisa($stok, $id_item, $tanggal){
		$sisa_stok = $stok;

		$data = array('sisa_stok' => $sisa_stok);
		$this->db->where('id_item', $id_item);
		$this->db->where('tanggal', $tanggal);
		$this->db->update('transaksi_items', $data);
	}

	public function updateKbSisa($kb, $id_item, $tanggal){
		$sisa_kb = $kb;

		$data = array('sisa_kb' => $sisa_kb);
		$this->db->where('id_item', $id_item);
		$this->db->where('tanggal', $tanggal);
		$this->db->update('transaksi_items', $data);
	}

	public function updateSinkronisasiAwal($id_item){
		$data = array('stok_masuk' => 0, 'stok_keluar' => 0, 'sisa_stok' => 0, 'kb_masuk' => 0, 'kb_keluar' => 0, 'sisa_kb' => 0);
		$this->db->where('id_item', $id_item);
		$this->db->update('transaksi_items', $data);
	}

	public function getSinkronisasiSisaStok($id_item){
		$query = $this->db->query("SELECT sisa_stok FROM transaksi_items WHERE id_item = '$id_item' ORDER BY tanggal DESC LIMIT 1");
		$cek = $query->num_rows();
		if ($cek > 0) {
			$cekHasil = $query->row();
			$hasil = $cekHasil->sisa_stok;
		} else {
			$hasil = 0;
		}
        return $hasil;	
    }
}