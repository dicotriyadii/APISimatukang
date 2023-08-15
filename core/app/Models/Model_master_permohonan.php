<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Model_master_permohonan extends Model
{
    protected $table                = 'tbl_master_permohonan';
    protected $primaryKey           = 'idJenisPermohonan';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nama','jenisPermohonan','biaya'];
}