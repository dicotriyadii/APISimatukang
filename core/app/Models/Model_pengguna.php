<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_pengguna extends Model
{
    protected $table                = 'tbl_pengguna';
    protected $primaryKey           = 'idPengguna';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nama','nomorTelepon','password','role','status'];
}