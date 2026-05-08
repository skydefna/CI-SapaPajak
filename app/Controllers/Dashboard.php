<?php

namespace App\Controllers;

use App\Models\PaginationModel;
use App\Models\SimataModel;
use App\Controllers\MainController;

class Dashboard extends MainController
{
    protected $simata;
    protected $pagination;
    protected $db;

    public function __construct()
    {
        $this->simata = new SimataModel();
        $this->pagination = new PaginationModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $validation = \Config\Services::validation();
        $user = $this->menuData['user'];

        $data = [
            'title' => 'Dashboard',
            'validation' => $validation,

            'userTamu' => $this->db->table('tamu')
                ->where('codeTamu', $user['username'])
                ->get()
                ->getRowArray(),

            'roles' => $this->db->table('user_role')->get()->getResultArray(),

            'userRole' => $this->db->table('user_role')->get()->getResultArray(),
        ];

        // ================= USERS =================

        $users = $this->simata->usersMAs();

        $roleUsers = [];

        foreach ($users as $u) {
            $roleUsers[$u['role_id']][] = $u;
        }

        $data['roleUsers'] = $roleUsers;
        $data['usersMAs'] = $users;


        // ================= TAMU =================

        $data['tamu'] = $this->simata->tamu($user['id']);

        $data['tamuAll'] = $this->simata->tamuAll();

        $data['tamuBaruAll'] = $this->simata->banyakTamuBaruAll();

        $data['tamuBaru'] = $this->simata->banyakTamuBaru($user['jabatan']);

        $data['tamuDiwakilkan'] = $this->simata->banyakTamuDiwakilkan($user['jabatan']);


        // ================= SOCIAL MEDIA =================

        $data['social_media'] = $this->db->table('social_media')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        // ================= ROLE USER =================

        $data['userRoleStats'] = $this->db->table('user_role ur')
            ->select('ur.id, ur.role, COUNT(u.id) as total')
            ->join('user u', 'u.role_id = ur.id', 'left')
            ->groupBy('ur.id')
            ->orderBy('ur.id', 'ASC')
            ->get()
            ->getResultArray();


        // ================= VISITOR =================

        $data = array_merge($data, $this->getVisitorStats());


        // ================= INSERT USER =================

        if ($this->request->getMethod() === 'post') {

            if (
                !$validation->withRequest($this->request)->run([
                    'username' => 'required',
                    'name' => 'required',
                    'role_id' => 'required'
                ])
            ) {

                return $this->render('dashboard/index', $data);
            }

            $this->db->table('user')->insert([

                'ditemui' => esc($this->request->getPost('ditemui')),

                'name' => esc($this->request->getPost('name')),

                'username' => esc($this->request->getPost('username')),

                'jabatan' => esc($this->request->getPost('jabatan')),

                'nip' => esc($this->request->getPost('nip')),

                'image' => 'default.jpg',

                'password' => password_hash("123", PASSWORD_DEFAULT),

                'role_id' => esc($this->request->getPost('role_id')),

                'is_active' => 1,

                'date_created' => time(),
            ]);

            return redirect()->to('/dashboard')
                ->with('message', 'User berhasil ditambahkan!');
        }

        return $this->render('dashboard/index', $data);
    }


    // ================= CHART KUNJUNGAN =================

    public function chart()
    {
        $data = [
            'title' => 'Diagram Kunjungan',
        ];

        $data['visitorChart'] = $this->getVisitorChart();

        $data['visitorYearChart'] = $this->getVisitorYearChart();

        $data = array_merge($data, $this->getVisitorStats());

        return $this->render('admin/chart_kunjungan', $data);
    }

    public function testimoniChart()
    {
        $data = [
            'title' => 'Diagram Testimoni',
        ];

        // ================= TOTAL KEPUASAN =================

        $data['kepuasanChart'] = $this->db->table('testimonies_detail')
            ->select("
                kepuasan,
                COUNT(*) as total
            ")
            ->groupBy('kepuasan')
            ->orderBy('kepuasan', 'ASC')
            ->get()
            ->getResultArray();

        return $this->render('admin/chart_testimoni', $data);
    }
}