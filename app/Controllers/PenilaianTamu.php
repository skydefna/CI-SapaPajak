<?php

class PenilaianTamu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
    }

    public function nilai($id)
    {
        $data['title'] = 'Penilaian Tamu';
        $data['tamu'] = $this->db->get_where('tamu', ['id' => $id])->row_array();

        $this->load->view('penilaianTamu/index', $data);
    }
}