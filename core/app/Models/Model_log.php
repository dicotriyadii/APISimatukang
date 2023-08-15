<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_log extends Model
{
    protected $table                = 'tbl_log';
    protected $primaryKey           = 'idLog';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nomorTelepon','waktu','keterangan'];
}