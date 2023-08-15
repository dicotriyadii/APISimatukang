<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_keuangan extends Model
{
    protected $table                = 'tbl_keuangan';
    protected $primaryKey           = 'idKeuangan';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['idPermohonanPengguna','refrensiPembayaran','biaya','status'];
}