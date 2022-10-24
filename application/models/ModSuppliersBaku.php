<?php
class ModSuppliersBaku extends CI_model {
	public function selectAll() {
        return $this->db->get('suppliers_baku')->result();
	}
	public function add() {
		$nama_supplier = $this->input->post('nama_supplier');
		$kontak = $this->input->post('kontak');
		
		$data = array('nama_supplier' => $nama_supplier,'kontak' => $kontak);
		$this->db->insert('suppliers_baku', $data);
	}
	public function delete($id){
		$this->db->where('id_supplier', $id);
		$this->db->delete('suppliers_baku');
	}
	public function edit($id){
		$this->db->where('id_supplier', $id);
		return $this->db->get('suppliers_baku')->row();
	}
	
	public function update(){
		$id = $this->input->post('id_supplier');
		$nama_supplier = $this->input->post('nama_supplier');
		$kontak = $this->input->post('kontak');

		$data = array('nama_supplier' => $nama_supplier,'kontak' => $kontak);
		$this->db->where('id_supplier', $id);
		$this->db->update('suppliers_baku', $data);
	}

	public function updateTerakhirTransaksi($id){
		$transaksi_terakhir = date("Y-m-d");
		$data = array('transaksi_terakhir' => $transaksi_terakhir);
		$this->db->where('id_supplier', $id);
		$this->db->update('suppliers_baku', $data);
	}

	public function cekSupplier(){
		$nama_supplier = $this->input->post('nama_supplier');
		$kontak = $this->input->post('kontak');
		$data = array('nama_supplier' => $nama_supplier,'kontak' => $kontak);
		$cek = $this->db->get_where('suppliers_baku', $data)->num_rows();
		if($cek > 0) {
			return "FALSE";
		} else {
			return "TRUE";
		}
    }

	public function getId(){
		$nama_supplier = $this->input->post('nama_supplier');
		$kontak = $this->input->post('kontak');
        $query = $this->db->query("SELECT id_supplier from suppliers_baku where nama_supplier='$nama_supplier' AND kontak='$kontak'");
        $hasil = $query->row();
        return $hasil->id_supplier;
	}
	
	public function getCountSupplier()
	{
		$this->db->select('id_supplier');
		$this->db->from('suppliers_baku');
		return $this->db->count_all_results();
	}
}