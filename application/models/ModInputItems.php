<?php
class ModInputItems extends CI_model {
	public function selectAll() {
		$this->db->select('*');
		$this->db->from('input_items');
		$this->db->join('suppliers', 'input_items.id_supplier = suppliers.id_supplier');
		$this->db->join('user', 'input_items.id_user = user.id_user');
		$this->db->order_by('tgl_input', "asc");
        return $this->db->get()->result();
	}
	public function listItems() {
		$this->db->order_by('nama_item', "asc");
        return $this->db->get('items')->result();
	}
	public function listSupplier() {
		$this->db->order_by('nama_supplier', "asc");
        return $this->db->get('suppliers')->result();
	}
	public function add($stok) {
		$id_item = $this->input->post('id_item');
		$id_supplier = $this->input->post('id_supplier');
		$qty_input = $this->input->post('qty_input');
		$kb_input = $this->input->post('kb_input');
		$tgl_input = $this->input->post('tgl_input');
		$h_stokInput = $stok;
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$id_user = $this->session->userdata('id_user');
		
		$data = array('id_item' => $id_item,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'kb_input' => $kb_input, 'tgl_input' => $tgl_input, 'h_stokInput' => $h_stokInput, 'nama_item' => $nama_item,'jenis' => $jenis, 'netto' => $netto, 'merk' => $merk, 'id_user' => $id_user);
		$this->db->insert('input_items', $data);
	}
	public function addTitem($id_item) {
		$id_item = $id_item;
		$id_supplier = $this->input->post('id_supplier');
		$qty_input = $this->input->post('qty_input');
		$kb_input = $this->input->post('kb_input');
		$h_stokInput = $this->input->post('qty_input');
		$tgl_input = $this->input->post('tgl_input');
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$id_user = $this->session->userdata('id_user');
		
		$data = array('id_item' => $id_item,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'kb_input' => $kb_input, 'tgl_input' => $tgl_input, 'h_stokInput' => $h_stokInput, 'nama_item' => $nama_item,'jenis' => $jenis, 'netto' => $netto, 'merk' => $merk, 'id_user' => $id_user);
		$this->db->insert('input_items', $data);
	}
	public function addTsupplier($id_supplier, $stok) {
		$id_item = $this->input->post('id_item');
		$id_supplier = $id_supplier;
		$qty_input = $this->input->post('qty_input');
		$kb_input = $this->input->post('kb_input');
		$tgl_input = $this->input->post('tgl_input');
		$h_stokInput = $stok;
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$id_user = $this->session->userdata('id_user');
		
		$data = array('id_item' => $id_item,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'kb_input' => $kb_input, 'tgl_input' => $tgl_input, 'h_stokInput' => $h_stokInput, 'nama_item' => $nama_item,'jenis' => $jenis, 'netto' => $netto, 'merk' => $merk, 'id_user' => $id_user);
		$this->db->insert('input_items', $data);
	}
	public function addTT($id_item, $id_supplier) {
		$id_item = $id_item;
		$id_supplier = $id_supplier;
		$qty_input = $this->input->post('qty_input');
		$kb_input = $this->input->post('kb_input');
		$tgl_input = $this->input->post('tgl_input');
		$h_stokInput = $this->input->post('qty_input');
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$id_user = $this->session->userdata('id_user');
		
		$data = array('id_item' => $id_item,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'kb_input' => $kb_input, 'tgl_input' => $tgl_input, 'h_stokInput' => $h_stokInput, 'nama_item' => $nama_item,'jenis' => $jenis, 'netto' => $netto, 'merk' => $merk, 'id_user' => $id_user);
		$this->db->insert('input_items', $data);
	}
	public function delete($id){
		$this->db->where('id_input', $id);
		$this->db->delete('input_items');
	}

	public function deleteByItem($id_item){
		$this->db->where('id_item', $id_item);
		$this->db->delete('input_items');
	}

	public function edit($id){
		$this->db->select('*');
		$this->db->from('input_items');
		$this->db->join('suppliers', 'input_items.id_supplier = suppliers.id_supplier');
		$this->db->join('user', 'input_items.id_user = user.id_user');
		$this->db->where('id_input', $id);
		return $this->db->get()->result();
	}
	
