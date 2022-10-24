<?php
class ModInputBaku extends CI_model {
	public function selectAll() {
		$this->db->select('*');
		$this->db->from('input_baku');
		$this->db->join('suppliers_baku', 'input_baku.id_supplier = suppliers_baku.id_supplier');
		$this->db->join('user', 'input_baku.id_user = user.id_user');
		$this->db->order_by('tgl_input', "asc");
        return $this->db->get()->result();
	}
	public function selectAllStatus($id_baku) {
		$this->db->select('*');
		$this->db->from('input_baku');
		$this->db->where('id_baku', $id_baku);
		$this->db->order_by('tgl_input', "asc");
        return $this->db->get()->result();
	}
	public function listAll() {
        $query = $this->db->query("SELECT * FROM input_baku ORDER BY id_input ASC");
        return $query->result();
	}
	public function listExpired() {
    	$this->db->select('*');
		$this->db->from('input_baku');
		$this->db->join('suppliers_baku', 'input_baku.id_supplier = suppliers_baku.id_supplier');
		$this->db->join('user', 'input_baku.id_user = user.id_user');
		$this->db->where('status', 'expired');
		$this->db->order_by('tgl_input', "asc");
        return $this->db->get()->result();
	}
	public function getByStatusAsc($id_baku) {
        $query = $this->db->query("SELECT * FROM input_baku WHERE status != 'expired' AND id_baku = '$id_baku' ORDER BY status ASC");
        return $query->result();
	}
	public function getByStatusDesc($id_baku) {
        $query = $this->db->query("SELECT * FROM input_baku WHERE status != 'expired' AND id_baku = '$id_baku' ORDER BY status DESC");
        return $query->result();
	}
	public function listBaku() {
		$this->db->order_by('nama_baku', "asc");
        return $this->db->get('baku')->result();
	}
	public function listSupplier() {
		$this->db->order_by('nama_supplier', "asc");
        return $this->db->get('suppliers_baku')->result();
	}
	public function add($stok) {
		$id_baku = $this->input->post('id_baku');
		$id_supplier = $this->input->post('id_supplier');
		$qty_input = $this->input->post('qty_input');
		$tgl_input = $this->input->post('tgl_input');
		$h_stokInput = $stok;
		$nama_baku = $this->input->post('nama_baku');
		$satuan = $this->input->post('satuan');
		$keterangan = $this->input->post('keterangan');
		$produsen = $this->input->post('produsen');
		$id_user = $this->session->userdata('id_user');
		$batch = $this->input->post('batch');
		$expired = $this->input->post('expired');
		$status = 'tersedia';
		$fifo = $this->input->post('qty_input');
		
		$data = array('id_baku' => $id_baku,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'tgl_input' => $tgl_input, 'h_stokInput' => $h_stokInput, 'nama_baku' => $nama_baku, 'satuan' => $satuan, 'keterangan' => $keterangan, 'produsen' => $produsen, 'id_user' => $id_user, 'batch' => $batch, 'expired' => $expired, 'status' => $status, 'fifo' => $fifo);
		$this->db->insert('input_baku', $data);
	}
	public function addTbaku($id_baku) {
		$id_baku = $id_baku;
		$id_supplier = $this->input->post('id_supplier');
		$qty_input = $this->input->post('qty_input');
		$h_stokInput = $this->input->post('qty_input');
		$tgl_input = $this->input->post('tgl_input');
		$nama_baku = $this->input->post('nama_baku');
		$satuan = $this->input->post('satuan');
		$keterangan = $this->input->post('keterangan');
		$produsen = $this->input->post('produsen');
		$id_user = $this->session->userdata('id_user');
		$batch = $this->input->post('batch');
		$expired = $this->input->post('expired');
		$status = 'tersedia';
		$fifo = $this->input->post('qty_input');
		
		$data = array('id_baku' => $id_baku,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'tgl_input' => $tgl_input, 'h_stokInput' => $h_stokInput, 'nama_baku' => $nama_baku, 'satuan' => $satuan, 'keterangan' => $keterangan, 'produsen' => $produsen, 'id_user' => $id_user, 'batch' => $batch, 'expired' => $expired, 'status' => $status, 'fifo' => $fifo);
		$this->db->insert('input_baku', $data);
	}
	public function addTsupplier($id_supplier, $stok) {
		$id_baku = $this->input->post('id_baku');
		$id_supplier = $id_supplier;
		$qty_input = $this->input->post('qty_input');
		$tgl_input = $this->input->post('tgl_input');
		$h_stokInput = $stok;
		$nama_baku = $this->input->post('nama_baku');
		$satuan = $this->input->post('satuan');
		$keterangan = $this->input->post('keterangan');
		$produsen = $this->input->post('produsen');
		$id_user = $this->session->userdata('id_user');
		$batch = $this->input->post('batch');
		$expired = $this->input->post('expired');
		$status = 'tersedia';
		$fifo = $this->input->post('qty_input');
		
		$data = array('id_baku' => $id_baku,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'tgl_input' => $tgl_input, 'h_stokInput' => $h_stokInput, 'nama_baku' => $nama_baku, 'satuan' => $satuan, 'keterangan' => $keterangan, 'produsen' => $produsen, 'id_user' => $id_user, 'batch' => $batch, 'expired' => $expired, 'status' => $status, 'fifo' => $fifo);
		$this->db->insert('input_baku', $data);
	}
	public function addTT($id_baku, $id_supplier) {
		$id_baku = $id_baku;
		$id_supplier = $id_supplier;
		$qty_input = $this->input->post('qty_input');
		$tgl_input = $this->input->post('tgl_input');
		$h_stokInput = $this->input->post('qty_input');
		$nama_baku = $this->input->post('nama_baku');
		$satuan = $this->input->post('satuan');
		$keterangan = $this->input->post('keterangan');
		$produsen = $this->input->post('produsen');
		$id_user = $this->session->userdata('id_user');
		$batch = $this->input->post('batch');
		$expired = $this->input->post('expired');
		$status = 'tersedia';
		$fifo = $this->input->post('qty_input');
		
		$data = array('id_baku' => $id_baku,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'tgl_input' => $tgl_input, 'h_stokInput' => $h_stokInput, 'nama_baku' => $nama_baku, 'satuan' => $satuan, 'keterangan' => $keterangan, 'produsen' => $produsen, 'id_user' => $id_user, 'batch' => $batch, 'expired' => $expired, 'status' => $status, 'fifo' => $fifo);
		$this->db->insert('input_baku', $data);
	}
	public function delete($id){
		$this->db->where('id_input', $id);
		$this->db->delete('input_baku');
	}

