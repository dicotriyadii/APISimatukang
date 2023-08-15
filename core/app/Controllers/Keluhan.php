<?php
 
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Model_keluhan;
use App\Models\Model_pengguna;
use App\Models\Model_notifikasi;
use App\Models\Model_log;
use App\Models\Model_data;

class Keluhan extends BaseController
{
    use ResponseTrait;
    public function index()
    {           
        $modelData  = new Model_data();
        $data = $modelData->getKeluhan();
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil !!",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function show($nomorTelepon=null)
    {           
        $modelData  = new Model_data();
        $data = $modelData->getKeluhanByNomorTelepon($nomorTelepon);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil !!",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function create()
    {           
        $modelData         = new Model_data();
        $log               = new Model_log();
        $modelKeluhan      = new Model_keluhan();
        $modelPengguna     = new Model_pengguna();
        $nomorTelepon      = $this->request->getVar('nomorTelepon');
        $nama              = $this->request->getVar('nama');
        $keluhan           = $this->request->getVar('keluhan');
        $gambar1           = $this->request->getFile('gambar1');
        $gambar2           = $this->request->getFile('gambar2');
        $gambar3           = $this->request->getFile('gambar3');
        $pathGambar1       = "keluhan_".rand(0,9999).".jpg";
        $pathGambar2       = "keluhan_".rand(0,9999).".jpg";
        $pathGambar3       = "keluhan_".rand(0,9999).".jpg";
        $cekStatusKeluhan  = $modelData->cekStatusKeluhan($nomorTelepon);
        $statusPengguna    = $modelData->cekNomorTelepon($nomorTelepon);
        if($statusPengguna == null){
            $hashPassword   = [
                'cost' => 10,
            ];
            $data = [
                'nama'          => $nama,
                'nomorTelepon'  => $nomorTelepon, 
                'password'      => password_hash($nomorTelepon,PASSWORD_DEFAULT,$hashPassword),
                'role'          => 'pengguna',
                'status'        => 0,
            ];
            $modelPengguna->insert($data);
        }
        if($cekStatusKeluhan  != null){
            $dataLog = [
                'nomorTelepon'  => $nomorTelepon,
                'waktu'         => date('Y-m-d H:i:s'),
                'keterangan'    => "Sudah melakukan keluhan, tetapi belum selesai"
            ];
            $log->insert($dataLog);
            $response= [
                'status'    => 400,
                'messages'  => "Mohon maaf, untuk saat ini keluhan anda sedang di proses, silahkan cek secara berkala"
            ];  
            return $this->respond($response,400);   
        } 
        $data = [
            'namaPengguna'         => $nama,
            'nomorTeleponPengguna' => $nomorTelepon, 
            'keluhan'              => $keluhan,
            'gambar1'              => $pathGambar1,
            'gambar2'              => $pathGambar2,
            'gambar3'              => $pathGambar3,
            'respon'               => "kosong",
            'status'               => 0
        ];
        $modelKeluhan->insert($data);
        $gambar1->move('keluhan/',$pathGambar1);
        $gambar2->move('keluhan/',$pathGambar2);
        $gambar3->move('keluhan/',$pathGambar3);
        $dataLog = [
            'nomorTelepon'  => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan keluhan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil menyampaikan keluhan",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function edit($id=null)
    {           
        $modelData         = new Model_data();
        $log               = new Model_log();
        $modelKeluhan      = new Model_keluhan();
        $keluhan           = $this->request->getVar('keluhan');
        $data = [
            'keluhan'              => $keluhan,
        ];
        $modelKeluhan->update($id,$data);
        $dataLog = [
            'nomorTelepon'  => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan perubahan keluhan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil merubah keluhan",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function responKeluhan($id=null)
    {           
        $modelData              = new Model_data();
        $log                    = new Model_log();
        $keluhan                = new Model_keluhan();
        $notifikasi             = new Model_notifikasi();
        $responKeluhan          = $this->request->getVar('responKeluhan');
        $keteranganNotifikasi   = $this->request->getVar('keteranganNotifikasi');
        $cekDataKeluhan         = $modelData->getKeluhanById($id);
        $data = [
            'respon'     => $responKeluhan,
        ];
        $keluhan->update($id,$data);
        $dataNotifikasi = [
            'nomorTeleponPengguna'  => $cekDataKeluhan[0]['nomorTeleponPengguna'],
            'keterangan'            => $keteranganNotifikasi,
        ];
        $notifikasi->insert($dataNotifikasi);
        $dataLog = [
            'nomorTelepon'  => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan Respon keluhan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil Merespon keluhan",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function delete($id=null)
    {           
        $log            = new Model_log();
        $keluhan        = new Model_keluhan();
        $keluhan->delete($id);
        $dataLog = [
            'nomorTelepon'  => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan Penghapusan keluhan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil Menghapus keluhan",
        ];  
        return $this->respond($response,200);   
    }
}