<?php
defined('BASEPATH') OR exit('No direct scipt access allowes');

class BackupDatabase extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
	}

	public function backup()
    {
        $q = $this->session->userdata('status');
        if($q != "login") {
            redirect('login','refresh');
        }
    	date_default_timezone_set('Asia/Jakarta');
        $this->load->dbutil();
        $db_format=array('format'=>'zip','filename'=>'db_inventorymel.sql');
        $backup=& $this->dbutil->backup($db_format);
        $dbname='DB Inventory backup ('.date('d-m-Y').').zip';
        $save='assets/backup/'.$dbname;
        write_file($save,$backup);
        force_download($dbname,$backup);
    }
}
?>