	public function deleteByBaku($id_baku){
		$this->db->where('id_baku', $id_baku);
		$this->db->delete('input_baku');
	}

	public function edit($id){
		$this->db->select('*');
		$this->db->from('input_baku');
		$this->db->join('suppliers_baku', 'input_baku.id_supplier = suppliers_baku.id_supplier');
		$this->db->join('user', 'input_baku.id_user = user.id_user');
		$this->db->where('id_input', $id);
		return $this->db->get()->result();
	}
	
	public function update(){
		$id_input = $this->input->post('id_input');
		$id_baku = $this->input->post('id_baku');
		$id_supplier = $this->input->post('id_supplier');
		$qty_input = $this->input->post('qty_input');
		$tgl_input = $this->input->post('tgl_input');
		$id_user = $this->session->userdata('id_user');
		$batch = $this->input->post('batch');
		$keterangan = $this->input->post('keterangan');
		$expired = $this->input->post('expired');
		$status = "tersedia";
		
		$data = array('id_baku' => $id_baku,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'tgl_input' => $tgl_input, 'id_user' => $id_user, 'batch' => $batch, 'keterangan' => $keterangan, 'expired' => $expired, 'status' => $status);
			$this->db->where('id_input', $id_input);
			$this->db->update('input_baku', $data);
	}

