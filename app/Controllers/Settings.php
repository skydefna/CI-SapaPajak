<?php

namespace App\Controllers;

use App\Controllers\MainController;

class Settings extends MainController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['form', 'url']);
    }

    // =========================================================
    // ACCOUNT
    // =========================================================

    public function account()
    {
        $data = [
            'title'    => 'Setting Account',
            'userRole' => $this->db->table('user_role')->get()->getResultArray(),
            'user'     => $this->menuData['user']
        ];

        return $this->render('settings/account/index', $data);
    }

    public function updateAccount()
    {
        $name = trim($this->request->getPost('name'));
        $nip  = trim($this->request->getPost('nip'));

        // ================= VALIDASI =================
        if (strlen($name) < 3) {

            return redirect()->back()
                ->withInput()
                ->with('message', 'Nama minimal 3 karakter')
                ->with('type', 'danger');
        }

        if (strlen($name) > 100) {

            return redirect()->back()
                ->withInput()
                ->with('message', 'Nama terlalu panjang')
                ->with('type', 'danger');
        }

        $this->db->table('user')
            ->where('id', $this->request->getPost('id'))
            ->update([
                'name' => strip_tags($name),
                'nip'  => $nip !== '' ? strip_tags($nip) : null
            ]);

        return redirect()->back()
            ->with('message', 'Profile berhasil diupdate')
            ->with('type', 'success');
    }

    // =========================================================
    // CHANGE PASSWORD
    // =========================================================

    public function changePassword()
    {
        $session = session();

        // ================= AMBIL USER =================
        $user = $this->db->table('user')
            ->where('username', $session->get('username'))
            ->get()
            ->getRowArray();

        // user tidak ada
        if (!$user) {

            $session->destroy();

            return redirect()->to('/login');
        }

        // ================= INPUT =================
        $current = trim($this->request->getPost('current_password'));
        $new     = trim($this->request->getPost('passwd1'));
        $confirm = trim($this->request->getPost('passwd2'));

        // ================= VALIDASI =================

        // password lama salah
        if (!password_verify($current, $user['password'])) {

            return redirect()->back()
                ->withInput()
                ->with('message', 'Password lama salah')
                ->with('type', 'danger');
        }

        // konfirmasi tidak cocok
        if ($new !== $confirm) {

            return redirect()->back()
                ->withInput()
                ->with('message', 'Konfirmasi password tidak cocok')
                ->with('type', 'danger');
        }

        // minimal panjang
        if (strlen($new) < 6) {

            return redirect()->back()
                ->withInput()
                ->with('message', 'Password minimal 6 karakter')
                ->with('type', 'danger');
        }

        // password sama
        if (password_verify($new, $user['password'])) {

            return redirect()->back()
                ->withInput()
                ->with('message', 'Password baru tidak boleh sama')
                ->with('type', 'danger');
        }

        // ================= UPDATE =================
        $this->db->table('user')
            ->where('id', $user['id'])
            ->update([
                'password' => password_hash($new, PASSWORD_DEFAULT),
                'must_change_password' => 0
            ]);

        // ================= LOGOUT =================
        $session->destroy();

        return redirect()->to('/login')
            ->with('message', 'Password berhasil diubah, silakan login kembali')
            ->with('type', 'success');
    }

    // =========================================================
    // GANTI FOTO PROFILE
    // =========================================================

    public function gantiFotoProfile()
    {
        $session = session();

        // ================= USER =================
        $user = $this->db->table('user')
            ->where('id', $session->get('user_id'))
            ->get()
            ->getRowArray();

        if (!$user) {

            $session->destroy();

            return redirect()->to('/login');
        }

        // ================= FILE =================
        $file = $this->request->getFile('image');

        if (!$file || !$file->isValid()) {

            return redirect()->back()
                ->with('message', 'File tidak valid')
                ->with('type', 'danger');
        }

        // ================= VALIDASI =================

        // ukuran max 2MB
        if ($file->getSize() > 2 * 1024 * 1024) {

            return redirect()->back()
                ->with('message', 'Ukuran file maksimal 2MB')
                ->with('type', 'danger');
        }

        // extension
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array(strtolower($file->getExtension()), $allowedExt)) {

            return redirect()->back()
                ->with('message', 'Format file tidak valid')
                ->with('type', 'danger');
        }

        // mime type
        $allowedMime = [
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!in_array($file->getMimeType(), $allowedMime)) {

            return redirect()->back()
                ->with('message', 'Mime type tidak valid')
                ->with('type', 'danger');
        }

        // benar-benar gambar
        if (!@getimagesize($file->getTempName())) {

            return redirect()->back()
                ->with('message', 'File bukan gambar valid')
                ->with('type', 'danger');
        }

        // ================= HAPUS FILE LAMA =================
        if (!empty($user['image'])) {

            $oldPath = WRITEPATH . 'uploads/users/' . $user['image'];

            if (
                file_exists($oldPath) &&
                is_file($oldPath)
            ) {
                unlink($oldPath);
            }
        }

        // ================= UPLOAD =================
        $newName = $file->getRandomName();

        $file->move(
            WRITEPATH . 'uploads/users/',
            $newName
        );

        // ================= UPDATE DB =================
        $this->db->table('user')
            ->where('id', $user['id'])
            ->update([
                'image' => $newName
            ]);

        return redirect()->back()
            ->with('message', 'Foto profile berhasil diupdate')
            ->with('type', 'success');
    }

    // =========================================================
    // WEBSITE
    // =========================================================

    public function website()
    {
        $user = $this->menuData['user'];

        // ambil semua setting
        $settings = $this->db->table('settings')
            ->get()
            ->getResultArray();

        // ubah ke key => value
        $dataSetting = [];

        foreach ($settings as $s) {

            $dataSetting[$s['key']] = $s['value'];
        }

        $data = [
            'title'    => 'Setting Website',
            'user'     => $user,
            'settings' => $dataSetting
        ];

        return $this->render('settings/website/index', $data);
    }

    public function updateWebsite()
    {
        // ================= DELETE =================
        $delete = $this->request->getPost('delete');

        if ($delete) {

            $old = $this->db->table('settings')
                ->where('key', $delete)
                ->get()
                ->getRowArray();

            if ($old && !empty($old['value'])) {

                $path = WRITEPATH . 'uploads/settings/' . $old['value'];

                if (
                    file_exists($path) &&
                    is_file($path)
                ) {
                    unlink($path);
                }
            }

            $this->db->table('settings')
                ->where('key', $delete)
                ->delete();

            return redirect()->back()
                ->with('message', 'File berhasil dihapus')
                ->with('type', 'success');
        }

        // ================= TEXT =================
        $fields = ['deskripsi', 'youtube'];

        foreach ($fields as $field) {

            $this->db->table('settings')->replace([
                'key'   => $field,
                'value' => strip_tags(
                    $this->request->getPost($field) ?? ''
                )
            ]);
        }

        // ================= FILE =================
        $files = [
            'logo_tab',
            'logo_sapapajak',
            'logo_tabalong',
            'logo_login',
            'bg_login'
        ];

        foreach ($files as $file) {

            $img = $this->request->getFile($file);

            if (
                $img &&
                $img->isValid() &&
                !$img->hasMoved()
            ) {

                // ================= VALIDASI =================

                // ukuran max 2MB
                if ($img->getSize() > 2 * 1024 * 1024) {

                    return redirect()->back()
                        ->with('message', 'Ukuran file maksimal 2MB')
                        ->with('type', 'danger');
                }

                // extension
                $allowedExt = [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp'
                ];

                if (
                    !in_array(
                        strtolower($img->getExtension()),
                        $allowedExt
                    )
                ) {

                    return redirect()->back()
                        ->with('message', 'Format gambar tidak valid')
                        ->with('type', 'danger');
                }

                // mime
                $allowedMime = [
                    'image/jpg',
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                if (
                    !in_array(
                        $img->getMimeType(),
                        $allowedMime
                    )
                ) {

                    return redirect()->back()
                        ->with('message', 'Mime type tidak valid')
                        ->with('type', 'danger');
                }

                // valid image
                if (!@getimagesize($img->getTempName())) {

                    return redirect()->back()
                        ->with('message', 'File bukan gambar valid')
                        ->with('type', 'danger');
                }

                // ================= HAPUS FILE LAMA =================
                $old = $this->db->table('settings')
                    ->where('key', $file)
                    ->get()
                    ->getRowArray();

                if ($old && !empty($old['value'])) {

                    $oldPath = WRITEPATH . 'uploads/settings/' . $old['value'];

                    if (
                        file_exists($oldPath) &&
                        is_file($oldPath)
                    ) {
                        unlink($oldPath);
                    }
                }

                // ================= UPLOAD =================
                $name = $img->getRandomName();

                $img->move(
                    WRITEPATH . 'uploads/settings/',
                    $name
                );

                // ================= UPDATE DB =================
                $this->db->table('settings')->replace([
                    'key'   => $file,
                    'value' => $name
                ]);
            }
        }

        return redirect()->back()
            ->with('message', 'Setting website berhasil diupdate')
            ->with('type', 'success');
    }

    // =========================================================
    // SOCIAL MEDIA
    // =========================================================

    public function social()
    {
        $data = [
            'title' => 'Media Sosial',
        ];

        $social = $this->db->table('social_media')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($social as &$s) {

            $host = parse_url($s['url'], PHP_URL_HOST);

            $iconMap = [
                'instagram' => 'bxl-instagram-alt',
                'facebook'  => 'bxl-facebook',
                'youtube'   => 'bxl-youtube',
                'website'   => 'bx-world',
                'tiktok'    => 'bxl-tiktok',
                'whatsapp'  => 'bxl-whatsapp',
                'x'         => 'bxl-twitter',
                'telepon'   => 'bx-phone'
            ];

            $icon = $iconMap[$s['platform']] ?? 'bx-link';

            if ($s['platform'] === 'website' && $host) {

                if (strpos($host, 'google') !== false) {
                    $icon = 'bxl-google';
                } elseif (strpos($host, 'github') !== false) {
                    $icon = 'bxl-github';
                } elseif (strpos($host, 'youtube') !== false) {
                    $icon = 'bxl-youtube';
                } elseif (strpos($host, 'facebook') !== false) {
                    $icon = 'bxl-facebook';
                } elseif (strpos($host, 'instagram') !== false) {
                    $icon = 'bxl-instagram-alt';
                } else {
                    $icon = 'bx-world';
                }
            }

            $s['icon'] = $icon;
        }

        $data['social'] = $social;

        return $this->render('admin/social_media', $data);
    }

    public function saveSocial()
    {
        $id       = $this->request->getPost('id');
        $platform = trim($this->request->getPost('platform'));
        $url      = trim($this->request->getPost('url'));
        $name     = trim($this->request->getPost('name'));

        if (!$platform) {

            return redirect()->back()
                ->with('message', 'Platform wajib diisi')
                ->with('type', 'danger');
        }

        // ================= WHATSAPP =================
        if ($platform === 'whatsapp') {

            $wa = $this->request->getPost('whatsapp');

            if (!$wa) {

                return redirect()->back()
                    ->with('message', 'Nomor WhatsApp wajib diisi')
                    ->with('type', 'danger');
            }

            $wa = preg_replace('/[^0-9]/', '', $wa);

            // convert 08 => 628
            if (substr($wa, 0, 1) == '0') {

                $wa = '62' . substr($wa, 1);
            }

            $url = 'https://wa.me/' . $wa;
        }

        // ================= TELEPON =================
        if ($platform === 'telepon') {

            $telp = $this->request->getPost('telepon');

            if (!$telp) {
                return redirect()->back()
                    ->with('message', 'Nomor telepon wajib diisi')
                    ->with('type', 'danger');
            }

            $url = 'tel:' . preg_replace('/[^0-9]/', '', $telp);
        }

        // ================= VALIDASI URL =================
        if (
            $platform !== 'telepon' &&
            $platform !== 'whatsapp'
        ) {

            if (!filter_var($url, FILTER_VALIDATE_URL)) {

                return redirect()->back()
                    ->with('message', 'URL tidak valid')
                    ->with('type', 'danger');
            }
        }

        // ================= INSERT / UPDATE =================
        $data = [
            'platform' => strip_tags($platform),
            'url'      => strip_tags($url),
            'name'     => strip_tags($name)
        ];

        if ($id) {

            $this->db->table('social_media')
                ->where('id', $id)
                ->update($data);

        } else {

            $this->db->table('social_media')
                ->insert($data);
        }

        return redirect()->back()
            ->with('message', 'Data berhasil disimpan')
            ->with('type', 'success');
    }

    public function deleteSocial($id)
    {
        $this->db->table('social_media')
            ->delete([
                'id' => $id
            ]);

        return redirect()->back()
            ->with('message', 'Data berhasil dihapus')
            ->with('type', 'success');
    }
}