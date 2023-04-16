<?php

class M_admin extends CI_Model
{

    ####################################
    //* Data Genset
    ####################################
    //set nama tabel yang akan kita tampilkan datanya
    var $tablegst = 'tb_genset';
    //set kolom order, kolom pertama saya null untuk kolom edit dan hapus
    var $column_order = array('kode_genset', 'nama_genset', 'daya', 'harga', 'stok_gd', 'stok_pj', 'gambar_genset', null);

    var $column_search = array('kode_genset', 'nama_genset', 'daya');
    // default order 
    var $order = array('id_genset ' => 'asc');

    private function _get_datatables_query()
    {
        $this->db->from($this->tablegst);
        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
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
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->tablegst);
        return $this->db->count_all_results();
    }

    ####################################
    //* Data Genset
    ####################################

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

    public function update_password($tabel, $where, $data)
    {
        $this->db->where($where);
        $this->db->update($tabel, $data);
    }

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

    public function update_avatar($where, $data)
    {
        $this->db->set($data);
        $this->db->where($where);
        $this->db->update('tb_avatar');
    }


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
