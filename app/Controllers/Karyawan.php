<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Karyawan extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['form']);

        // kalau ada auth
        // is_logged_in();
    }

    public function index()
    {
        $validation = \Config\Services::validation();
        $session = session();

        // ================= USER LOGIN =================
        $data['user'] = $this->db->table('user')
            ->where('username', $session->get('username'))
            ->get()->getRowArray();

        if (!$data['user']) {
            return redirect()->to('/login');
        }

        $role_id = $data['user']['role_id'];

        // ================= MENU =================
        $data['menus'] = $this->db->table('user_menu m')
            ->join('user_access_menu am', 'am.menu_id = m.id')
            ->where('am.role_id', $role_id)
            ->orderBy('m.id', 'ASC')
            ->get()->getResultArray();

        $data['submenus'] = $this->db->table('user_sub_menu')->get()->getResultArray();
        $data['openMenu'] = '';

        // ================= DATA =================
        $data['title'] = 'Karyawan';
        $data['validation'] = $validation;
        $data['users'] = $this->db->table('user')->get()->getResultArray();
        $data['userRole'] = $this->db->table('user_role')->get()->getResultArray();

        // ================= INSERT =================
        if ($this->request->getMethod(true) === 'POST') {

            if (!$this->validate([
                'nama' => 'required',
                'jabatan' => 'required',
                'nip' => 'required',
            ])) {

                return view('templates/header', $data)
                    . view('templates/sidebar', $data)
                    . view('templates/topbar', $data)
                    . view('karyawan/index', $data)
                    . view('templates/footer');
            }

            $this->db->table('user')->insert([
                'name' => $this->request->getPost('nama'),
                'ditemui' => 1,
                'jabatan' => $this->request->getPost('jabatan'),
                'nip' => $this->request->getPost('nip'),
                'image' => 'default.jpg',
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ]);

            return redirect()->to('/administrator/users')
                ->with('message', 'Data karyawan berhasil ditambahkan');
        }

        // ================= VIEW =================
        return view('templates/header', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('karyawan/index', $data)
            . view('templates/footer');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $validation = \Config\Services::validation();
        $session = session();

        // ================= USER =================
        $data['user'] = $this->db->table('user')
            ->where('username', $session->get('username'))
            ->get()->getRowArray();

        if (!$data['user']) {
            return redirect()->to('/login');
        }

        $role_id = $data['user']['role_id'];

        // ================= MENU =================
        $data['menus'] = $this->db->table('user_menu m')
            ->join('user_access_menu am', 'am.menu_id = m.id')
            ->where('am.role_id', $role_id)
            ->get()->getResultArray();

        $data['submenus'] = $this->db->table('user_sub_menu')->get()->getResultArray();
        $data['openMenu'] = '';

        // ================= DATA =================
        $data['title'] = 'Edit Karyawan';
        $data['validation'] = $validation;

        // ================= GET =================
        if ($this->request->getMethod(true) === 'GET') {

            $data['karyawan'] = $this->db->table('user')->where('id', $id)->get()->getRowArray();
            $data['users'] = $this->db->table('user')->get()->getResultArray();
            $data['userRole'] = $this->db->table('user_role')->get()->getResultArray();

            return view('templates/header', $data)
                . view('templates/sidebar', $data)
                . view('templates/topbar', $data)
                . view('karyawan/edit', $data)
                . view('templates/footer');
        }

        // ================= POST =================
        if (!$this->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'nip' => 'required',
        ])) {
            return redirect()->back()->withInput();
        }

        $this->db->table('user')->where('id', $id)->update([
            'name' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'nip' => $this->request->getPost('nip'),
        ]);

        return redirect()->to('/administrator/users')
            ->with('message', 'Data karyawan berhasil diupdate');
    }

    // ================= HAPUS =================
    public function hapusKaryawan($id)
    {
        $this->db->table('user')->delete(['id' => $id]);

        return redirect()->to('/administrator/users')
            ->with('message', 'Data karyawan berhasil dihapus');
    }
}