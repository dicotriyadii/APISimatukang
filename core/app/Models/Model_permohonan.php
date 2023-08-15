<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_permohonan extends Model
{
    protected $table                = 'tbl_permohonan';
    protected $primaryKey           = 'idPermohonan';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nomorTeleponPengguna','idKeuanganPengguna','jenisPermohonan','jumlahTukang','keluhan','jadwal','alamat','status','gambar1','gambar2','gambar3'];
}