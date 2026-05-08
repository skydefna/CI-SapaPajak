<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Menu extends Controller
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();

        // pengganti is_logged_in()
        if (!$this->session->get('email')) {
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        helper(['form', 'url']);

        $data['title'] = 'Menu';

        $data['user'] = $this->db->table('user')
            ->getWhere(['email' => $this->session->get('email')])
            ->getRowArray();

        $data['menu'] = $this->db->table('user_menu')
            ->get()
            ->getResultArray();

        if (!$this->validate([
            'name' => 'required',
            'menu' => 'required'
        ])) {

            return view('templates/header', $data)
                . view('templates/topbar', $data)
                . view('templates/sidebar', $data)
                . view('menu/index', $data)
                . view('templates/footer');

        } else {

            $this->db->table('user_menu')->insert([
                'menu' => ucfirst($this->request->getPost('menu')),
                'icon' => $this->request->getPost('icon'),
                'name' => $this->request->getPost('name'),
            ]);

            session()->setFlashdata('message', 'Menu berhasil ditambahkan');
            return redirect()->to('/menu');
        }
    }

    public function delete($id)
    {
        $this->db->table('user_menu')->delete(['id' => $id]);
        $this->db->table('user_sub_menu')->delete(['menu_id' => $id]);

        session()->setFlashdata('message', 'Menu berhasil dihapus');
        return redirect()->to('/menu');
    }

    public function edit($id)
    {
        helper(['form']);

        $data['title'] = 'Edit Menu';

        $data['user'] = $this->db->table('user')
            ->getWhere(['email' => $this->session->get('email')])
            ->getRowArray();

        $data['menu'] = $this->db->table('user_menu')
            ->getWhere(['id' => $id])
            ->getRowArray();

        if (!$this->validate([
            'menu' => 'required',
            'icon' => 'required',
            'name' => 'required'
        ])) {

            return view('templates/header', $data)
                . view('templates/topbar', $data)
                . view('templates/sidebar', $data)
                . view('menu/menu-edit', $data)
                . view('templates/footer');

        } else {

            $this->db->table('user_menu')
                ->where('id', $id)
                ->update([
                    'menu' => $this->request->getPost('menu'),
                    'icon' => $this->request->getPost('icon'),
                    'name' => $this->request->getPost('name'),
                ]);

            session()->setFlashdata('message', 'Menu berhasil diupdate');
            return redirect()->to('/menu');
        }
    }

    public function submenu()
    {
        helper(['form']);

        $data['title'] = 'Submenu';

        $data['user'] = $this->db->table('user')
            ->getWhere(['email' => $this->session->get('email')])
            ->getRowArray();

        $data['subMenu'] = $this->db->table('user_sub_menu')->get()->getResultArray();
        $data['menu'] = $this->db->table('user_menu')->get()->getResultArray();

        if (!$this->validate([
            'title' => 'required',
            'menu_id' => 'required',
            'url' => 'required'
        ])) {

            return view('templates/header', $data)
                . view('templates/topbar', $data)
                . view('templates/sidebar', $data)
                . view('menu/submenu', $data)
                . view('templates/footer');

        } else {

            $this->db->table('user_sub_menu')->insert([
                'title' => $this->request->getPost('title'),
                'menu_id' => $this->request->getPost('menu_id'),
                'url' => $this->request->getPost('url'),
                'icons' => 'mdi mdi-flower',
                'is_active' => $this->request->getPost('is_active')
            ]);

            session()->setFlashdata('message', 'Submenu berhasil ditambahkan');
            return redirect()->to('/menu/submenu');
        }
    }

    public function subMenuDelete($id)
    {
        $this->db->table('user_sub_menu')->delete(['id' => $id]);

        session()->setFlashdata('message', 'Submenu berhasil dihapus');
        return redirect()->to('/menu/submenu');
    }

    public function subMenuEdit($id)
    {
        helper(['form']);

        $data['title'] = 'Edit Submenu';

        $data['user'] = $this->db->table('user')
            ->getWhere(['email' => $this->session->get('email')])
            ->getRowArray();

        $data['menu'] = $this->db->table('user_menu')->get()->getResultArray();

        $data['subMenu'] = $this->db->table('user_sub_menu')
            ->getWhere(['id' => $id])
            ->getRowArray();

        if (!$this->validate([
            'title' => 'required'
        ])) {

            return view('templates/header', $data)
                . view('templates/topbar', $data)
                . view('templates/sidebar', $data)
                . view('menu/submenu_edit', $data)
                . view('templates/footer');

        } else {

            $this->db->table('user_sub_menu')
                ->where('id', $id)
                ->update([
                    'title' => $this->request->getPost('title'),
                    'menu_id' => $this->request->getPost('menu_id'),
                    'url' => $this->request->getPost('url'),
                    'icons' => $this->request->getPost('icons'),
                    'is_active' => $this->request->getPost('is_active'),
                ]);

            session()->setFlashdata('message', 'Submenu berhasil diupdate');
            return redirect()->to('/menu/submenu');
        }
    }
}