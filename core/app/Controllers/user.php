<?php
 
namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Model_pengguna;
use App\Models\Model_log;
use App\Models\Model_data;

class User extends BaseController
{
    use ResponseTrait;
    public function index()
    {           
        $modelData  = new Model_data();
        $data = $modelData->getPengguna();
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
        $data = $modelData->getPenggunaDetailByNomorTelepon($nomorTelepon);
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
        $pengguna       = new Model_pengguna();
        $nomorTelepon   = $this->request->getVar('nomorTelepon');
        $password       = $this->request->getVar('password');
        $role           = $this->request->getVar('role');
        $hashPassword   = [
            'cost' => 10,
        ];
        $ceknomorTeleponTersedia    = $modelData->ceknomorTelepon($nomorTelepon);
        if($ceknomorTeleponTersedia != null){
            $dataLog = [
                'nomorTelepon'  => $nomorTelepon,
                'waktu'         => date('Y-m-d H:i:s'),
                'keterangan'    => "Tidak bisa melakukan penambahan user dikarenakan nomor telepon sudah tersedia"
            ];    
            $log->insert($dataLog);
            $response = [
                'status'    => 400,
                'messages'  => "Mohon Maaf, nomor telepon sudah tersedia",
            ];  
            return $this->respond($response,400);   
        }
        $data = [
            'nomorTelepon'  => $nomorTelepon,
            'password'  => password_hash($password,PASSWORD_DEFAULT,$hashPassword),
            'role'      => $role, 
            'status'    => 0,
        ];
        $pengguna->insert($data);
        $dataLog = [
            'nomorTelepon'      => "pengguna",
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan pendaftaran user"
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil melakukan pendaftaran",
            'data'      => $data
        ];  
        return $this->respond($response,200);   
    }
    public function gantiPassword($nomorTelepon=null)
    {           
        $modelData      = new Model_data();
        $log            = new Model_log();
        $pengguna       = new Model_pengguna();
        $passwordLama   = $this->request->getVar('passwordLama');
        $passwordBaru   = $this->request->getVar('passwordBaru');
        $hashPassword   = [
            'cost' => 10
        ];
        $cekUser         = $modelData->cekNomorTelepon($nomorTelepon);
        $cekPasswordLama = password_verify($passwordLama,$cekUser[0]['password']);
        if($cekPasswordLama != true){
            $dataLog = [
                'nomorTelepon'      => $nomorTelepon,
                'waktu'         => date('Y-m-d H:i:s'),
                'keterangan'    => "Gagal melakukan perubahan password dikarenakan password sebelum nya salah"
            ];
            $log->insert($dataLog);
            $response= [
                'status'    => 400,
                'messages'  => "Gagal merubah password, password lama salah !!",
            ];  
            return $this->respond($response,400);    
        }
        $data = [
            'password' => password_hash($passwordBaru,PASSWORD_DEFAULT,$hashPassword) 
        ];
        $pengguna->update($cekUser[0]['idPengguna'],$data);
        $dataLog = [
            'nomorTelepon'  => $nomorTelepon,
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => $nomorTelepon . " Melakukan perubahan password terhadap user ". $cekUser[0]['nomorTelepon']
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil merubah password",
            'data'      => [
                            'password' => $passwordBaru
                    ]
        ];  
        return $this->respond($response,200);   
    }
    public function delete($nomorTelepon=null)
    {           
        $modelData          = new Model_data();
        $log                = new Model_log();
        $pengguna           = new Model_pengguna();
        $datapengguna       = $modelData->cekNomorTelepon($nomorTelepon);
        $pengguna->delete($datapengguna[0]['idPengguna']);
        $dataLog = [
            'nomorTelepon'  => $nomorTelepon,
            'waktu'         => date('Y-m-d H:i:s'),
            'keterangan'    => "Melakukan penghapusan akun nomorTelepon : ". $datapengguna[0]['nomorTelepon']
        ];
        $log->insert($dataLog);
        $response= [
            'status'    => 200,
            'messages'  => "Berhasil menghapus user",
        ];  
        return $this->respond($response,200);   
    }
}