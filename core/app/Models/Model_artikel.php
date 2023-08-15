<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_artikel extends Model
{
    protected $table                = 'tbl_artikel';
    protected $primaryKey           = 'idArtikel';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['judulArtikel','keterangan','gambar'];
}