<?php

namespace App\Controllers;

use App\Controllers\MainController;

class BukuTamu extends MainController
{
    protected $db;
    protected $validation;

    public function __construct()
    {
        $this->db = db_connect();
        $this->validation = \Config\Services::validation();
        helper(['form', 'url']);
    }

    public function index()
    {
        return redirect()->to('/');
    }

    // ================= VALIDASI TANGGAL =================
    private function validateTanggal($tanggal)
    {
        return $tanggal >= date('Y-m-d');
    }

    // ===================== REKAM =====================
    public function rekam()
    {
        $user = $this->menuData['user'];

        if (!$this->validate([
            'namaTamu' => 'required|min_length[3]',
            'alamatTamu' => 'required',
            'ditemui' => 'required|numeric',
            'tanggalBerkunjung' => 'required|valid_date',
            'keperluanTamu' => 'required',
            'mengatasnamakan' => 'required|in_list[Personal,Organisasi]',
        ])) {

            return $this->render('bukuTamu/rekam/index', [
                'validation' => $this->validation
            ]);
        }

        $tanggal = $this->request->getPost('tanggalBerkunjung');

        if (!$this->validateTanggal($tanggal)) {
            return redirect()->back()->withInput()->with('message',
                '<div class="alert alert-danger">Tanggal harus hari ini atau setelahnya</div>');
        }

        $data = [
            'mengatasnamakan' => esc($this->request->getPost('mengatasnamakan')),
            'namaTamu' => esc($this->request->getPost('namaTamu')),
            'statusTamu' => 0,
            'alamatTamu' => esc($this->request->getPost('alamatTamu')),
            'ditemui' => (int) $this->request->getPost('ditemui'),
            'tanggalBerkunjung' => $tanggal,
            'keperluanTamu' => esc($this->request->getPost('keperluanTamu')),
            'gambar' => $this->request->getPost('gambar') ?? 'tidak ada',
            'tamuMasuk' => time(),
            'tamuKeluar' => null,
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $this->db->table('tamu')->insert($data);

        return redirect()->to('/BukuTamu/data')
            ->with('message', '<div class="alert alert-success">Tamu berhasil direkam</div>');
    }

    // ===================== UPLOAD =====================
    public function upload()
    {
        $file = $this->request->getFile('webcam');

        if ($file && $file->isValid()) {

            if (!$file->hasMoved()) {
                $filename = $file->getRandomName();

                if (!in_array($file->getMimeType(), ['image/png','image/jpeg'])) {
                    return $this->response->setBody('');
                }

                $file->move('img/', $filename);

                return $this->response->setBody($filename);
            }
        }

        return $this->response->setBody('');
    }

    // ===================== HAPUS FOTO =====================
    public function unRekam()
    {
        $gambar = $this->request->getPost('hapusGmr');

        if ($gambar && file_exists('img/' . $gambar)) {
            unlink('img/' . $gambar);
        }

        return redirect()->to('/BukuTamu/rekam');
    }

    // ===================== DATA =====================
    public function data()
    {
        $tamu = $this->db->table('tamu')
            ->orderBy('id', 'DESC')
            ->get()->getResultArray();

        return $this->render('bukuTamu/data/index', [
            'tamu' => $tamu
        ]);
    }

    // ===================== EDIT =====================
    public function editDataTamu($id)
    {
        $tamu = $this->db->table('tamu')->where('id', $id)->get()->getRowArray();

        if (!$this->validate([
            'namaTamu' => 'required',
            'alamatTamu' => 'required',
            'ditemui' => 'required',
            'tanggalBerkunjung' => 'required',
            'keperluanTamu' => 'required',
        ])) {

            return $this->render('bukuTamu/data/edit', [
                'tamu' => $tamu,
                'validation' => $this->validation
            ]);
        }

        $data = [
            'namaTamu' => esc($this->request->getPost('namaTamu')),
            'alamatTamu' => esc($this->request->getPost('alamatTamu')),
            'ditemui' => (int) $this->request->getPost('ditemui'),
            'tanggalBerkunjung' => $this->request->getPost('tanggalBerkunjung'),
            'keperluanTamu' => esc($this->request->getPost('keperluanTamu')),
            'gambar' => $this->request->getPost('gambar'),
        ];

        $this->db->table('tamu')->where('id', $id)->update($data);

        return redirect()->to('/BukuTamu/data')
            ->with('message', '<div class="alert alert-success">Data berhasil diupdate</div>');
    }

    // ===================== HAPUS =====================
    public function hapusDataTamu($id)
    {
        $tamu = $this->db->table('tamu')->where('id', $id)->get()->getRowArray();

        if ($tamu && $tamu['gambar'] !== 'tidak ada') {
            $path = 'img/' . $tamu['gambar'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->db->table('tamu')->delete(['id' => $id]);

        return redirect()->to('/BukuTamu/data')
            ->with('message', '<div class="alert alert-success">Data berhasil dihapus</div>');
    }

    // ===================== CETAK =====================
    public function cetak()
    {
        $tamu = $this->db->table('tamu')->get()->getResultArray();
        $users = $this->db->table('user')->get()->getResultArray();

        return view('bukuTamu/data/cetak', compact('tamu', 'users'));
    }
}