<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_keluhan extends Model
{
    protected $table                = 'tbl_keluhan';
    protected $primaryKey           = 'idKeluhan';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['namaPengguna','nomorTeleponPengguna','keluhan','gambar1','respon','status'];
}