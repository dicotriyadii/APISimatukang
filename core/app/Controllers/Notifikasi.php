<?php
 
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Model_notifikasi;
use App\Models\Model_log;
use App\Models\Model_data;

class Notifikasi extends BaseController
{
    use ResponseTrait;
    public function index()
    {           
        $modelData  = new Model_data();
        $data = $modelData->getNotifikasi();
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil !!",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function show($id=null)
    {           
        $modelData  = new Model_data();
        $data = $modelData->getNotifikasiDetail($id);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil !!",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function status($id=null)
    {           
        $modelData      = new Model_data();
        $log            = new Model_log();
        $notifikasi     = new Model_notifikasi();
        $data = [
            'status'     => 1,
        ];
        $notifikasi->update($id,$data);
        $dataLog = [
            'username'      => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Merubah Status Notifikasi"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil merubah status notifikasi",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
}