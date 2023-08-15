<?php
 
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Model_artikel;
use App\Models\Model_log;
use App\Models\Model_data;

class Artikel extends BaseController
{
    use ResponseTrait;
    public function index()
    {           
        $modelData  = new Model_data();
        $data = $modelData->getArtikel();
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
        $data = $modelData->getArtikelDetail($id);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil !!",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function create()
    {           
        $modelData      = new Model_data();
        $log            = new Model_log();
        $artikel        = new Model_artikel();
        $judulArtikel   = $this->request->getVar('judulArtikel');
        $keterangan     = $this->request->getVar('keterangan');
        $gambar         = $this->request->getFile('gambar');
        $pathGambar     = "artikel_".rand(0,9999).".jpg";
        $cekArtikel     = $modelData->cekArtikel($judulArtikel);
        if($cekArtikel != null){
            $dataLog = [
                'username'      => "Admin",
                'waktu'         => date('Y-m-d H:i:s'),
                'keterangan'    => "Gagal Tambah Artikel, karena judul artikel sudah ada"
            ];
            $log->insert($dataLog);
            $response= [
                'status'    => 400,
                'messages'  => "Gagal Tambah artikel, karena judul artikel sudah ada",
            ];              
            return $this->respond($response,400);   
        }
        $data = [
            'judulArtikel'  => $judulArtikel,
            'keterangan'    => $keterangan, 
            'gambar'        => $pathGambar,
        ];
        $artikel->insert($data);
        $gambar->move('artikel/',$pathGambar);
        $dataLog = [
            'username'      => "Admin",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Membuat Artikel"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil upload artikel",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function edit($id=null)
    {           
        $modelData      = new Model_data();
        $log            = new Model_log();
        $artikel        = new Model_artikel();
        $judulArtikel   = $this->request->getVar('judulArtikel');
        $keterangan     = $this->request->getVar('keterangan');
        $data = [
            'judulArtikel'  => $judulArtikel,
            'keterangan'    => $keterangan, 
        ];
        $artikel->update($id,$data);
        $dataLog = [
            'username'      => "Admin",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Merubah Artikel"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil merubah artikel",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function delete($id=null)
    {           
        $modelData      = new Model_data();
        $log            = new Model_log();
        $artikel        = new Model_artikel();
        $artikel->delete($id);
        $dataLog = [
            'username'      => "admin",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan penghapusan artikel"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil menghapus artikel",
        ];  
        return $this->respond($response,200);   
    }
}