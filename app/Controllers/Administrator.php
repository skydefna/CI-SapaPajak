<?php

namespace App\Controllers;

use App\Controllers\MainController;

class Administrator extends MainController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
    }

    public function getMenu($id)
    {
        $akses = $this->db->table('user_access_menu')
            ->where('role_id',$id)
            ->get()->getResultArray();

        return $this->response->setJSON(array_column($akses,'menu_id'));
    }

    public function index()
    {
        $user = $this->menuData['user'];

        $data = [
            'title' => 'Dashboard',
            'sub'   => 'Administrator',

            'user' => $user,

            'userRole' => $this->db->table('user_role')->get()->getResultArray(),

            'log' => $this->db->table('log')
                ->orderBy('id', 'DESC')
                ->get()
                ->getResultArray()
        ];

        return $this->render('admin/index', $data);
    }

    // ================= MENU =================
    public function menu()
    {
        $data = [
            'title' => 'Kelola Menu',
            'user'  => $this->menuData['user'],

            // 🔥 GANTI NAMA!
            'menuList' => $this->db->table('user_menu')
                ->select('*')
                ->orderBy('urutan', 'ASC')
                ->get()
                ->getResultArray()
        ];

        return $this->render('admin/menu', $data);
    }

    // ================= EDIT =================
    public function editMenu($id)
    {
        $this->db->table('user_menu')->where('id',$id)->update([
            'menu'        => $this->request->getPost('menu'),
            'controllers' => $this->request->getPost('controllers'),
            'group_label' => $this->request->getPost('group_label'),    
            'icon'        => $this->request->getPost('icon'),
            'iconActive'  => $this->request->getPost('iconActive'),
            'url'         => $this->request->getPost('url'),
            'urutan'      => $this->request->getPost('urutan'),
        ]);

        return redirect()->back()->with('message','Menu berhasil diupdate');
    }


    // ================= DELETE =================
    public function deleteMenu($id)
    {
        $this->db->table('user_menu')->delete(['id' => $id]);

        return redirect()->back()
            ->with('message', 'Menu berhasil dihapus')
            ->with('type', 'success');
    }

    // ================= USERS =================
    public function users()
    {
        helper(['form']);
        $validation = \Config\Services::validation();

        $user = $this->menuData['user'];

        $data = [
            'title' => 'Kelola Akun',
            'user' => $user,
            'validation' => $validation,
            'userRole' => $this->db->table('user_role')->get()->getResultArray(),

            'usersMAs' => $this->db->table('user u')
                ->select('u.*, r.role')
                ->join('user_role r', 'r.id = u.role_id')
                ->get()->getResultArray()
        ];

        if ($this->request->getMethod(true) === 'POST') {

            if (!$this->validate([
                'username' => 'required|is_unique[user.username]',
                'name'     => 'required',
                'role_id'  => 'required'
            ])) {
                return $this->render('admin/users', $data);
            }

            $this->db->table('user')->insert([
                'username'     => $this->request->getPost('username'),
                'name'         => $this->request->getPost('name'),
                'jabatan'      => $this->request->getPost('jabatan'),
                'nip'          => $this->request->getPost('nip') ?: '-',
                'password'     => password_hash('tabalongsmart', PASSWORD_DEFAULT),
                'role_id'      => $this->request->getPost('role_id'),
                'image'        => 'default.jpg',
                'is_active'    => $this->request->getPost('is_active') ? 1 : 0,
                'must_change_password' => 1,
                'date_created' => time()
            ]);

            return redirect()->to('/administrator/users')
                ->with('message', '<b>User Berhasil Ditambahkan!</b>');
        }

        return $this->render('admin/users', $data);
    }

    // ================= EDIT USER =================
    public function editUser($id)
    {
        $validation = \Config\Services::validation();

        if ($this->request->getMethod(true) === 'GET') {

            $user = $this->menuData['user'];

            $data = [
                'title' => 'Edit User',
                'user' => $user,
                'validation' => $validation,
                'userEdit' => $this->db->table('user')->where('id', $id)->get()->getRowArray(),
                'userRole' => $this->db->table('user_role')->get()->getResultArray(),
            ];

            return $this->render('admin/user_edit', $data);
        }

        if (!$this->validate([
            'username' => 'required|is_unique[user.username,id,'.$id.']',
            'name'     => 'required',
            'role_id'  => 'required'
        ])) {
            return redirect()->back()->withInput();
        }

        $this->db->table('user')->where('id', $id)->update([
            'username'  => $this->request->getPost('username'),
            'name'      => $this->request->getPost('name'),
            'jabatan'   => $this->request->getPost('jabatan'),
            'nip'       => $this->request->getPost('nip') ?: '-',
            'role_id'   => $this->request->getPost('role_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/administrator/users')
            ->with('message', '<b>User Berhasil Diupdate!</b>');
    }

    public function deleteUser($id)
    {
        $this->db->table('user')->delete(['id' => $id]);

        return redirect()->to('/administrator/users')
            ->with('message', '<b>User Berhasil Dihapus!</b>');
    }

    // ================= ROLE =================
    public function role()
    {
        helper(['form', 'url']);
        $validation = \Config\Services::validation();

        $user = $this->menuData['user'];

        if ($this->request->getMethod() === 'post') {

            if (!$this->validate(['role' => 'required'])) {
                return redirect()->back()->withInput();
            }

            $this->db->table('user_role')->insert([
                'role' => esc($this->request->getPost('role'))
            ]);

            return redirect()->to('/administrator/akses')
                ->with('message', '<b>Role berhasil ditambahkan</b>');
        }

        $data = [
            'title' => 'Peran & Hak Akses',
            'user'  => $user,
            'validation' => $validation,

            'allMenus' => $this->db->table('user_menu')->orderBy('id', 'ASC')->get()->getResultArray(),

            'userRole' => $this->db->table('user_role r')
                ->select('r.*, COUNT(u.id) as total_user')
                ->join('user u', 'u.role_id = r.id', 'left')
                ->groupBy('r.id')
                ->get()->getResultArray()
        ];

        return $this->render('admin/akses', $data);
    }

    // ================= ADD ROLE =================
    public function addRole()
    {
        if (!$this->validate([
            'role' => 'required'
        ])) {
            return redirect()->back()->withInput();
        }

        // insert role
        $this->db->table('user_role')->insert([
            'role' => $this->request->getPost('role')
        ]);

        $role_id = $this->db->insertID();

        // ambil menu yg dipilih
        $menus = $this->request->getPost('menu_id');

        if ($menus) {
            foreach ($menus as $menu_id) {
                $this->db->table('user_access_menu')->insert([
                    'role_id' => $role_id,
                    'menu_id' => $menu_id
                ]);
            }
        }

        return redirect()->to('/administrator/akses')
            ->with('message', 'Role berhasil ditambahkan')
            ->with('type', 'success');
    }

    // ================= EDIT ROLE =================
    public function edit($id)
    {
        // update nama role
        $this->db->table('user_role')
            ->where('id', $id)
            ->update([
                'role' => $this->request->getPost('role')
            ]);

        // 🔥 hapus akses lama
        $this->db->table('user_access_menu')
            ->where('role_id', $id)
            ->delete();

        // 🔥 insert ulang akses baru
        $menus = $this->request->getPost('menu_id');

        if ($menus) {
            foreach ($menus as $menu_id) {
                $this->db->table('user_access_menu')->insert([
                    'role_id' => $id,
                    'menu_id' => $menu_id
                ]);
            }
        }

        return redirect()->to('/administrator/akses')
            ->with('message', 'Hak akses berhasil diupdate');
    }

    // ================= DELETE ROLE =================
    public function delete($id)
    {
        // hapus akses dulu
        $this->db->table('user_access_menu')
            ->where('role_id', $id)
            ->delete();

        // hapus role
        $this->db->table('user_role')
            ->where('id', $id)
            ->delete();

        return redirect()->to('/administrator/akses')
            ->with('message', 'Role berhasil dihapus')
            ->with('type', 'success');
    }

    // ================= RESET PASSWORD =================
    public function resetPassword($id)
    {
        if (session()->get('role_id') != 1) {
            return redirect()->to('/administrator/users')
                ->with('error', 'Akses ditolak!');
        }

        $this->db->table('user')->where('id', $id)->update([
            'password' => password_hash('tabalongsmart', PASSWORD_DEFAULT),
            'must_change_password' => 1
        ]);

        return redirect()->to('/administrator/users')
            ->with('message', '<b>Password berhasil direset</b>')
            ->with('type', 'success');
    }

    public function unblock($id)
    {
        $this->db->table('user')->where('id', $id)->update([
            'login_attempt' => 0,
            'blocked_until' => 0
        ]);

        return redirect()->to('/administrator/users')
            ->with('message', '<b>User berhasil dibuka blokirnya!</b>')
            ->with('type', 'success');
    }
}