<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $db = db_connect();

        // ================= LOGIN CHECK =================
        if (!$session->get('isLoggedIn')) {

            return redirect()->to('/login');
        }

        // ================= SESSION TIMEOUT =================
        $timeout = 1800; // 30 menit

        if (
            $session->get('last_activity') &&
            (time() - $session->get('last_activity') > $timeout)
        ) {

            session()->destroy();

            return redirect()->to('/login')
                ->with('message', 'Session expired, silakan login kembali.')
                ->with('type', 'warning');
        }

        // update activity
        $session->set('last_activity', time());

        $role_id = $session->get('role_id');

        // ================= AMBIL USER =================
        $user = $db->table('user')
            ->getWhere([
                'username' => $session->get('username')
            ])
            ->getRowArray();

        // ================= USER TIDAK ADA =================
        if (!$user) {

            session()->destroy();

            return redirect()->to('/login')
                ->with('message', 'Session tidak valid.')
                ->with('type', 'danger');
        }

        // ================= FORCE CHANGE PASSWORD =================
        $path = $request->getUri()->getPath();

        if ($user['must_change_password'] == 1) {

            // hanya boleh akses halaman settings
            if (!str_contains($path, 'settings')) {

                return redirect()->to('/settings/account');
            }
        }

        // ================= CEK AKSES MENU =================
        $router = service('router');

        $controller = $router->controllerName();

        // ambil nama controller saja
        $controller = strtolower(
            substr(strrchr($controller, '\\'), 1)
        );

        // ================= CARI MENU =================
        $queryMenu = $db->table('user_menu')
            ->where('controllers', $controller)
            ->get()
            ->getRowArray();

        // ================= MENU TIDAK DITEMUKAN =================
        if (!$queryMenu) {

            return redirect()->to('/login/blocked');
        }

        $menu_id = $queryMenu['id'];

        // ================= CEK HAK AKSES =================
        $userAccess = $db->table('user_access_menu')
            ->getWhere([
                'role_id' => $role_id,
                'menu_id' => $menu_id
            ])
            ->getNumRows();

        // ================= AKSES DITOLAK =================
        if ($userAccess < 1) {

            return redirect()->to('/login/blocked');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // optional
    }
}