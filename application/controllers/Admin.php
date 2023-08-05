<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin');
        $this->load->library('mailer');
        $this->load->library('upload');
        if ($this->session->userdata('role') != '0') {
            redirect(site_url("login"));
        }
    }

    public function index()
    {
        $data['count'] = $this->M_admin->notif_stok('tb_sparepart');
        $data['num'] = $this->M_admin->notif_stok_jml('tb_sparepart');
        $data['dataUser'] = $this->M_admin->numrows('tb_user');
        $data['avatar'] = $this->M_admin->get_data_avatar(' tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Home';
        $this->load->view('admin/index', $data);
    }
    public function signout()
    {
        session_destroy();
        redirect('login');
    }

    public function token_generate()
    {
        return $tokens = md5(uniqid(rand(), true));
    }

    private function hash_password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function backup_db()
    {
        $this->load->dbutil();
        $db_name = $this->db->database . '.sql';
        $prefs = array(
            'format' => 'txt',
            'filename' => $db_name,
            // 'add_insert' => true,
            // 'foreign_key_checks' => false
        );

        $backup = $this->dbutil->backup($prefs);
        $save = '.assets/backup_db/' . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);

        $this->load->helper('download');
        force_download($db_name, $backup);
    }
    ####################################
    //* Users
    ####################################
    public function users()
    {
        $data['avatar'] = $this->M_admin->get_data_avatar(' tb_avatar', $this->session->userdata('name'));
        $data['user'] = $this->M_admin->select('tb_user');
        $data['title'] = 'Users';
        $this->load->view('admin/form_users/users', $data);
    }

    public function tambah_users()
    {
        $data['avatar'] = $this->M_admin->get_data_avatar(' tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Tambah User';
        $this->load->view('admin/form_users/tambahuser', $data);
    }

    public function proses_tambahuser()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == true) {

            $nama     = $this->input->post('nama', true);
            $email     = $this->input->post('email', true);
            $username     = $this->input->post('username', true);
            $password     = $this->input->post('password', true);
            $role         = $this->input->post('role', true);

            $data = array(
                'nama'    => $nama,
                'email'    => $email,
                'username'    => $username,
                'password'     => $this->hash_password($password),
                'role'         => $role,
            );

            $dataUpload = array(
                'id' => '',
                'username_user' => $username,
                'nama_file' => 'nopic.png'
            );

            $this->M_admin->insert('tb_user', $data);
            $this->M_admin->insert('tb_avatar', $dataUpload);

            $this->session->set_flashdata('msg_sukses', 'User Berhasil Ditambahkan');
            redirect(base_url('admin/users'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar(' tb_avatar', $this->session->userdata('name'));
            $header['title'] = 'Tambah User';
            $this->load->view('admin/form_users/tambahuser', $header);
        }

        // $data['title'] = 'Tambah User';
        // $this->load->view('admin/form_users/tambahuser', $data);
    }

    public function proses_deleteuser()
    {
        $id = $this->uri->segment(3);
        $where = array('id' => $id);
        $this->M_admin->delete('tb_user', $where);
        $this->session->set_flashdata('msg_sukses', 'User Berhasil Di Hapus');
        redirect(base_url('admin/users'));
    }

    public function edit_user()
    {
        $data['avatar'] = $this->M_admin->get_data_avatar(' tb_avatar', $this->session->userdata('name'));
        $id = $this->uri->segment(3);
        $where = array('id' => $id);
        $data['list_data'] = $this->M_admin->get_data('tb_user', $where);
        $data['title'] = 'Edit User';
        $this->load->view('admin/form_users/edituser', $data);
    }

    public function proses_edituser()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');

        if ($this->form_validation->run() == true) {
            $id    = $this->input->post('id', true);
            $username    = $this->input->post('username', true);
            $email     = $this->input->post('email', true);
            $nama    = $this->input->post('nama', true);
            $role = $this->input->post('role', true);

            $where = array('id' => $id);
            $data = array(
                'username' => $username,
                'email'    => $email,
                'nama' => $nama,
                'role' => $role,
            );
            $this->M_admin->update('tb_user', $data, $where);
            $this->session->set_flashdata('msg_sukses', 'Data User Berhasil Diubah');
            redirect(base_url('admin/users'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar(' tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Edit User';
            $this->load->view('admin/form_users/edituser', $data);
        }
    }
    ####################################
    //* End Users
    ####################################

    ####################################
    //* Profile
    ####################################
    public function profile()
    {
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Profile';
        $this->load->view('admin/form_users/profile', $data);
        // $this->load->view('admin/profile', $data);
    }

    public function proses_newpassword()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required');
        $this->form_validation->set_rules('confirm_new_password', 'Konfirmasi Password Baru', 'required|matches[new_password]');

        if ($this->form_validation->run() == true) {

            $username = $this->input->post('username');
            $nama = $this->input->post('nama');
            $new_password = $this->input->post('new_password');

            $data = array(
                'nama' => $nama,
                'password' => $this->hash_password($new_password)
            );
            $where = array(
                'id' => $this->session->userdata('id')
            );
            $this->M_admin->update_password('tb_user', $where, $data);
            $this->session->set_flashdata('msg_sukses', 'Password Berhasil Diganti, Silahkan Sign Out dan Login Kembali');
            redirect(base_url('admin/profile'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Profile';
            $this->load->view('admin/form_users/profile', $data);
        }
    }

    public function proses_gambarupload()
    {
        $config = array(
            'upload_path' => "./assets/upload/user/",
            'allowed_types' => "jpg|png|jpeg",
            'ecrypt_name'    => false,
            'overwrite'    => true,
            // 'file_name'	=> uniqid(),
            'max_size' => "5000",
            'max_height' => "1024",
            'max_width' => "1024"
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('userpicture')) {
            $this->session->set_flashdata('msg_gambar_error', $this->upload->display_errors());
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Profile';
            $this->load->view('admin/form_users/profile', $data);
        } else {
            $data_upload = array('upload_data' => $this->upload->data());
            $nama_file = $data_upload['upload_data']['file_name'];

            $where = array(
                'username_user' => $this->session->userdata('name')
            );
            $data = array(
                'nama_file' => $nama_file
            );

            $this->M_admin->update_avatar($where, $data);
            $this->session->set_flashdata('msg_gambar_sukses', 'Gambar Berhasil Di Upload');
            redirect(base_url('admin/profile'));
        }
    }

    ####################################
    //* End Profile
    ####################################
    ####################################
    //* Data Genset
    ####################################

    public function tabel_genset()
    {
        // $data['list_data'] = $this->M_admin->select('tb_genset');
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Data Genset';
        $this->load->view('admin/form_genset/tabel_genset', $data);
    }

    public function ajax_list_gst()
    {
        header('Content-Type: application/json');
        $list_data = $this->M_admin->get_datatables_gst();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list_data as $d) {
            $no++;
            $row = array();
            //row pertama akan kita gunakan untuk btn edit dan delete
            // $row[] =  '<a class="btn btn-success btn-sm"><i class="fa fa-edit"></i> </a>
            // <a class="btn btn-danger btn-sm "><i class="fa fa-trash"></i> </a>';
            $row[] = $no;
            $row[] = $d->kode_genset;
            $row[] = $d->nama_genset;
            $row[] = $d->daya;
            $row[] = number_format($d->harga);
            $row[] = $d->stok_gd;
            $row[] = $d->stok_pj;
            $row[] = '<img src="' . base_url('assets/upload/genset/' . $d->gambar_genset) . '" width="100" height="100">';
            $row[] = '<a href="' . base_url('admin/update_genset/' . $d->id_genset) . '" type="button" class="btn btn-sm btn-info" name="btn_edit"><i class="fa fa-edit mr-2"></i></a>
            <a href="' . base_url('admin/hapus_data/' . $d->id_genset) . '" type="button" class="btn btn-sm btn-danger btn-delete" name="btn_delete"><i class="fa fa-trash mr-2"></i></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->M_admin->count_all_gst(),
            "recordsFiltered" => $this->M_admin->count_filtered_gst(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    public function tambah_genset()
    {
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Tambah Genset';
        $this->load->view('admin/form_genset/tambahgenset', $data);
    }

    public function proses_tambahgenset()
    {
        $this->form_validation->set_rules('kode_genset', 'Kode Genset', 'trim|required');
        $this->form_validation->set_rules('nama_genset', 'Nama Genset', 'trim|required');
        $this->form_validation->set_rules('daya', 'Daya', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_rules('stok_gd', 'Stok GUdang', 'trim|required');
        $this->form_validation->set_rules('stok_pj', 'Stok Pinjam', 'trim|required');

        if ($this->form_validation->run() == true) {
            $gambar_genset = $this->upload_gambargenset();

            $kode_genset = $this->input->post('kode_genset', true);
            $nama_genset = $this->input->post('nama_genset', true);
            $daya = $this->input->post('daya', true);
            $harga = $this->input->post('harga', true);
            $stok_gd = $this->input->post('stok_gd', true);
            $stok_pj = $this->input->post('stok_pj', true);

            $data = array(
                'kode_genset' => $kode_genset,
                'nama_genset' => $nama_genset,
                'daya' => $daya,
                'harga' => $harga,
                'stok_gd' => $stok_gd,
                'stok_pj' => $stok_pj,
                'gambar_genset' => $gambar_genset
            );

            $this->M_admin->insert('tb_genset', $data);
            $this->session->set_flashdata('msg_sukses', 'Data Genset Berhasil Disimpan');
            redirect(base_url('admin/tabel_genset'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Tambah Genset';
            $this->load->view('admin/form_genset/tambahgenset', $data);
        }
    }

    public function upload_gambargenset()
    {
        $config = array(
            'upload_path' => './assets/upload/genset/',
            'allowed_types' => 'gif|jpg|png',
            'ecrypt_name'    => false,
            'overwrite'    => true,
            // 'file_name'	=> uniqid(),
            'max_size' => 2048,
            'max_height' => 1080,
            'max_width' => 1920
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('gambar_genset')) {
            $error = $this->upload->display_errors();
            return $error;
            // die('gagal diupload');
        } else {
            $data_upload = array('upload_data' => $this->upload->data());
            $userfile = $data_upload['upload_data']['file_name'];

            return $userfile;
        }
    }

    public function update_genset()
    {
        $uri = $this->uri->segment(3);
        $where = array('id_genset' => $uri);
        $data['data_genset'] = $this->M_admin->get_data('tb_genset', $where);
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Update Genset';
        $this->load->view('admin/form_genset/updategenset', $data);
    }

    public function proses_updategenset()
    {
        $this->form_validation->set_rules('kode_genset', 'Kode Genset', 'trim|required');
        $this->form_validation->set_rules('nama_genset', 'Nama Genset', 'trim|required');
        $this->form_validation->set_rules('daya', 'Daya', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_rules('stok_gd', 'Stok GUdang', 'trim|required');
        $this->form_validation->set_rules('stok_pj', 'Stok Pinjam', 'trim|required');

        if ($this->form_validation->run() == true) {

            $id = $this->input->post('id_genset', true);
            $kode_genset = $this->input->post('kode_genset', true);
            $nama_genset = $this->input->post('nama_genset', true);
            $daya = $this->input->post('daya', true);
            $harga = $this->input->post('harga', true);
            $stok_gd = $this->input->post('stok_gd', true);
            $stok_pj = $this->input->post('stok_pj', true);
            $gambar_genset_old = $this->input->post('gambar_genset_old', true);

            $gambar_genset = $this->upload_gambargenset();

            if ($gambar_genset == '<p>You did not select a file to upload.</p>') {
                $gambar_genset_new = $gambar_genset_old;
            } else {
                $gambar_genset_new = $gambar_genset;
            }

            $where = array('id_genset' => $id);
            $data = array(
                'kode_genset' => $kode_genset,
                'nama_genset' => $nama_genset,
                'daya' => $daya,
                'harga' => $harga,
                'stok_gd' => $stok_gd,
                'stok_pj' => $stok_pj,
                'gambar_genset' => $gambar_genset_new
            );
            $this->M_admin->update('tb_genset', $data, $where);

            $this->session->set_flashdata('msg_sukses', 'Data Genset Berhasil Di Update');
            redirect(base_url('admin/tabel_genset'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Update Genset';
            $this->load->view('admin/form_genset/updategenset', $data);
        }
    }

    public function hapus_data()
    {
        $uri = $this->uri->segment(3);
        $where = array('id_genset' => $uri);
        // $data['gambar_genset'] = $this->M_admin->get_data_tb('tb_genset', $where);
        // unlink('assets/upload/genset/' . $where['gambar_genset']);
        $this->M_admin->delete('tb_genset', $where);
        redirect(base_url('admin/tabel_genset'));
    }
    ####################################
    //* End Data Genset 
    ####################################

    ####################################
    //* Data Perbaikan Genset 
    ####################################

    public function tabel_service_genset()
    {
        // $data['list_data'] = $this->M_admin->get_data_service('tb_serv_genset');
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Data Perbaikan Genset';
        $this->load->view('admin/form_service_genset/tabel_service_genset', $data);
    }

    public function ajax_list_serv()
    {
        header('Content-Type: application/json');
        $list_data = $this->M_admin->get_datatables_serv();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list_data as $d) {
            $no++;
            $row = array();
            //row pertama akan kita gunakan untuk btn edit dan delete
            $row[] = $no;
            $row[] = $d->kode_genset;
            $row[] = $d->nama_genset;
            $row[] = $d->jenis_perbaikan;
            $row[] = $d->nama_sparepart;
            $row[] = $d->tgl_perbaikan;
            $row[] = $d->nama;
            $row[] = $d->ket_perbaikan;
            $row[] = $d->biaya_perbaikan;
            // $row[] = '<a href="' . base_url('admin/update_data_pemakai/' . $d->id_pemakai) . '" id="id_pemakai" type="button" class="btn btn-sm btn-info" name="btn_edit"><i class="fa fa-edit mr-2"></i></a>
            // <button type="button" id="id_pemakai" data-id="' . $d->id_pemakai . '" class="btn btn-sm btn-danger btn-delete" name="btn_delete"><i class="fa fa-trash mr-2"></i></button>';

            $row[] = '<a href="' . base_url('admin/update_data_service_genset/' . $d->id_perbaikan_gst) . '" id="id_pemakai" type="button" class="btn btn-sm btn-info" name="btn_edit"><i class="fa fa-edit mr-2"></i></a>
            <a href="' . base_url('admin/hapus_service_genset/' . $d->id_perbaikan_gst) . '" type="button" class="btn btn-sm btn-danger btn-delete" name="btn_delete"><i class="fa fa-trash mr-2"></i></a>';
            // $row[] = $aksi;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->M_admin->count_all_serv(),
            "recordsFiltered" => $this->M_admin->count_filtered_serv(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    public function tambah_service_genset()
    {
        $data['list_genset'] = $this->M_admin->select('tb_genset');
        $data['list_sparepart'] = $this->M_admin->select('tb_sparepart');
        $data['list_pemakai'] = $this->M_admin->select('tb_pemakai');
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Tambah Perbaikan Genset';
        $this->load->view('admin/form_service_genset/tambah_service_genset', $data);
    }

    public function proses_tambah_service_genset()
    {
        $this->form_validation->set_rules('id_genset', 'Kode Genset', 'trim|required');
        $this->form_validation->set_rules('id_pemakai', 'Nama Pemakai', 'trim|required');
        // $this->form_validation->set_rules('nama_genset', 'Nama Genset', 'trim|required');
        $this->form_validation->set_rules('jenis_perbaikan', 'Jenis Perbaikan', 'trim|required');
        $this->form_validation->set_rules('tgl_perbaikan', 'Tanggal Perbaikan', 'trim|required');
        $this->form_validation->set_rules('ket_perbaikan', 'Keterangan Perbaikan', 'trim|required');
        $this->form_validation->set_rules('biaya_perbaikan', 'Biaya Perbaikan', 'trim|required');

        if ($this->form_validation->run() == true) {
            $stok = $this->input->post('stok', true);

            $kode_genset = $this->input->post('id_genset', true);
            $nama_pemakai = $this->input->post('id_pemakai', true);
            // $nama_genset = $this->input->post('nama_genset', true);
            $jenis_perbaikan = $this->input->post('jenis_perbaikan', true);
            $spare_part = $this->input->post('id_sparepart', true);
            $tgl_perbaikan = $this->input->post('tgl_perbaikan', true);
            $ket_perbaikan = $this->input->post('ket_perbaikan', true);
            $biaya_perbaikan = $this->input->post('biaya_perbaikan', true);

            $data = array(
                'id_genset' => $kode_genset,
                'id_pemakai' => $nama_pemakai,
                'jenis_perbaikan' => $jenis_perbaikan,
                'id_sparepart' => $spare_part,
                'tgl_perbaikan' => $tgl_perbaikan,
                'ket_perbaikan' => $ket_perbaikan,
                'biaya_perbaikan' => $biaya_perbaikan
            );
            $stok_new = (int)$stok - 1;

            $this->M_admin->mengurangi_stok('tb_sparepart', $spare_part, $stok_new);
            $this->M_admin->insert('tb_serv_genset', $data);
            $this->session->set_flashdata('msg_sukses', 'Data Berhasil Di Tambah');
            redirect(base_url('admin/tabel_service_genset'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Tambah Perbaikan Genset';
            $this->load->view('admin/form_service_genset/tambah_service_genset', $data);
        }
    }

    public function update_data_service_genset()
    {
        $data['list_genset'] = $this->M_admin->select('tb_genset');
        $data['list_sparepart'] = $this->M_admin->select('tb_sparepart');
        $data['list_pemakai'] = $this->M_admin->select('tb_pemakai');
        $uri = $this->uri->segment(3);
        $where = array('id_perbaikan_gst' => $uri);
        $data['list_data'] = $this->M_admin->get_data('tb_serv_genset', $where);
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Update Perbaikan Genset';
        $this->load->view('admin/form_service_genset/update_service_genset', $data);
    }

    public function proses_update_service_genset()
    {
        // $this->form_validation->set_rules('id_genset', 'Kode Genset', 'trim|required');
        // $this->form_validation->set_rules('nama_genset', 'Nama Genset', 'trim|required');
        $this->form_validation->set_rules('jenis_perbaikan', 'Jenis Perbaikan', 'trim|required');
        $this->form_validation->set_rules('tgl_perbaikan', 'Tanggal Perbaikan', 'trim|required');
        $this->form_validation->set_rules('ket_perbaikan', 'Keterangan Perbaikan', 'trim|required');
        $this->form_validation->set_rules('biaya_perbaikan', 'Biaya Perbaikan', 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $stok = $this->input->post('stok', true);

            $id = $this->input->post('id_perbaikan_gst', TRUE);
            $kode_genset = $this->input->post('id_genset', TRUE);
            $nama_pemakai = $this->input->post('id_pemakai', true);
            // $nama_genset = $this->input->post('nama_genset', TRUE);
            $jenis_perbaikan = $this->input->post('jenis_perbaikan', TRUE);
            $spare_part = $this->input->post('id_sparepart', TRUE);
            $tgl_perbaikan = $this->input->post('tgl_perbaikan', TRUE);
            $ket_perbaikan = $this->input->post('ket_perbaikan', TRUE);
            $biaya_perbaikan = $this->input->post('biaya_perbaikan', TRUE);

            $where = array('id_perbaikan_gst' => $id);
            $data = array(
                'id_genset' => $kode_genset,
                'id_pemakai' => $nama_pemakai,
                // 'nama_genset' => $nama_genset,
                'jenis_perbaikan' => $jenis_perbaikan,
                'id_sparepart' => $spare_part,
                'tgl_perbaikan' => $tgl_perbaikan,
                'ket_perbaikan' => $ket_perbaikan,
                'biaya_perbaikan' => $biaya_perbaikan,
            );
            $stok_new = (int)$stok - 1;

            $this->M_admin->mengurangi_stok('tb_sparepart', $spare_part, $stok_new);
            $this->M_admin->update('tb_serv_genset', $data, $where);
            $this->session->set_flashdata('msg_sukses', 'Data Berhasil Di Update');
            redirect(base_url('admin/tabel_service_genset'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Update Perbaikan Genset';
            $this->load->view('admin/form_service_genset/update_service_genset', $data);
        }
    }

    public function hapus_service_genset()
    {
        $uri = $this->uri->segment(3);
        $where = array('id_perbaikan_gst' => $uri);
        $this->M_admin->delete('tb_serv_genset', $where);
        $this->session->set_flashdata('msg_sukses', 'Data Berhasil Dihapus');
        redirect(base_url('admin/tabel_service_genset'));
    }

    ####################################
    //* End Data Perbaikan Genset 
    ####################################

    ####################################
    //* Data Sparepart 
    ####################################

    public function tabel_sparepart()
    {
        // $where = array('stok');
        $data['count'] = $this->M_admin->notif_stok('tb_sparepart');
        $data['num'] = $this->M_admin->notif_stok_jml('tb_sparepart');

        $data['list_sparepart'] = $this->M_admin->select('tb_sparepart');
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Data Sparepart';
        $this->load->view('admin/form_sparepart/tabel_sparepart', $data);
    }

    public function tambah_data_sparepart()
    {
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Tambah Stok Sparepart';
        $this->load->view('admin/form_sparepart/tambah_sparepart', $data);
    }

    public function proses_tambah_sparepart()
    {
        $this->form_validation->set_rules('nama_sparepart', 'Nama Sparepart', 'trim|required');
        $this->form_validation->set_rules('tanggal_beli', 'Tanggal Beli', 'trim|required');
        $this->form_validation->set_rules('tempat_beli', 'Tempat Beli', 'trim|required');
        $this->form_validation->set_rules('stok', 'Stok', 'trim|required');

        if ($this->form_validation->run() === true) {

            $nama_sparepart = $this->input->post('nama_sparepart', true);
            $tanggal_beli = $this->input->post('tanggal_beli', true);
            $tempat_beli = $this->input->post('tempat_beli', true);
            $stok = $this->input->post('stok', true);

            // $tanggal_beli = date('Y-m-d', strtotime($tanggal_beli));
            $data = array(
                'nama_sparepart' => $nama_sparepart,
                'tanggal_beli' => $tanggal_beli,
                'tempat_beli' => $tempat_beli,
                'stok' => $stok
            );
            $this->M_admin->insert('tb_sparepart', $data);
            $this->session->set_flashdata('msg_sukses', 'Data Sparepart Berhasil Ditambah');
            redirect(base_url('admin/tabel_sparepart'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Tambah Stok Sparepart';
            $this->load->view('admin/form_sparepart/tambah_sparepart', $data);
        }
    }

    public function update_sparepart()
    {
        $uri = $this->uri->segment(3);
        $where = array('id_sparepart' => $uri);
        $data['data_sparepart'] = $this->M_admin->get_data('tb_sparepart', $where);
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Edit Stok Sparepart';
        $this->load->view('admin/form_sparepart/update_sparepart', $data);
    }

    public function proses_update_sparepart()
    {
        $this->form_validation->set_rules('nama_sparepart', 'Nama Sparepart', 'trim|required');
        $this->form_validation->set_rules('tanggal_beli', 'Tanggal Beli', 'trim|required');
        $this->form_validation->set_rules('tempat_beli', 'Tempat Beli', 'trim|required');
        $this->form_validation->set_rules('stok', 'Stok', 'trim|required');
        if ($this->form_validation->run() === true) {

            $id = $this->input->post('id', true);
            $nama_sparepart = $this->input->post('nama_sparepart', true);
            $tanggal_beli = $this->input->post('tanggal_beli', true);
            $tempat_beli = $this->input->post('tempat_beli', true);
            $stok = $this->input->post('stok', true);

            // $tanggal_beli = date('Y-m-d', strtotime($tanggal_beli));
            $where = array('id_sparepart' => $id);
            $data = array(
                'nama_sparepart' => $nama_sparepart,
                'tanggal_beli' => $tanggal_beli,
                'tempat_beli' => $tempat_beli,
                'stok' => $stok
            );
            $this->M_admin->update('tb_sparepart', $data, $where);
            $this->session->set_flashdata('msg_sukses', 'Data Sparepart Berhasil Diupdate');
            redirect(base_url('admin/tabel_sparepart'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Edit Stok Sparepart';
            $this->load->view('admin/form_sparepart/update_sparepart', $data);
        }
    }

    public function hapus_sparepart()
    {
        $uri = $this->uri->segment(3);
        $where = array('id_sparepart' => $uri);
        $this->M_admin->delete('tb_sparepart', $where);
        $this->session->set_flashdata('msg_sukses', 'Data Berhasil Dihapus');
        redirect(base_url('admin/tabel_sparepart'));
    }

    ####################################
    //* End Data Sparepart 
    ####################################

    ####################################
    //* Data Pemakai 
    ####################################

    public function tabel_pemakai()
    {
        // $where = array('id_pemakai');
        $data['list_pemakai'] = $this->M_admin->select('tb_pemakai');
        // $data['edit_data'] = $this->M_admin->get_data('tb_pemakai', $where);

        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Data Pemakai';
        $this->load->view('admin/form_pemakai/tabel_pemakai', $data);
    }

    // public function ajax_list_pakai()
    // {
    //     header('Content-Type: application/json');
    //     $list_data = $this->M_admin->get_datatables_pakai();
    //     $edit_data = $this->M_admin->get_data('tb_pemakai');
    //     $data = array();
    //     $no = $this->input->post('start');
    //     //looping data mahasiswa
    //     foreach ($list_data as $d) {
    //         $no++;
    //         $row = array();
    //         //row pertama akan kita gunakan untuk btn edit dan delete
    //         $row[] = $no;
    //         $row[] = $d->nama;
    //         $row[] = $d->alamat;
    //         $row[] = $d->no_hp;
    //         $row[] = $d->tgl_update;
    //         // $row[] = '<a href="' . base_url('admin/update_data_pemakai/' . $d->id_pemakai) . '" id="id_pemakai" type="button" class="btn btn-sm btn-info" name="btn_edit"><i class="fa fa-edit mr-2"></i></a>
    //         // <button type="button" id="id_pemakai" data-id="' . $d->id_pemakai . '" class="btn btn-sm btn-danger btn-delete" name="btn_delete"><i class="fa fa-trash mr-2"></i></button>';

    //         $row[] = '
    //         <button data-toggle="modal" data-target="#staticEditPemakai" class="btn btn-info btn-sm"><i class="fa fa-plus mr-2" aria-hidden="true"></i>Tambah Data</button>
    //         <a href="' . base_url('admin/hapus_pemakai/' . $d->id_pemakai) . '" type="button" class="btn btn-sm btn-danger btn-delete" name="btn_delete"><i class="fa fa-trash mr-2"></i></a>';
    //         // $row[] = $aksi;
    //         $data[] = $row;
    //     }
    //     $output = array(
    //         "draw" => $this->input->post('draw'),
    //         "recordsTotal" => $this->M_admin->count_all_pakai(),
    //         "recordsFiltered" => $this->M_admin->count_filtered_pakai(),
    //         "data" => $data,
    //     );
    //     //output to json format
    //     $this->output->set_output(json_encode($output));
    // }

    public function tambah_data_pemakai()
    {
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Tambah Data Pemakai';
        $this->load->view('admin/form_pemakai/tambah_pemakai', $data);
    }

    public function update_data_pemakai()
    {
        $uri = $this->uri->segment(3);
        $where = array('id_pemakai' => $uri);
        $data['list_data'] = $this->M_admin->get_data('tb_pemakai', $where);
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Update Data Pemakai';
        $this->load->view('admin/form_pemakai/edit_pemakai', $data);
    }

    public function proses_tambah_pemakai()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_hp', 'No Hp', 'trim|required');
        $this->form_validation->set_rules('tgl_update', 'Tanggal Update', 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $nama = $this->input->post('nama', TRUE);
            $alamat = $this->input->post('alamat', TRUE);
            $no_hp = $this->input->post('no_hp', TRUE);
            $tgl_update = $this->input->post('tgl_update', TRUE);

            $data = array(
                'nama' => $nama,
                'alamat' => $alamat,
                'no_hp' => $no_hp,
                'tgl_update' => $tgl_update
            );
            $this->M_admin->insert('tb_pemakai', $data);
            $this->session->set_flashdata('msg_sukses', 'Data Berhasil Di Tambahkan');
            redirect(base_url('admin/tabel_pemakai'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Tambah Data Pemakai';
            $this->load->view('admin/form_pemakai/tambah_pemakai');
        }
    }

    public function proses_update_pemakai()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_hp', 'No Hp', 'trim|required');
        $this->form_validation->set_rules('tgl_update', 'Tanggal Update', 'trim|required');

        if ($this->form_validation->run() === TRUE) {
            $id = $this->input->post('id', TRUE);
            $nama = $this->input->post('nama', TRUE);
            $alamat = $this->input->post('alamat', TRUE);
            $no_hp = $this->input->post('no_hp', TRUE);
            $tgl_update = $this->input->post('tgl_update', TRUE);

            $where = array('id_pemakai' => $id);
            $data = array(
                'nama' => $nama,
                'alamat' => $alamat,
                'no_hp' => $no_hp,
                'tgl_update' => $tgl_update
            );
            $this->M_admin->update('tb_pemakai', $data, $where);
            $this->session->set_flashdata('msg_sukses', 'Data Berhasil Di Update');
            redirect(base_url('admin/tabel_pemakai'));
        } else {
            $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
            $data['title'] = 'Update Data Pemakai';
            $this->load->view('admin/form_pemakai/update_pemakai');
        }
    }

    // public function hapus_pemakai()
    // {
    //     $id = $this->input->post('id_pemakai');
    //     $where = array('id_pemakai' => $id);
    //     $data = $this->M_admin->delete('tb_pemakai', $where);
    //     $this->session->set_flashdata('msg_sukses', 'Data Berhasil Di Hapus');
    //     echo json_encode($data);
    //     redirect(base_url('admin/tabel_pemakai'));
    // }
    public function hapus_pemakai()
    {
        $uri = $this->uri->segment(3);
        $where = array('id_pemakai' => $uri);
        $data = $this->M_admin->delete('tb_pemakai', $where);
        $this->session->set_flashdata('msg_sukses', 'Data Berhasil Di Hapus');
        echo json_encode($data);
        redirect(base_url('admin/tabel_pemakai'));
    }

    public function cetak_pakai()
    {
        $tgl_awal = $this->input->post('tgl_awal'); // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)        
        $tgl_akhir = $this->input->post('tgl_akhir'); // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)        
        // if (empty($tgl_awal) or empty($tgl_akhir)) { // Cek jika tgl_awal atau tgl_akhir kosong, maka :            
        //     $transaksi = $this->TransaksiModel->view_all();  // Panggil fungsi view_all yang ada di TransaksiModel            
        //     $label = 'Semua Data Transaksi';
        // } else { // Jika terisi            
        // Panggil fungsi view_by_date yang ada di TransaksiModel            
        // $tgl_awal = date('d-m-Y', strtotime($tgl_awal)); // Ubah format tanggal jadi dd-mm-yyyy           
        // $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir)); // Ubah format tanggal jadi dd-mm-yyyy            
        $label = 'Periode Tanggal ' . date('d-m-Y', strtotime($tgl_awal)) . ' s/d ' .  date('d-m-Y', strtotime($tgl_akhir));
        // }
        $data['label'] = $label;
        $data['pakai'] = $this->M_admin->pakai_periode($tgl_awal, $tgl_akhir);
        // ob_start();
        // $data = $this->M_admin->pakai_periode($tgl_awal, $tgl_akhir);

        $this->load->view('admin/report/rep_pakai', $data);
        // $html = ob_get_contents();
        // ob_end_clean();
        // require './vendor/autoload.php'; // Load plugin html2pdfnya    
        // $pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en', array(15, 15, 15, 15), false);  // Settingan PDFnya   
        // $pdf->WriteHTML($html);
        // $pdf->Output('Data Transaksi.pdf', 'D');
    }
    ####################################
    // End Data pemakai 
    ####################################

    public function report()
    {
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'Report';
        $this->load->view('admin/report/laporan', $data);
    }

    ####################################
    // test email 
    ####################################

    public function email()
    {
        $data['list_email'] = $this->M_admin->select('tb_user');
        $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        $data['title'] = 'email';
        $this->load->view('admin/email/v_email', $data);
    }

    public function kirim()
    {
        $email_penerima = $this->input->post('email_penerima');
        $subjek = $this->input->post('subjek');
        $pesan = $this->input->post('pesan');
        $attachment = $_FILES['attachment'];
        $content = $this->load->view('admin/email/content', array('pesan' => $pesan), true); // Ambil isi file content.php dan masukan ke variabel $content
        $sendmail = array(
            'email_penerima' => $email_penerima,
            'subjek' => $subjek,
            'content' => $content,
            'attachment' => $attachment
        );
        if (empty($attachment['name'])) {
            $send = $this->mailer->send($sendmail);
        } else {
            $send = $this->mailer->send_with_attachment($sendmail);
        }

        echo "<b>" . $send['status'] . "</b><br />";
        echo $send['message'];

        // $data['avatar'] = $this->M_admin->get_data_avatar('tb_avatar', $this->session->userdata('name'));
        // $data['title'] = 'email';
        // $this->load->view('admin/email/v_email', $data);

        // redirect(base_url('admin/email'));
        echo "<br /><a href='" . base_url("admin/email") . "'>Kembali ke Form</a>";
    }

    public function send()
    {

        $email_penerima = $this->input->post('email_penerima');
        $subjek = $this->input->post('subjek');
        $pesan = $this->input->post('pesan');
        $attachment = $_FILES['attachment'];
        $content = $this->load->view('admin/email/content', array('pesan' => $pesan), true); // Ambil isi file content.php dan masukan ke variabel $content
        $sendmail = array(
            'email_penerima' => $email_penerima,
            'subjek' => $subjek,
            'content' => $content,
            'attachment' => $attachment
        );

        if (empty($attachment['name'])) { // Jika tanpa attachment
            $send = $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
        } else { // Jika dengan attachment
            $send = $this->mailer->send_with_attachment($sendmail); // Panggil fungsi send_with_attachment yang ada di librari Mailer
        }

        echo "<b>" . $send['status'] . "</b><br />";
        echo $send['message'];
        echo "<br /><a href='" . base_url("admin/email") . "'>Kembali ke Form</a>";
    }
}
