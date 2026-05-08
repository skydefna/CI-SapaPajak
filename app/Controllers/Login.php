<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SimataModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        helper(['form', 'url']);

        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $db = \Config\Database::connect();
        $settings = $db->table('settings')->get()->getResultArray();

        $settingData = [];
        foreach ($settings as $s) {
            $settingData[$s['key']] = $s['value'];
        }

        $data['setting'] = $settingData;

        $data['title'] = 'Log In';

        return view('templates/auth_header', $data)
            . view('auth/login', $data)
            . view('templates/auth_footer');
    }

    public function loginProcess()
    {
        helper(['form']);

        // 🔥 VALIDASI
        if (!$this->validate([
            'username' => 'required',
            'password' => 'required'
        ])) {

            return redirect()->to('/login')->withInput();
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $tamuModel = new SimataModel();

        $user = $userModel->where('username', $username)->first();
        $tamu = $tamuModel->where('codeTamu', $username)->first();

        // ❌ TIDAK DITEMUKAN
        if (!$user && !$tamu) {
            session()->setFlashdata('message', 'Username tidak ditemukan!');
            session()->setFlashdata('type', 'danger');
            return redirect()->to('/login')->withInput();
        }

        // ================= USER =================
        if ($user) {

            // BLOKIR
            if (!empty($user['blocked_until']) && $user['blocked_until'] > time()) {
                $sisa = ceil(($user['blocked_until'] - time()) / 60);

                session()->setFlashdata('message', "Akun diblokir {$sisa} menit.");
                session()->setFlashdata('type', 'danger');
                return redirect()->to('/login')->withInput();
            }

            // AKTIF
            if ($user['is_active'] != 1) {
                session()->setFlashdata('message', 'Akun tidak aktif!');
                session()->setFlashdata('type', 'danger');
                return redirect()->to('/login');
            }

            // PASSWORD SALAH
            if (!password_verify($password, $user['password'])) {

                $attempt = ($user['login_attempt'] ?? 0) + 1;

                if ($attempt >= 3) {

                    db_connect()->table('user')->where('id', $user['id'])->update([
                        'login_attempt' => 0,
                        'blocked_until' => time() + 3600
                    ]);

                    session()->setFlashdata('message', 'Akun diblokir 1 jam!');
                    session()->setFlashdata('type', 'danger');

                } else {

                    db_connect()->table('user')->where('id', $user['id'])->update([
                        'login_attempt' => $attempt
                    ]);

                    session()->setFlashdata('message', 'Password salah!');
                    session()->setFlashdata('type', 'danger');
                }

                return redirect()->to('/login')->withInput();
            }

            // ✅ LOGIN BERHASIL            
            session()->regenerate();

            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role_id' => $user['role_id'],
                'isLoggedIn' => true
            ]);

            session()->setFlashdata('message', 'Login berhasil!');
            session()->setFlashdata('type', 'success');

            // reset attempt
            db_connect()->table('user')->where('id', $user['id'])->update([
                'login_attempt' => 0,
                'blocked_until' => 0
            ]);

            if ($user['must_change_password'] == 1) {
                return redirect()->to('/settings/account');
            }

            return redirect()->to('/dashboard');
        }        
    }

    public function logout()
    {
        session()->remove([
            'user_id',
            'username',
            'role_id',
            'isLoggedIn'
        ]);

        session()->destroy();
        
        return redirect()->to('/login');
    }

    public function blocked()
    {
        $db = db_connect();
        $session = session();

        $user = $db->table('user')
            ->where('username', $session->get('username'))
            ->get()
            ->getRowArray();

        $user_access_menu = $db->table('user_access_menu')->get()->getResultArray();

        return view('auth/blocked', [
            'user' => $user,
            'user_access_menu' => $user_access_menu
        ]);
    }
}