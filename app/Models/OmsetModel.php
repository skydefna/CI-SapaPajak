<?php

namespace App\Models;

use CodeIgniter\Model;

class OmsetModel extends Model
{
    protected $table = 'omset';

    // 🔹 Ambil tanggal terakhir
    public function getData()
    {
        return $this->select('tanggal_stor')
            ->orderBy('tanggal_stor', 'DESC')
            ->first();
    }

    // 🔹 Data bulan sekarang
    public function getBulan()
    {
        $bulan = date('mY');

        return $this->where('bulan', $bulan)
            ->where('id !=', 1)
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    // 🔹 Data bulan sekarang (old table)
    public function getBulanOld()
    {
        $db = \Config\Database::connect();
        $bulan = date('mY');

        return $db->table('omset_old')
            ->where('bulan', $bulan)
            ->where('id !=', 1)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();
    }

    // 🔹 Data terakhir
    public function getDataAkhir()
    {
        return $this->orderBy('id', 'DESC')
            ->first();
    }

    // 🔹 SUM OMSET bulan ini
    public function getAll()
    {
        $bulan = date('mY');

        return $this->selectSum('nilai_omset')
            ->where('bulan', $bulan)
            ->where('id !=', 1)
            ->first();
    }

    // 🔹 SUM KEMBALIAN bulan ini
    public function getAss()
    {
        $bulan = date('mY');

        return $this->selectSum('jumlah_kembalian')
            ->where('bulan', $bulan)
            ->where('id !=', 1)
            ->first();
    }

    // 🔹 Total tagihan
    public function anggaran()
    {
        $db = \Config\Database::connect();

        return $db->table('tagihan')
            ->selectSum('total_tagihan')
            ->get()
            ->getRowArray();
    }

    // 🔹 Total semua omset
    public function sumLabaAll()
    {
        return $this->selectSum('nilai_omset')->first();
    }

    // 🔹 Total semua kembalian
    public function sumKembalianAll()
    {
        return $this->selectSum('jumlah_kembalian')->first();
    }
}