	public function update(){
		$id_input = $this->input->post('id_input');
		$id_item = $this->input->post('id_item');
		$id_supplier = $this->input->post('id_supplier');
		$qty_input = $this->input->post('qty_input');
		$kb_input = $this->input->post('kb_input');
		$tgl_input = $this->input->post('tgl_input');
		$id_user = $this->session->userdata('id_user');
		
		$data = array('id_item' => $id_item,'id_supplier' => $id_supplier, 'qty_input' => $qty_input, 'kb_input' => $kb_input,'tgl_input' => $tgl_input, 'id_user' => $id_user);
			$this->db->where('id_input', $id_input);
			$this->db->update('input_items', $data);
	}

	public function updateItems(){
		$id_item = $this->input->post('id_item');
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$merk = $this->input->post('merk');
		
		$data = array('nama_item' => $nama_item,'jenis' => $jenis, 'merk' => $merk);
			$this->db->where('id_item', $id_item);
			$this->db->update('input_items', $data);
	}

	public function update_H_Stok($stok){
		$id_input = $this->input->post('id_input');
		$h_stokInput = $stok;		
		$data = array('h_stokInput' => $h_stokInput);
		$this->db->where('id_input', $id_input);
		$this->db->update('input_items', $data);
	}


	public function GetMostInput()
	{

		$this->db->select('*, SUM(a.qty_input) AS total_stok');
		$this->db->from('input_items as a');
		$this->db->group_by('a.id_item'); 
		$this->db->order_by('a.qty_input', "desc");
		$this->db->limit('7');
        return $this->db->get()->result();
	}

	public function GetMostInputInMonth()
	{
		$awal_bulan = date('Y-m-d',strtotime('first day of this month'));
		$akhir_bulan = date('Y-m-d',strtotime('last day of this month'));
		$this->db->select('a.nama_item, a.qty_input, SUM(a.qty_input) AS total_stok');
		$this->db->from('input_items as a');
		$this->db->group_by('a.id_item');
		$this->db->order_by('a.qty_input', "desc");
		$this->db->where("a.tgl_input BETWEEN '$awal_bulan 'AND' $akhir_bulan'");
		$this->db->limit('7');
        return $this->db->get()->result();
	}

	public function InputFilter()
	{
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
		$this->db->select('*, SUM(a.qty_input) AS total_stok');
		$this->db->from('input_items as a');
		$this->db->group_by('a.id_item');
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
		$this->db->from('input_items');
		$this->db->join('suppliers', 'input_items.id_supplier = suppliers.id_supplier');
		$this->db->join('user', 'input_items.id_user = user.id_user');
		$this->db->order_by('tgl_input', "asc");
		if($this->session->userdata('startSession') != null && $this->session->userdata('endSession') != null){
			$this->db->where("input_items.tgl_input BETWEEN ' $stSession 'AND' $enSession'");
		}else{
			$this->db->where("input_items.tgl_input BETWEEN '$start 'AND' $end'");
		}
        return $this->db->get()->result();
	}

	public function getStok($id_input){
        $query = $this->db->query("SELECT qty_input from input_items where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->qty_input;
    }
    public function getStokByInput($id_input){
        $query = $this->db->query("SELECT stok from input_items INNER JOIN items ON input_items.id_item=items.id_item where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->stok;
    }

    public function getKb($id_input){
        $query = $this->db->query("SELECT kb_input from input_items where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->kb_input;
    }
    public function getKbByInput($id_input){
        $query = $this->db->query("SELECT kb from input_items INNER JOIN items ON input_items.id_item=items.id_item where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->kb;
    }

    public function getIdItem($id_input){
        $query = $this->db->query("SELECT id_item from input_items where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->id_item;
    }

    public function getTanggal($id_input){
        $query = $this->db->query("SELECT tgl_input from input_items where id_input= '$id_input'");
        $hasil = $query->row();
        return $hasil->tgl_input;
    }

    public function getTotalQtyProduk($id_item){
        $query = $this->db->query("SELECT SUM(qty_input) AS total FROM input_items WHERE id_item = '$id_item'");
        $hasil = $query->row();
        return $hasil->total;
    }

    public function getSinkronisasiStok($id_item){
    	$query = $this->db->query("SELECT tgl_input, SUM(qty_input) AS stok_masuk, SUM(kb_input) AS kb_masuk FROM input_items WHERE id_item='$id_item' GROUP BY tgl_input");
        $cek = $query->num_rows();
		if ($cek > 0) {
			$hasil = $query->result();
		} else {
			$hasil = 0;
		}
        return $hasil;	
    }

}