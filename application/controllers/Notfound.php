<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notfound extends CI_Controller
{


    public function index()
    {
        $data['title'] = 'Error 404';
        $this->load->view('errors/e404', $data);
    }
}
