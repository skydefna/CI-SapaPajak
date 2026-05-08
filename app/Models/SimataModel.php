<?php

namespace App\Models;

use CodeIgniter\Model;

class SimataModel extends Model
{
    protected $table = 'tamu';
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // ================= TAMU =================
    public function tamu($ditemui)
    {
        return $this->db->table('tamu')
            ->where('statusTamu', 0)
            ->where('tanggalBerkunjung >=', date('Y-m-d'))
            ->where('ditemui', $ditemui)
            ->get()
            ->getResultArray();
    }

    public function tamuAll()
    {
        return $this->db->table('tamu')
            ->where('statusTamu', 0)
            ->where('tanggalBerkunjung >=', date('Y-m-d'))
            ->get()
            ->getResultArray();
    }

    public function diwakilkan($ditemui)
    {
        return $this->db->table('tamu')
            ->where('statusTamu', 0)
            ->where('tanggalBerkunjung', date('Y-m-d'))
            ->where('diwakilkan', $ditemui)
            ->get()
            ->getResultArray();
    }

    // ================= CHART =================
    public function chartBulanan($bulan)
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('YEAR(tanggalBerkunjung)', date('Y'))
            ->where('MONTH(tanggalBerkunjung)', $bulan)
            ->where('statusTamu', 1)
            ->get()
            ->getRowArray();
    }

    public function statusTamu($id)
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('YEAR(tanggalBerkunjung)', date('Y'))
            ->where('MONTH(tanggalBerkunjung)', date('m'))
            ->where('statusTamu', $id)
            ->get()
            ->getRowArray();
    }

    // ================= COUNT =================
    public function banyakTamuBaru($ditemui)
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('statusTamu', 0)
            ->where('tanggalBerkunjung >=', date('Y-m-d'))
            ->where('ditemui', $ditemui)
            ->get()
            ->getRowArray();
    }

    public function banyakTamuBaruAll()
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('statusTamu', 0)
            ->where('tanggalBerkunjung >=', date('Y-m-d'))
            ->get()
            ->getRowArray();
    }

    public function banyakTamuDiwakilkan($ditemui)
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('statusTamu', 0)
            ->where('tanggalBerkunjung', date('Y-m-d'))
            ->where('diwakilkan', $ditemui)
            ->get()
            ->getRowArray();
    }

    public function tamuHariIni($status)
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('tanggalBerkunjung', date('Y-m-d'))
            ->where('statusTamu', $status)
            ->get()
            ->getRowArray();
    }

    public function tamuHariIniBaru()
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('tanggalBerkunjung', date('Y-m-d'))
            ->get()
            ->getRowArray();
    }

    public function BanyakTamuHariIni()
    {
        return $this->db->table('tamu')
            ->where('tanggalBerkunjung', date('Y-m-d'))
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function BanyakTamuTahunIni()
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('YEAR(tanggalBerkunjung)', date('Y'))
            ->get()
            ->getRowArray();
    }

    public function BanyakTamuBulanIni()
    {
        return $this->db->table('tamu')
            ->select('COUNT(*) as total')
            ->where('MONTH(tanggalBerkunjung)', date('m'))
            ->get()
            ->getRowArray();
    }

    public function banyakRole($id)
    {
        return $this->db->table('user')
            ->select('COUNT(*) as total')
            ->where('role_id', $id)
            ->get()
            ->getRowArray();
    }

    // ================= USER =================
    public function usersMAs()
    {
        return $this->db->table('user')
            ->select('user.*, user_role.role, user_role.icon, user_role.color')
            ->join('user_role', 'user.role_id = user_role.id')
            ->get()
            ->getResultArray();
    }

    // ================= SURVEY =================
    public function kepuasanSurvey()
    {
        return $this->db->table('testimonies_detail')
            ->select("
                COUNT(CASE WHEN kepuasan = 1 THEN 1 END) AS sangat_puas,
                COUNT(CASE WHEN kepuasan = 2 THEN 1 END) AS puas,
                COUNT(CASE WHEN kepuasan = 3 THEN 1 END) AS cukup,
                COUNT(CASE WHEN kepuasan = 4 THEN 1 END) AS kurang
            ")
            ->get()
            ->getRowArray();
    }

    public function get_survey_by_year($year)
    {
        return $this->db->table('testimonies_detail')
            ->select("
                COUNT(CASE WHEN kepuasan = 1 THEN 1 END) AS sangat_puas,
                COUNT(CASE WHEN kepuasan = 2 THEN 1 END) AS puas,
                COUNT(CASE WHEN kepuasan = 3 THEN 1 END) AS cukup,
                COUNT(CASE WHEN kepuasan = 4 THEN 1 END) AS kurang
            ")
            ->where('YEAR(tanggal)', $year)
            ->get()
            ->getRowArray();
    }
}