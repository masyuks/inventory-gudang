<?php
class ModItems extends CI_model {
	public function selectAll() {
		// $this->db->order_by('nama_user', "asc");
        return $this->db->get('items')->result();
	}
	public function add() {
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$stok = $this->input->post('qty_input');
		$kb = $this->input->post('kb_input');
		// $stok_limit = $this->input->post('stok_limit');
		
		$data = array('nama_item' => $nama_item,'jenis' => $jenis, 'netto' => $netto, 'merk' => $merk, 'stok' => $stok, 'kb' => $kb);
		$this->db->insert('items', $data);
	}
	public function addNoStok() {
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$stok_limit = $this->input->post('stok_limit');
		
		$data = array('nama_item' => $nama_item,'jenis' => $jenis, 'netto' => $netto, 'merk' => $merk, 'stok_limit' => $stok_limit);
		$this->db->insert('items', $data);
	}
	public function delete($id){
		$this->db->where('id_item', $id);
		$this->db->delete('items');
	}
	public function edit($id){
		$this->db->where('id_item', $id);
		return $this->db->get('items')->row();
	}
	public function update(){
		$id = $this->input->post('id_item');
		$stok_limit = $this->input->post('stok_limit');

		$data = array('stok_limit' => $stok_limit);
		$this->db->where('id_item', $id);
		$this->db->update('items', $data);
	}
 
	public function updateStok($stok){
		$id = $this->input->post('id_item');
		$stok = $stok;

		$data = array('stok' => $stok);
		$this->db->where('id_item', $id);
		$this->db->update('items', $data);
	}

	public function updateStokWithId($stok, $id){
		$id = $id;
		$stok = $stok;

		$data = array('stok' => $stok);
		$this->db->where('id_item', $id);
		$this->db->update('items', $data);
	}

	public function updateKb($kb){
		$id = $this->input->post('id_item');
		$kb = $kb;

		$data = array('kb' => $kb);
		$this->db->where('id_item', $id);
		$this->db->update('items', $data);
	}

	public function updateKbWithId($kb, $id){
		$id = $id;
		$kb = $kb;

		$data = array('kb' => $kb);
		$this->db->where('id_item', $id);
		$this->db->update('items', $data);
	}

	public function updateStokLimit(){
		$id = $this->input->post('id_item');
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$stok_limit = $this->input->post('stok_limit');

		$data = array('nama_item' => $nama_item,'jenis' => $jenis, 'netto' => $netto, 'merk' => $merk,'stok_limit' => $stok_limit);
		$this->db->where('id_item', $id);
		$this->db->update('items', $data);
	} 

	public function cekItem(){
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
		$data = array('nama_item'=>$nama_item, 'jenis'=>$jenis, 'netto'=>$netto, 'merk'=>$merk);
		$cek = $this->db->get_where('items', $data)->num_rows();
		if($cek > 0) {
			return "FALSE";
		} else {
			return "TRUE";
		}
    }

	public function getId(){
		$nama_item = $this->input->post('nama_item');
		$jenis = $this->input->post('jenis');
		$netto = $this->input->post('netto');
		$merk = $this->input->post('merk');
        $query = $this->db->query("SELECT id_item from items where nama_item='$nama_item' AND jenis='$jenis' AND netto='$netto' AND merk='$merk'");
        $hasil = $query->row();
        return $hasil->id_item;
    }

    public function getStok($id_item){
        $query = $this->db->query("SELECT stok from items where id_item= '$id_item'");
        $hasil = $query->row();
        return $hasil->stok;
	}

	public function getKb($id_item){
        $query = $this->db->query("SELECT kb from items where id_item= '$id_item'");
        $hasil = $query->row();
        return $hasil->kb;
	}

	public function getAllById($id_item){
        $query = $this->db->query("SELECT * from items where id_item= '$id_item'");
        $hasil = $query->row();
        return $hasil;
	}
	
	public function getNotifStokLimit()
	{
		$this->db->select('*');
		$this->db->from('items');
		$this->db->where('stok <= stok_limit');
		$this->db->where('stok_limit != 0');
        return $this->db->get()->result();
	}

	public function getCountBarang()
	{
		$this->db->select('id_item');
		$this->db->from('items');
		return $this->db->count_all_results();
	}

	public function getTransaksi($id)
	{
		$this->db->select('*');
		$this->db->from('items');
		$this->db->join('input_items', 'items.id_item = input_items.id_item');
		$this->db->join('output_items', 'input_items.id_item = output_items.id_item');
		$this->db->where('items.id_item = $id');
        return $this->db->get()->result();
	}
}