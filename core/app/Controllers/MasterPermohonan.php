<?php
 
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Model_master_permohonan;
use App\Models\Model_log;
use App\Models\Model_data;

class MasterPermohonan extends BaseController
{
    use ResponseTrait;
    public function index()
    {           
        $modelData  = new Model_data();
        $data = $modelData->getMasterPermohonan();
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil !!",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function create()
    {           
        $modelData          = new Model_data();
        $log                = new Model_log();
        $masterPermohonan   = new Model_master_permohonan();
        $jenisPermohonan    = $this->request->getVar('jenisPermohonan');
        $biaya              = $this->request->getVar('biaya');
        $cekJenisPermohonan = $modelData->cekJenisPermohonan($jenisPermohonan);
        if($cekJenisPermohonan != null){
            $dataLog = [
                'username'      => "Admin",
                'waktu'         => date('Y-m-d H:i:s'),
                'keterangan'    => "Gagal Tambah Master Permohonan, karena jenis permohonan sudah ada"
            ];
            $log->insert($dataLog);
            $response= [
                'status'    => 400,
                'messages'  => "Gagal Tambah Master Permohonan, karena jenis permohonan sudah ada",
            ];              
            return $this->respond($response,400);   
        }
        $data = [
            'jenisPermohonan'   => $jenisPermohonan,
            'biaya'             => $biaya, 
        ];
        $masterPermohonan->insert($data);
        $dataLog = [
            'username'      => "Admin",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Menambah Master Permohonan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil Tambah Master Permohonan",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function delete($id=null)
    {           
        $log                = new Model_log();
        $masterPermohonan   = new Model_master_permohonan();
        $masterPermohonan->delete($id);
        $dataLog = [
            'username'      => "admin",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan penghapusan master permohonan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil menghapus master permohonan",
        ];  
        return $this->respond($response,200);   
    }
}