<?php

namespace App\Models;

use CodeIgniter\Model;

class OmsetDua_model extends Model
{
    protected $table = 'omset';

    // 🔹 SUM OMSET
    public function sumByMonth($month)
    {
        return $this->db->table($this->table)
            ->selectSum('nilai_omset')
            ->where("DATE_FORMAT(bulan, '%m%Y') =", $month . date('Y'))
            ->where('id !=', 1)
            ->get()
            ->getRowArray();
    }

    // 🔹 SUM KEMBALIAN
    public function sumKembalianByMonth($month)
    {
        return $this->db->table($this->table)
            ->selectSum('jumlah_kembalian')
            ->where("DATE_FORMAT(bulan, '%m%Y') =", $month . date('Y'))
            ->where('id !=', 1)
            ->get()
            ->getRowArray();
    }
}