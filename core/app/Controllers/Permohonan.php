<?php
 
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Model_permohonan;
use App\Models\Model_keuangan;
use App\Models\Model_log;
use App\Models\Model_data;

class Permohonan extends BaseController
{
    use ResponseTrait;
    public function index()
    {           
        $modelData  = new Model_data();
        $data = $modelData->getPermohonan();
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
        $data = $modelData->getPermohonanById($id);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil !!",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function create()
    {           
        $modelData              = new Model_data();
        $log                    = new Model_log();
        $permohonan             = new Model_permohonan();
        $keuangan               = new Model_keuangan();
        $nomorTeleponPengguna   = $this->request->getVar('nomorTeleponPengguna');
        $jenisPermohonan        = $this->request->getVar('jenisPermohonan');
        $jumlahTukang           = $this->request->getVar('jumlahTukang');
        $keluhan                = $this->request->getVar('keluhan');
        $jadwal                 = $this->request->getVar('jadwal');
        $alamat                 = $this->request->getVar('alamat');
        $gambar1                = $this->request->getFile('gambar1');
        $gambar2                = $this->request->getFile('gambar2');
        $gambar3                = $this->request->getFile('gambar3');
        $pathGambar1            = "keluhan_".rand(0,9999).".jpg";
        $pathGambar2            = "keluhan_".rand(0,9999).".jpg";
        $pathGambar3            = "keluhan_".rand(0,9999).".jpg";
        $cekStatusPermohonan    = $modelData->cekStatusPermohonan($nomorTeleponPengguna);
        if($cekStatusPermohonan != null){
            $dataLog = [
                'nomorTelepon'  => $nomorTeleponPengguna,
                'waktu'         => date('Y-m-d H:i:s'),
                'keterangan'    => "Sudah melakukan permohonan, tetapi belum selesai"
            ];
            $log->insert($dataLog);
            $response= [
                'status'    => 400,
                'messages'  => "Mohon maaf, untuk saat ini permohonan anda sedang di proses, silahkan cek secara berkala"
            ];  
            return $this->respond($response,400);   
        } 
        $data = [
            'nomorTeleponPengguna'  => $nomorTeleponPengguna,
            'jenisPermohonan'       => $jenisPermohonan,
            'jumlahTukang'          => $jumlahTukang, 
            'keluhan'               => $keluhan,
            'jadwal'                => $jadwal,
            'alamat'                => $alamat,
            'status'                => 0,
            'gambar1'               => $pathGambar1,
            'gambar2'               => $pathGambar2,
            'gambar3'               => $pathGambar3
        ];
        $permohonan->insert($data);
        $gambar1->move('permohonan/',$pathGambar1);
        $gambar2->move('permohonan/',$pathGambar2);
        $gambar3->move('permohonan/',$pathGambar3);
        // Proses Pembuatan Pembayaran 
        $cekStatusPermohonan    = $modelData->cekStatusPermohonan($nomorTeleponPengguna);
        $cekBiaya               = $modelData->getDetailMasterPermohonan($jenisPermohonan);
        $biayaJasa              = $cekBiaya[0]['biaya'] * $jumlahTukang;
        $dataPembayaran = [
            'idPermohonanPengguna'  => $cekStatusPermohonan[0]['idPermohonan'],
            'refrensiPembayaran'    => 0,
            'biaya'                 => $biayaJasa,
            'status'                => 0
        ];
        $keuangan->insert($dataPembayaran);
        $dataLog = [
            'nomorTelepon'  => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan permohonan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil menyampaikan permohonan",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function delete($id=null)
    {           
        $log            = new Model_log();
        $permohonan     = new Model_permohonan();
        $permohonan->delete($id);
        $dataLog = [
            'nomorTelepon'  => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan Penghapusan permohonan"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil Menghapus permohonan",
        ];  
        return $this->respond($response,200);   
    }
}