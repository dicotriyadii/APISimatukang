<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_notifikasi extends Model
{
    protected $table                = 'tbl_notifikasi';
    protected $primaryKey           = 'idNotifikasi';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nomorTeleponPengguna','keterangan','status'];
}