<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teknisi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin');
        $this->load->library('upload');
        if ($this->session->userdata('role') != '1') {
            redirect(site_url("login"));
        }
    }

    public function index()
    {


        echo "<h1>Halaman Teknisi Coming Soon</h1>";
    }
}
