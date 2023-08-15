<?php
 
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Model_keuangan;
use App\Models\Model_permohonan;
use App\Models\Model_log;
use App\Models\Model_data;

class Pembayaran extends BaseController
{
    use ResponseTrait;
    public function show($idPermohonan=null)
    {           
        $modelData  = new Model_data();
        $data = $modelData->getPembayaranDetail($idPermohonan);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil !!",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function validasiPembayaran($idPermohonan=null)
    {           
        $log                = new Model_log();
        $modelData          = new Model_data();
        $permohonan         = new Model_permohonan();
        $keuangan           = new Model_keuangan();
        $refensiPembayaran  = $this->request->getVar('refrensiPembayaran');
        $dataPembayaran = $modelData->getPembayaranDetail($idPermohonan);
        $dataPermohonan = [
            'status'     => 1,
        ];
        $permohonan->update($idPermohonan,$dataPermohonan);
        $dataKeuangan = [
            'status'             => 1,
            'refrensiPembayaran' => $refensiPembayaran
        ];
        $keuangan->update($dataPembayaran[0]['idKeuangan'],$dataKeuangan);
        $dataLog = [
            'username'      => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Merubah Status Pembayaran dan Permohonan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil merubah status pembayaran dan permohonan",
        ];  
        return $this->respond($response,200);   
    }
}