	public function updatebaku(){
		$id_baku = $this->input->post('id_baku');
		$nama_baku = $this->input->post('nama_baku');
		$satuan = $this->input->post('satuan');
		$produsen = $this->input->post('produsen');
		
		$data = array('nama_baku' => $nama_baku,'satuan' => $satuan, 'produsen' => $produsen);
			$this->db->where('id_baku', $id_baku);
			$this->db->update('input_baku', $data);
	}

	// public function updateStatus($now){
	// 	// $now = date('Y-m-d');
	// 	$query = $this->db->query("SELECT * FROM input_baku");
 //        foreach ($query->result() as $row){
	// 	    $id_input = $row->id_input;
	// 	    $expired = $row->expired;
	// 	    $status = $row->status;

	// 	    if ($expired == $now && $status != "expired") {
	// 	    	$this->db->query("UPDATE input_baku SET status='expired' WHERE id_input = '$id_input'");
	// 	    }
	// 		else if ($expired != $now && $status != "expired") {
	// 	    	$this->db->query("UPDATE input_baku SET status='hampir expired' WHERE NOW() >= DATE_SUB(expired, INTERVAL '3' MONTH)");
	// 	    }
	// 	}
	// }
	public function updateStatusTersedia($id_input){
		$this->db->query("UPDATE input_baku SET status='tersedia' WHERE id_input = '$id_input'");
	}

	public function updateStatusExpired($id_input){
		$this->db->query("UPDATE input_baku SET status='expired' WHERE id_input = '$id_input'");
	}

	public function updateStatusHampir($id_input){
		$this->db->query("UPDATE input_baku SET status='hampir expired' WHERE NOW() >= DATE_SUB(expired, INTERVAL '3' MONTH) AND id_input = '$id_input'");
	}

	public function updateStatusOut($id_input){
		$this->db->query("UPDATE input_baku SET status='out' WHERE id_input = '$id_input'");
	}

	public function updateFifo($id_input, $qty){
		$this->db->query("UPDATE input_baku SET fifo='$qty' WHERE id_input = '$id_input'");
	}

	public function update_H_Stok($stok){
		$id_input = $this->input->post('id_input');
		$h_stokInput = $stok;		
		$data = array('h_stokInput' => $h_stokInput);
		$this->db->where('id_input', $id_input);
		$this->db->update('input_baku', $data);
	}


	public function GetMostInput()
	{

		$this->db->select('*, SUM(a.qty_input) AS total_stok');
		$this->db->from('input_baku as a');
		$this->db->group_by('a.id_baku'); 
		$this->db->order_by('a.qty_input', "desc");
		$this->db->limit('7');
        return $this->db->get()->result();
	}

	public function GetMostInputInMonth()
	{
		$awal_bulan = date('Y-m-d',strtotime('first day of this month'));
		$akhir_bulan = date('Y-m-d',strtotime('last day of this month'));
		$this->db->select('a.nama_baku, a.qty_input, SUM(a.qty_input) AS total_stok');
		$this->db->from('input_baku as a');
		$this->db->group_by('a.id_baku');
		$this->db->order_by('a.qty_input', "desc");
		$this->db->where("a.tgl_input BETWEEN '$awal_bulan 'AND' $akhir_bulan'");
		$this->db->limit('7');
        return $this->db->get()->result();
	}

