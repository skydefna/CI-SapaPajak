<?php

namespace App\Controllers;

use Dompdf\Dompdf;

class Tamu extends MainController
{
    protected $db;
    protected $settings;
    protected $validation;
    

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        $this->validation = \Config\Services::validation();

        helper(['form', 'url']);

        date_default_timezone_set('Asia/Kuala_Lumpur');
    }
    // ================= INDEX =================
    public function index()
    {
        $all = $this->db->table('tamu')->get()->getResultArray();
        $per = $this->db->table('tamu')->where('mengatasnamakan', 'Personal')->get()->getResultArray();
        $org = $this->db->table('tamu')->where('mengatasnamakan', 'Organisasi')->get()->getResultArray();

        $testimoni = $this->db->table('testimonies_detail')
            ->orderBy('kepuasan', 'ASC')
            ->orderBy('tanggal', 'DESC')
            ->limit(3)
            ->get()->getResultArray();

        // ================= SETTINGS =================
        $settings = $this->db->table('settings')->get()->getResultArray();

        $this->settings = [];
        foreach ($settings as $s) {
            $this->settings[$s['key']] = $s['value'];
        }

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

        $data = [
            'title' => "SapaPajak Tabalong",
            'all' => $all,
            'per' => $per,
            'org' => $org,
            'totalTamu' => count($all),
            'personalTamu' => count($per),
            'organisasiTamu' => count($org),
            'testimoni' => $testimoni,
            'settings' => $this->settings,            
            'kontak' => $kontak,
            'sosmed' => $sosmed,
            'link'   => $link
        ];

        $data = array_merge($data, $this->getVisitorStats());

        return view('templates/auth_header', $data)
            . view('tamu/tempWel/nav', $data)
            . view('tamu/index', $data)
            . view('tamu/tempWel/footer', $data)
            . view('templates/auth_footer', $data);
    }

    // ================= VALIDASI TANGGAL =================
    private function validateTanggal($tanggal)
    {
        if (!$tanggal) return false;

        $day = date('N', strtotime($tanggal)); // 1-7

        // 6 = Sabtu, 7 = Minggu
        if ($day == 6 || $day == 7) {
            return false;
        }

        return true;
    }

    // ================= PERSONAL =================
    public function personal($code = null)
    {
        $data = $this->withGlobal([
            'title' => "Tamu Personal",
            'users' => $this->db->table('user')->get()->getResultArray(),
            'codeNull' => $code,
            'settings' => $this->settings
        ]);

        // VALIDASI FORM
        if (!$this->validate([
            'namaTamu' => 'required',
            'alamatTamu' => 'required',
            'ditemui' => 'required',
            'tanggalBerkunjung' => 'required',
            'keperluanTamu' => 'required',
        ])) {

            return view('templates/auth_header', $data)
                . view('tamu/tempWel/nav', $data)
                . view('tamu/cari', $data)
                . view('tamu/buku_tamu/personal', $data)
                . view('tamu/tempWel/footer', $data)
                . view('templates/auth_footer', $data);
        }

        // ==============================
        // TURNSTILE VALIDATION
        // ==============================

        $token = $this->request->getPost('cf-turnstile-response');

        $client = \Config\Services::curlrequest();

        $response = $client->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'form_params' => [
                    'secret'   => '0x4AAAAAADLJndoSTBTYHZomQBK6Kqy2tcI',
                    'response' => $token,
                    'remoteip' => $this->request->getIPAddress()
                ]
            ]
        );

        $result = json_decode($response->getBody(), true);

        // CAPTCHA GAGAL
        if (!$result['success']) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Captcha gagal, silakan coba lagi.');
        }

        // ==============================
        // INSERT DATABASE
        // ==============================

        $dataInsert = [
            'mengatasnamakan' => $this->request->getPost('mengatasnamakan'),
            'namaTamu' => $this->request->getPost('namaTamu'),
            'statusTamu' => 0,
            'codeTamu' => rand(100000, 999999),
            'alamatTamu' => $this->request->getPost('alamatTamu'),
            'ditemui' => $this->request->getPost('ditemui'),
            'tanggalBerkunjung' => $this->request->getPost('tanggalBerkunjung'),
            'keperluanTamu' => $this->request->getPost('keperluanTamu'),
            'gambar' => $this->request->getPost('gambar'),
            'tamuMasuk' => time(),
            'created_at' => date("Y-m-d H:i:s"),
            'role_id' => 5
        ];

        $this->db->table('tamu')->insert($dataInsert);

        return redirect()->to('/tamu/buku_tamu/' . $dataInsert['codeTamu'])
            ->with('autoDownload', true);
    }

    // ================= ORGANISASI =================
    public function organisasi($code = null)
    {
        $data = $this->withGlobal([
            'title' => "Tamu Organisasi",
            'users' => $this->db->table('user')->get()->getResultArray(),
            'codeNull' => $code,
            'settings' => $this->settings
        ]);

        if (!$this->validate([
            'namaTamu' => 'required',
            'alamatTamu' => 'required',
            'ditemui' => 'required',
            'tanggalBerkunjung' => 'required',
            'keperluanTamu' => 'required',
        ])) {

            return view('templates/auth_header', $data)
                . view('tamu/tempWel/nav', $data)
                . view('tamu/cari', $data)
                . view('tamu/buku_tamu/organisasi', $data)
                . view('tamu/tempWel/footer', $data)
                . view('templates/auth_footer', $data);
        }

        $dataInsert = [
            'mengatasnamakan' => htmlspecialchars($this->request->getPost('mengatasnamakan')),
            'namaTamu' => htmlspecialchars($this->request->getPost('namaTamu')),
            'statusTamu' => 0,
            'codeTamu' => rand(100000, 999999),
            'alamatTamu' => htmlspecialchars($this->request->getPost('alamatTamu')),
            'ditemui' => htmlspecialchars($this->request->getPost('ditemui')),
            'tanggalBerkunjung' => $this->request->getPost('tanggalBerkunjung'),
            'keperluanTamu' => htmlspecialchars(str_replace(["\n","\r"], '', $this->request->getPost('keperluanTamu'))),
            'gambar' => $this->request->getPost('gambar'),
            'tamuMasuk' => time(),
            'tamuKeluar' => null,
            'created_at' => date("Y-m-d H:i:s")
        ];

        $this->db->table('tamu')->insert($dataInsert);

        return redirect()->to('/tamu/buku_tamu/' . $dataInsert['codeTamu'])
            ->with('message', '<div class="alert alert-success">Berhasil!</div>');
    }

    // ================= BUKU TAMU =================
    public function buku_tamu($code = null)
    {
        $codeTamu = $this->db->table('tamu')
            ->where('codeTamu', $code)
            ->get()->getRowArray();

        $data = $this->withGlobal([
            'title' => "Buku Tamu",
            'codeTamu' => $codeTamu,
            'users' => $this->db->table('user')->get()->getResultArray(),
            'codeNull' => $code,
            'settings' => $this->settings
        ]);

        if (!$code) {
            return view('templates/auth_header', $data)
                . view('tamu/tempWel/nav', $data)
                . view('tamu/cari', $data)
                . view('tamu/janji', $data)
                . view('tamu/tempWel/footer', $data)
                . view('templates/auth_footer', $data);
        }

        if (!$codeTamu) {
            return view('templates/auth_header', $data)
                . view('tamu/tempWel/nav', $data)
                . view('tamu/cari', $data)
                . view('tamu/error/nullData', $data)
                . view('tamu/tempWel/footer', $data)
                . view('templates/auth_footer', $data);
        }

        return view('templates/auth_header', $data)
            . view('tamu/tempWel/nav', $data)
            . view('tamu/cari', $data)
            . view('tamu/codeTamu', $data)
            . view('tamu/tempWel/footer', $data)
            . view('templates/auth_footer', $data);
    }

    // ================= ABOUT =================
    public function about()
    {
        $data = $this->withGlobal([
            'title' => "Tentang Kami",
            'settings' => $this->settings
        ]);

        return view('templates/auth_header', $data)
            . view('tamu/tempWel/nav', $data)
            . view('tamu/about', $data)
            . view('tamu/tempWel/footer', $data)
            . view('templates/auth_footer', $data);
    }

    // ================= DOCUMENTATION =================
    public function documentation()
    {
        $data = $this->withGlobal([
            'title' => "Dokumentasi",
            'settings' => $this->settings
        ]);

        return view('templates/auth_header', $data)
            . view('tamu/tempWel/nav', $data)
            . view('tamu/doc', $data)
            . view('tamu/tempWel/footer', $data)
            . view('templates/auth_footer', $data);
    }

    public function downloadPdf($code)
    {
        $tamu = $this->db->table('tamu')
            ->where('codeTamu', $code)
            ->get()->getRowArray();

        $user = $this->db->table('user')
            ->where('id', $tamu['ditemui'])
            ->get()->getRowArray();

        $data = [
            'codeTamu' => $tamu['codeTamu'],
            'namaTamu' => $tamu['namaTamu'],
            'alamatTamu' => $tamu['alamatTamu'],
            'ditemui' => $user['jabatan'] ?? '-',
            'tanggal' => date('d F Y', strtotime($tamu['tanggalBerkunjung']))
        ];

        $html = view('tamu/pdf_kode', ['data' => $data]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A6', 'portrait');
        $dompdf->render();

        $dompdf->stream("kode_tamu_" . $code . ".pdf", ["Attachment" => true]);
    }
}