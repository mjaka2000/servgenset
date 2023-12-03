<?php

class M_admin extends CI_Model
{

    ####################################
    //* Data Genset
    ####################################
    //set nama tabel yang akan kita tampilkan datanya
    var $tablegst = 'tb_genset';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order_gst = array('kode_genset', 'nama_genset', 'daya', 'harga', 'stok_gd', 'stok_pj', 'gambar_genset', null);

    var $column_search_gst = array('kode_genset', 'nama_genset', 'daya');
    // default order 
    var $order_gst = array('id_genset ' => 'asc');

    private function _get_datatables_query_gst()
    {
        $this->db->from($this->tablegst);
        $i = 0;
        foreach ($this->column_search_gst as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search_gst) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order_gst[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order_gst)) {
            $ordergst = $this->order_gst;
            $this->db->order_by(key($ordergst), $ordergst[key($ordergst)]);
        }
    }

    function get_datatables_gst()
    {
        $this->_get_datatables_query_gst();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_gst()
    {
        $this->_get_datatables_query_gst();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_gst()
    {
        $this->db->from($this->tablegst);
        return $this->db->count_all_results();
    }

    ####################################
    //* Data Genset
    ####################################

    ####################################
    //* Data Pakai
    ####################################
    //set nama tabel yang akan kita tampilkan datanya
    var $tablepakai = 'tb_pemakai';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order_pakai = array('nama', 'alamat', 'no_hp', 'tgl_update', null);

    var $column_search_pakai = array('nama', 'alamat', 'no_hp');
    // default order 
    var $order_pakai = array('id_pemakai' => 'asc');

    private function _get_datatables_query_pakai()
    {
        $this->db->from($this->tablepakai);
        $i = 0;
        foreach ($this->column_search_pakai as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search_pakai) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order_pakai[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order_pakai)) {
            $orderpakai = $this->order_pakai;
            $this->db->order_by(key($orderpakai), $orderpakai[key($orderpakai)]);
        }
    }

    function get_datatables_pakai()
    {
        $this->_get_datatables_query_pakai();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_pakai()
    {
        $this->_get_datatables_query_pakai();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_pakai()
    {
        $this->db->from($this->tablepakai);
        return $this->db->count_all_results();
    }

    ####################################
    //* Data Pakai
    ####################################

    ####################################
    //* Data Perbaikan
    ####################################
    //set nama tabel yang akan kita tampilkan datanya
    var $tableserv = 'tb_serv_genset';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order_serv = array('kode_genset', 'nama_genset', 'jenis_perbaikan', 'nama_sparepart', 'tgl_perbaikan', 'nama', 'ket_perbaikan', 'biaya_perbaikan', null);

    var $column_search_serv = array('kode_genset', 'nama_genset', 'jenis_perbaikan', 'nama_sparepart', 'nama');
    // default order 
    var $order_serv = array('id_perbaikan_gst' => 'asc');

    private function _get_datatables_query_serv()
    {
        $this->db->from($this->tableserv)
            ->join('tb_genset', 'tb_genset.id_genset = tb_serv_genset.id_genset')
            ->join('tb_sparepart', 'tb_sparepart.id_sparepart = tb_serv_genset.id_sparepart')
            ->join('tb_pemakai', 'tb_pemakai.id_pemakai = tb_serv_genset.id_pemakai');
        $i = 0;
        foreach ($this->column_search_serv as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search_serv) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order_serv[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order_serv)) {
            $orderserv = $this->order_serv;
            $this->db->order_by(key($orderserv), $orderserv[key($orderserv)]);
        }
    }

    function get_datatables_serv()
    {
        $this->_get_datatables_query_serv();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_serv()
    {
        $this->_get_datatables_query_serv();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_serv()
    {
        $this->db->from($this->tablepakai);
        return $this->db->count_all_results();
    }
    ####################################
    // CRUD
    ####################################

    public function insert($tabel, $data)
    {
        $this->db->insert($tabel, $data);
    }

    public function select($tabel)
    {
        $query = $this->db->get($tabel);
        return $query->result();
    }

    public function update($tabel, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($tabel, $data);
    }

    public function delete($tabel, $where)
    {
        $this->db->where($where);
        $this->db->delete($tabel);
    }

    ####################################
    //! Batas Query User (Jangan diubah)
    ####################################

    public function get_avatar($tabel, $username) // Query get avatar User
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('username', $username)
            ->get();
        return $query->result();
    }

    public function update_avatar($where, $data) // Query update Avatar User
    {
        $this->db->set($data);
        $this->db->where($where);
        $this->db->update('tb_user');
    }

    public function update_password($tabel, $where, $data) // Update password user
    {
        $this->db->where($where);
        $this->db->update($tabel, $data);
    }

    ####################################
    //! End Batas Query User (Jangan diubah)
    ####################################
    ####################################
    //! Old Query 
    ####################################

    public function cek_jumlah($tabel, $id_transaksi)
    {
        return  $this->db->select('*')
            ->from($tabel)
            ->where('id_transaksi', $id_transaksi)
            ->get();
    }

    public function get_data_array($tabel, $id_transaksi)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where($id_transaksi)
            ->get();
        return $query->result_array();
    }

    public function get_data($tabel, $id_transaksi)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where($id_transaksi)
            ->get();
        return $query->result();
    }



    public function mengurangi($tabel, $kode_genset, $stok_gd_new)
    {
        $this->db->set("stok_gd", $stok_gd_new);
        $this->db->where('kode_genset', $kode_genset);
        $this->db->update($tabel);
    }

    public function mengurangi_kembali($tabel, $kode_genset, $stok_pj_new)
    {
        $this->db->set("stok_pj", $stok_pj_new);
        $this->db->where('kode_genset', $kode_genset);
        $this->db->update($tabel);
    }

    public function menambah($tabel, $kode_genset, $stok_pj_new)
    {
        $this->db->set("stok_pj", $stok_pj_new);
        $this->db->where('kode_genset', $kode_genset);
        $this->db->update($tabel);
    }

    public function menambah_kembali($tabel, $kode_genset, $stok_gd_new)
    {
        $this->db->set("stok_gd", $stok_gd_new);
        $this->db->where('kode_genset', $kode_genset);
        $this->db->update($tabel);
    }

    public function update_status($tabel, $where, $status)
    {
        $this->db->set("status", $status);
        $this->db->where("id_transaksi", $where);
        $this->db->update($tabel);
    }
    public function update_status_aju($tabel, $where, $status_a)
    {
        $this->db->set("status_ajuan", $status_a);
        $this->db->where("id_transaksi", $where);
        $this->db->update($tabel);
    }

    // public function update_password($tabel, $where, $data)
    // {
    //     $this->db->where($where);
    //     $this->db->update($tabel, $data);
    // }

    public function get_data_gambar($tabel, $username)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('username_user', $username)
            ->get();
        return $query->result();
    }

    public function update_gambar($where, $data)
    {
        $this->db->set($data);
        $this->db->where($where);
        $this->db->update('tb_upload_gambar_user');
    }

    public function sum($tabel, $field)
    {
        $query = $this->db->select_sum($field)
            ->from($tabel)
            ->get();
        return $query->result();
    }

    public function numrows($tabel)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->get();
        return $query->num_rows();
    }

    public function numrows_where($tabel, $where)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where($where)
            ->get();
        return $query->num_rows();
    }

    public function kecuali($tabel, $username)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where_not_in('username', $username)
            ->get();

        return $query->result();
    }

    ####################################
    //* New Query
    ####################################

    // public function get_data_avatar($tabel, $idusername)
    // {
    //   $query = $this->db->select('tb_avatar.*, tb_user.id AS id_user')
    //     ->join('tb_user', 'tb_avatar.id_user = tb_user.id')
    //     ->from('tb_avatar')
    //     ->get();
    //   return $query->result();
    // }
    public function get_data_avatar($tabel, $username)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('username_user', $username)
            ->get();
        return $query->result();
    }

    // public function update_avatar($where, $data)
    // {
    //     $this->db->set($data);
    //     $this->db->where($where);
    //     $this->db->update('tb_avatar');
    // }


    public function notif_stok($tabel)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('stok <', 2)
            ->get();
        return $query->result();
    }
    public function notif_stok_jml($tabel)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->where('stok <', 2)
            ->get();
        return $query->num_rows();
    }

    public function pakai_periode($tgl_awal, $tgl_akhir)
    {
        // 
        $tgl_awal = $this->db->escape($tgl_awal);
        $tgl_akhir = $this->db->escape($tgl_akhir);
        $query = $this->db->select()
            ->from('tb_pemakai')
            ->where('DATE (tgl_update) BETWEEN ' . $tgl_awal . ' AND ' . $tgl_akhir)
            ->order_by('tgl_update', 'asc')
            ->get();
        return $query->result();
    }
    ####################################
    //* Data Perbaikan Genset 
    ####################################

    public function get_data_service($tabel)
    {
        $query = $this->db->select()
            ->from($tabel)
            ->join('tb_genset', 'tb_genset.id_genset = tb_serv_genset.id_genset')
            ->join('tb_sparepart', 'tb_sparepart.id_sparepart = tb_serv_genset.id_sparepart')
            ->join('tb_pemakai', 'tb_pemakai.id_pemakai = tb_serv_genset.id_pemakai')
            ->get();
        return $query->result();
    }

    // public function numrows_where_service($tabel, $where)
    // {
    //   $query = $this->db->select()
    //     ->from($tabel)
    //     ->join('tb_genset', ' tb_genset.id = tb_serv_genset.id_genset')
    //     ->join('tb_sparepart', 'tb_sparepart.id = tb_serv_genset.id_sparepart')
    //     ->where($where)
    //     ->get();
    //   return $query->num_rows();
    // }

    // public function get_service_tb($tabel, $where)
    // {
    //   $query = $this->db->select('*')
    //     ->from($tabel)
    //     ->join('tb_genset', 'tb_genset.id = tb_serv_genset.id_genset')
    //     ->join('tb_sparepart', 'tb_sparepart.id = tb_serv_genset.id_sparepart')
    //     ->where($where)
    //     ->get();
    //   return $query->result();
    // }

    public function mengurangi_stok($tabel, $spare_part, $stok_new)
    {
        $this->db->set("stok", $stok_new);
        $this->db->where('id_sparepart', $spare_part);
        $this->db->update($tabel);
    }
    ####################################
    //* End Data Perbaikan Genset 
    ####################################
}