	public function InputFilter()
	{
		$start = $this->input->post('startBaku');
		$end = $this->input->post('endBaku');
		if($this->session->userdata('startSession')==null && $this->session->userdata('endSession')==null){
			$this->session->set_userdata('startSession', $start);
			$this->session->set_userdata('endSession', $end);
		}else if($this->session->userdata('startSession')!=null && $this->session->userdata('endSession')!=null && $start!=null && $end!=null){
			$this->session->set_userdata('startSession', $start);
			$this->session->set_userdata('endSession', $end);
		}
		$stSession = $this->session->userdata('startSession');
		$enSession =  $this->session->userdata('endSession');
		$this->db->select('*, SUM(a.qty_input) AS total_stok');
		$this->db->from('input_baku as a');
		$this->db->group_by('a.id_baku');
		$this->db->order_by('a.qty_input', "desc");
		if($this->session->userdata('startSession') != null && $this->session->userdata('endSession') != null){
			$this->db->where("a.tgl_input BETWEEN ' $stSession 'AND' $enSession'");
		}else{
			$this->db->where("a.tgl_input BETWEEN '$start 'AND' $end'");
		}
		$this->db->limit('5');
        return $this->db->get()->result();
	}

	public function filter() {
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
		$this->db->select('*');
		$this->db->from('input_baku');
		$this->db->join('suppliers_baku', 'input_baku.id_supplier = suppliers_baku.id_supplier');
		$this->db->join('user', 'input_baku.id_user = user.id_user');
		$this->db->order_by('tgl_input', "asc");
		if($this->session->userdata('startSession') != null && $this->session->userdata('endSession') != null){
			$this->db->where("input_baku.tgl_input BETWEEN ' $stSession 'AND' $enSession'");
		}else{
			$this->db->where("input_baku.tgl_input BETWEEN '$start 'AND' $end'");
		}
        return $this->db->get()->result();
	}

	public function filterExpired() {
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
		$this->db->select('*');
		$this->db->from('input_baku');
		$this->db->join('suppliers_baku', 'input_baku.id_supplier = suppliers_baku.id_supplier');
		$this->db->join('user', 'input_baku.id_user = user.id_user');
		$this->db->order_by('tgl_input', "asc");
		if($this->session->userdata('startSession') != null && $this->session->userdata('endSession') != null){
			$this->db->where("input_baku.tgl_input BETWEEN ' $stSession 'AND' $enSession'");
		}else{
			$this->db->where("input_baku.tgl_input BETWEEN '$start 'AND' $end'");
		}
		$this->db->where("input_baku.status = 'expired'");
        return $this->db->get()->result();
	}

	public function getStok($id_input){
        $query = $this->db->query("SELECT qty_input from input_baku where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->qty_input;
    }
    public function getStokByInput($id_input){
        $query = $this->db->query("SELECT stok from input_baku INNER JOIN baku ON input_baku.id_baku=baku.id_baku where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->stok;
    }

    public function getIdBaku($id_input){
        $query = $this->db->query("SELECT id_baku from input_baku where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->id_baku; 
    }

    public function getTanggal($id_input){
        $query = $this->db->query("SELECT tgl_input from input_baku where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->tgl_input;
    }

    public function getStatus($id_input){
        $query = $this->db->query("SELECT status from input_baku where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->status;
    }

    public function getTotalQtyProduk($id_baku){
        $query = $this->db->query("SELECT SUM(qty_input) AS total FROM input_baku WHERE id_baku = '$id_baku'");
        $hasil = $query->row();
        return $hasil->total;
	}
	
	public function getNotifStokExpired()
	{
		$this->db->select('*');
		$this->db->from('input_baku');
		$this->db->where('status="hampir expired"');
        return $this->db->get()->result();
	}

    public function getHampirExpired(){
    	$query = $this->db->query("SELECT nama_baku, satuan, SUM(fifo) AS fifo FROM input_baku WHERE status != 'expired' AND status = 'hampir expired' GROUP BY id_baku");
        return $query->result();
    }

    public function getSinkronisasiStok($id_baku){
    	$query = $this->db->query("SELECT tgl_input, SUM(qty_input) AS stok_masuk FROM input_baku WHERE id_baku='$id_baku' AND status != 'expired' GROUP BY tgl_input");
        $cek = $query->num_rows();
		if ($cek > 0) {
			$hasil = $query->result();
		} else {
			$hasil = 0;
		}
        return $hasil;	
    }

}