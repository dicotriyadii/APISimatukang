<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_data extends Model
{
    public function cekNomorTelepon($nomorTelepon=null)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_pengguna');
        $builder->select('*');
        $builder->where('nomorTelepon',$nomorTelepon);
        return $builder->get()->getResultArray();
    }
    public function getPengguna()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_pengguna');
        $builder->select('*');
        return $builder->get()->getResultArray();
    }
    public function getPermohonan()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_permohonan');
        $builder->select('*');
        $builder->join('tbl_pengguna', 'tbl_pengguna.nomorTelepon = tbl_permohonan.nomorTeleponPengguna');
        return $builder->get()->getResultArray();
    }
    public function getPermohonanByNomorTelepon($nomorTelepon)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_permohonan');
        $builder->select('*');
        $builder->where('nomorTeleponPengguna',$nomorTelepon);
        $builder->join('tbl_pengguna', 'tbl_pengguna.nomorTelepon = tbl_permohonan.nomorTeleponPengguna');
        return $builder->get()->getResultArray();
    }
    public function getPenggunaDetailByNomorTelepon($nomorTelepon)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_pengguna');
        $builder->select('*');
        $builder->where('nomorTelepon',$nomorTelepon);
        return $builder->get()->getResultArray();
    }
    public function getKeluhanByNomorTelepon($nomorTelepon)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_keluhan');
        $builder->select('*');
        $builder->where('nomorTeleponPengguna',$nomorTelepon);
        return $builder->get()->getResultArray();
    }
    public function getKeluhanById($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_keluhan');
        $builder->select('*');
        $builder->where('idKeluhan',$id);
        return $builder->get()->getResultArray();
    }
    public function getPermohonanById($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_permohonan');
        $builder->select('*');
        $builder->where('idPermohonan',$id);
        return $builder->get()->getResultArray();
    }
    public function getKeluhan()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_keluhan');
        $builder->select('*');
        return $builder->get()->getResultArray();
    }
    public function cekStatusKeluhan($nomorTelepon)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_keluhan');
        $builder->select('*');
        $builder->where('nomorTeleponPengguna',$nomorTelepon);
        $builder->where('status',0);
        return $builder->get()->getResultArray();
    }
    public function cekStatusPermohonan($nomorTelepon)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_permohonan');
        $builder->select('*');
        $builder->where('nomorTeleponPengguna',$nomorTelepon);
        $builder->where('status',0);
        return $builder->get()->getResultArray();
    }
    public function getNotifikasi()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_notifikasi');
        $builder->select('*');
        return $builder->get()->getResultArray();
    }
    public function getNotifikasiDetail($notifikasi)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_notifikasi');
        $builder->select('*');
        $builder->where('idNotifikasi',$notifikasi);
        return $builder->get()->getResultArray();
    }
    public function getArtikel()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_artikel');
        $builder->select('*');
        return $builder->get()->getResultArray();
    }
    public function getArtikelDetail($idArtikel)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_artikel');
        $builder->select('*');
        $builder->where('idArtikel',$idArtikel);
        return $builder->get()->getResultArray();
    }
    public function cekArtikel($judulArtikel)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_artikel');
        $builder->select('*');
        $builder->where('judulArtikel',$judulArtikel);
        return $builder->get()->getResultArray();
    }
    public function getDetailMasterPermohonan($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_master_permohonan');
        $builder->select('*');
        $builder->where('idJenisPermohonan',$id);
        return $builder->get()->getResultArray();
    }
    public function getPembayaranDetail($idPermohonan)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_keuangan');
        $builder->select('*');
        $builder->where('idPermohonan',$idPermohonan);
        $builder->join('tbl_permohonan', 'tbl_permohonan.idPermohonan = tbl_keuangan.idPermohonanPengguna');
        return $builder->get()->getResultArray();
    }
    public function getMasterPermohonan()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_master_permohonan');
        $builder->select('*');
        return $builder->get()->getResultArray();
    }
    public function cekJenisPermohonan($jenisPermohoan)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_master_permohonan');
        $builder->select('*');
        $builder->where('jenisPermohonan',$jenisPermohoan);
        return $builder->get()->getResultArray();
    }
}