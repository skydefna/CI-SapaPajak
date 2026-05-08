<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MainController extends Controller
{
    protected $helpers = ['url', 'form', 'settings'];
    protected $db;
    protected $settings = [];
    protected $menuData = [];

    protected function withGlobal($data)
    {
        return array_merge(
            $data,
            $this->getVisitorStats(),
            $this->getFooterData()
        );
    }

    protected function getFooterData()
    {
        $social = $this->db->table('social_media')->get()->getResultArray();

        $kontak = [];
        $sosmed = [];
        $link = [];

        foreach ($social as $s) {
            if (in_array($s['platform'], ['whatsapp','telepon'])) {
                $kontak[] = $s;
            } elseif ($s['platform'] == 'website') {
                $link[] = $s;
            } else {
                $sosmed[] = $s;
            }
        }

        return [
            'kontak' => $kontak,
            'sosmed' => $sosmed,
            'link'   => $link
        ];
    }

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        // 🔥 INIT DB DULU (WAJIB)
        $this->db = \Config\Database::connect();

        // 🔥 COUNT VISITOR
        $this->countVisitor();

        $this->checkAccess();

        // 🔥 SETTINGS
        $settings = $this->db->table('settings')->get()->getResultArray();

        $dataSetting = [];
        foreach ($settings as $s) {
            $dataSetting[$s['key']] = $s['value'];
        }

        $this->settings = $dataSetting;

        // 🔥 MENU
        $this->loadMenu();
    }

    protected function loadMenu()
    {
        $session = session();

        if (!$session->get('username')) return;

        $user = $this->db->table('user')
            ->where('username', $session->get('username'))
            ->get()
            ->getRowArray();

        if (!$user) return;

        $menus = $this->db->table('user_menu')
            ->whereIn('id', function($builder) use ($user) {
                return $builder->select('menu_id')
                    ->from('user_access_menu')
                    ->where('role_id', $user['role_id']);
            })
            ->orderBy('urutan', 'ASC')
            ->get()
            ->getResultArray();

        $submenus = $this->db->table('user_sub_menu')
            ->whereIn('id', function($builder) use ($user) {
                return $builder->select('menu_id')
                    ->from('user_access_menu')
                    ->where('role_id', $user['role_id']);
            })
            ->where('aktif', 1)
            ->get()
            ->getResultArray();
        
        $userRole = $this->db->table('user_role')
            ->get()
            ->getResultArray();

        $this->menuData = [
            'user' => $user,
            'menus' => $menus,
            'submenus' => $submenus,
            'userRole' => $userRole // 🔥 WAJIB
        ];
    }

    protected function checkAccess()
    {
        $router = service('router');
        $controller = strtolower(class_basename($router->controllerName()));

        // contoh:
        // Dashboard → dashboard

        // bypass public
        if (in_array($controller, ['tamu', 'login'])) {
            return;
        }

        $session = session();

        if (!$session->get('username')) return;

        $user = $this->db->table('user')
            ->where('username', $session->get('username'))
            ->get()
            ->getRowArray();

        if (!$user) return;

        // 🔥 CEK BERDASARKAN CONTROLLER
        $menu = $this->db->table('user_menu')
            ->where('controllers', $controller)
            ->whereIn('id', function($builder) use ($user) {
                return $builder->select('menu_id')
                    ->from('user_access_menu')
                    ->where('role_id', $user['role_id']);
            })
            ->get()
            ->getRow();

        if (!$menu) {
            return redirect()->to('/login/blocked')->send();
            exit;
        }
    }

    protected function render($view, $data = [])
    {
        // 🔥 ambil statistik visitor
        $visitor = $this->getVisitorStats();

        $default = [
            'title' => '',
            'menus' => $this->menuData['menus'] ?? [],
            'submenus' => $this->menuData['submenus'] ?? [],
            'user' => $this->menuData['user'] ?? [],
            'userRole' => $this->menuData['userRole'] ?? [],

            // 🔥 TAMBAHAN INI
            'today' => $visitor['today'],
            'month' => $visitor['month'],
            'year'  => $visitor['year'],
            'total' => $visitor['total'],
        ];

        $data = array_merge($default, $data);

        return view('templates/header', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view($view, $data)
            . view('templates/footer', $data);
    }

    protected function countVisitor()
    {
        $session = session();
        $today = date('Y-m-d');

        if ($session->get('visited_date') !== $today) {

            $this->db->table('visitors')->insert([
                'visit_date' => $today
            ]);

            $session->set('visited_date', $today);
        }
    }

    protected function getVisitorStats()
    {
        $today = date('Y-m-d');

        $startMonth = date('Y-m-01');
        $endMonth   = date('Y-m-t');

        $startYear = date('Y-01-01');
        $endYear   = date('Y-12-31');

        return [

            // HARI INI
            'today' => $this->db->table('visitors')
                ->where('visit_date', $today)
                ->countAllResults(),

            // BULAN INI
            'month' => $this->db->table('visitors')
                ->where('visit_date >=', $startMonth)
                ->where('visit_date <=', $endMonth)
                ->countAllResults(),

            // TAHUN INI
            'year' => $this->db->table('visitors')
                ->where('visit_date >=', $startYear)
                ->where('visit_date <=', $endYear)
                ->countAllResults(),

            // TOTAL
            'total' => $this->db->table('visitors')
                ->countAll(),
        ];
    }

    public function getVisitorChart()
    {
        return $this->db->table('visitors')
            ->select("
                MONTH(visit_date) as bulan,
                YEAR(visit_date) as tahun,
                COUNT(*) as total
            ")
            ->groupBy("YEAR(visit_date), MONTH(visit_date)")
            ->orderBy('tahun', 'ASC')
            ->orderBy('bulan', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getVisitorYearChart()
    {
        return $this->db->table('visitors')
            ->select("
                YEAR(visit_date) as tahun,
                COUNT(*) as total
            ")
            ->groupBy("YEAR(visit_date)")
            ->orderBy('tahun', 'ASC')
            ->get()
            ->getResultArray();
    }
}