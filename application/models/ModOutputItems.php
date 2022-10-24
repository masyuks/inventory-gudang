<?php
class ModOutputItems extends CI_model {
	public function selectAll() {
		$this->db->select('*');
		$this->db->from('output_items');
		$this->db->join('user', 'output_items.id_user = user.id_user');
		$this->db->order_by('tgl_output', "asc");
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
		$this->db->from('output_items');
		$this->db->join('user', 'output_items.id_user = user.id_user');
		$this->db->order_by('tgl_output', "asc");
		if($this->session->userdata('startSession') != null && $this->session->userdata('endSession') != null){
			$this->db->where("output_items.tgl_output BETWEEN ' $stSession 'AND' $enSession'");
		}else{
			$this->db->where("output_items.tgl_output BETWEEN '$start 'AND' $end'");
		}
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
		$qty_output = $this->input->post('qty_output');
		$kb_output = $this->input->post('kb_output');
		$h_stokOutput = $stok;
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$tgl_output = $this->input->post('tgl_output');
		$id_user = $this->session->userdata('id_user');
		$keterangan = $this->input->post('keterangan');
		
		$data = array('id_item' => $id_item, 'qty_output' => $qty_output, 'kb_output' => $kb_output, 'tgl_output' => $tgl_output, 'h_stokOutput' => $h_stokOutput, 'nama_item' => $nama_item,'jenis' => $jenis, 'netto' => $netto, 'merk' => $merk, 'id_user' => $id_user, 'keterangan' => $keterangan);
		$this->db->insert('output_items', $data);
	}

	public function delete($id){
		$this->db->where('id_output', $id);
		$this->db->delete('output_items');
	}

	public function deleteByItem($id_item){
		$this->db->where('id_item', $id_item);
		$this->db->delete('output_items');
	}

	public function edit($id){
		$this->db->select('*');
		$this->db->from('output_items');
		$this->db->join('user', 'output_items.id_user = user.id_user');
		$this->db->where('id_output', $id);
		return $this->db->get()->result();
	}
	
	public function update(){
		$id_output = $this->input->post('id_output');
		$id_item = $this->input->post('id_item');
		$qty_output = $this->input->post('qty_output');
		$kb_output = $this->input->post('kb_output');
		$tgl_output = $this->input->post('tgl_output');
		$id_user = $this->session->userdata('id_user');
		$keterangan = $this->input->post('keterangan');
		
		$data = array('id_item' => $id_item, 'qty_output' => $qty_output, 'kb_output' => $kb_output, 
		'tgl_output' => $tgl_output, 'id_user' => $id_user, 'keterangan' => $keterangan);
			$this->db->where('id_output', $id_output);
			$this->db->update('output_items', $data);
	}

	public function updateItems(){
		$id_item = $this->input->post('id_item');
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$merk = $this->input->post('merk');
		
		$data = array('nama_item' => $nama_item,'jenis' => $jenis, 'merk' => $merk);
		$this->db->where('id_item', $id_item);
		$this->db->update('output_items', $data);
	}

	public function update_H_Stok($stok){
		$id_output = $this->input->post('id_output');
		$h_stokOutput = $stok;		
		$data = array('h_stokOutput' => $h_stokOutput);
		$this->db->where('id_output', $id_output);
		$this->db->update('output_items', $data);
	}

	public function getStok($id_output){
        $query = $this->db->query("SELECT qty_output from output_items where id_output= '$id_output'");
        $hasil = $query->row();
        return $hasil->qty_output;
    }
    public function getStokByOutput($id_output){
        $query = $this->db->query("SELECT stok from output_items INNER JOIN items ON output_items.id_item=items.id_item where id_output= '$id_output'");
        $hasil = $query->row();
        return $hasil->stok;
    }

    public function getKb($id_output){
        $query = $this->db->query("SELECT kb_output from output_items where id_output= '$id_output'");
        $hasil = $query->row();
        return $hasil->kb_output;
    }
    public function getKbByOutput($id_output){
        $query = $this->db->query("SELECT kb from output_items INNER JOIN items ON output_items.id_item=items.id_item where id_output= '$id_output'");
        $hasil = $query->row();
        return $hasil->kb;
    }

    public function getIdItem($id_output){
        $query = $this->db->query("SELECT id_item from output_items where id_output= '$id_output'");
        $hasil = $query->row();
        return $hasil->id_item;
	}
	
	public function GetMostOutput()
	{
		$this->db->select('*, SUM(a.qty_output) AS total_stok');
		$this->db->from('output_items as a');
		$this->db->group_by('a.id_item');
		$this->db->order_by('a.qty_output', "desc");
		$this->db->limit('7');
        return $this->db->get()->result();
	}

	public function OutputFilter()
	{
		$start = $this->input->post('startOut');
		$end = $this->input->post('endOut');
		if($this->session->userdata('startSession')==null && $this->session->userdata('endSession')==null){
			$this->session->set_userdata('startSession', $start);
			$this->session->set_userdata('endSession', $end);
		}else if($this->session->userdata('startSession')!=null && $this->session->userdata('endSession')!=null && $start!=null && $end!=null){
			$this->session->set_userdata('startSession', $start);
			$this->session->set_userdata('endSession', $end);
		}
		$stSession = $this->session->userdata('startSession');
		$enSession =  $this->session->userdata('endSession');
		$this->db->select('*, SUM(a.qty_output) AS total_stok');
		$this->db->from('output_items as a');
		$this->db->group_by('a.id_item');
		$this->db->order_by('a.qty_output', "desc");
		if($this->session->userdata('startSession') != null && $this->session->userdata('endSession') != null){
			$this->db->where("a.tgl_output BETWEEN ' $stSession 'AND' $enSession'");
		}else{
			$this->db->where("a.tgl_output BETWEEN '$start 'AND' $end'");
		}
		$this->db->limit('5');
        return $this->db->get()->result();
	}

	 public function getTanggal($id_output){
        $query = $this->db->query("SELECT tgl_output from output_items where id_output= '$id_output'");
        $hasil = $query->row();
        return $hasil->tgl_output;
    }

    public function getTotalQtyProduk($id_item){
        $query = $this->db->query("SELECT SUM(qty_output) AS total FROM output_items WHERE id_item = '$id_item'");
        $hasil = $query->row();
        return $hasil->total;
    }

    public function getSinkronisasiStok($id_item){
    	$query = $this->db->query("SELECT tgl_output, SUM(qty_output) AS stok_keluar, SUM(kb_output) AS kb_keluar FROM output_items WHERE id_item='$id_item' GROUP BY tgl_output");
        $cek = $query->num_rows();
		if ($cek > 0) {
			$hasil = $query->result();
		} else {
			$hasil = 0;
		}
        return $hasil;	
    }

}