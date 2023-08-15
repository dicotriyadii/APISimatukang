<?php
 
namespace App\Controllers;
 
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Model_pengguna;
use App\Models\Model_log;
use App\Models\Model_data;
use \Firebase\JWT\JWT;
 
class Login extends BaseController
{
    use ResponseTrait;
    public function create()
    {
        $session            = session();
        $pengguna           = new Model_pengguna();
        $modelData          = new Model_data();
        $log                = new Model_log();
        $nomorTelepon       = $this->request->getVar('nomorTelepon');
        $password           = $this->request->getVar('password');
        $cekNomorTelepon    = $modelData->cekNomorTelepon($nomorTelepon);
        if($cekNomorTelepon == null){
            $dataLog = [
                'nomorTelepon'  => "Tidak Diketahui",
                'waktu'         => date('Y-m-d H:i:s'),
                'keterangan'    => "Ada percobaan gagal login dengan nomor telepon yang tidak diketahui"
            ];
            $log->insert($dataLog);
            $response= [
                'status'    => 400,
                'messages'  => "nomor telepon tidak terdaftar"
            ];  
            return $this->respond($response,400);      
        }else {
            $cekPassword = password_verify($password,$cekNomorTelepon[0]['password']);
            if($cekPassword == true){
                $dataLog = [
                    'nomorTelepon'  => $nomorTelepon,
                    'waktu'         => date('Y-m-d H:i:s'),
                    'keterangan'    => "Login Berhasil"
                ];
                $log->insert($dataLog);
                // Proses JWT
                $key = getenv('JWT_SECRET');
                $iat = time(); // current timestamp value
                $exp = $iat + 86400;
                $payload = array(
                    "iss"       => "Issuer of the JWT",
                    "aud"       => "Audience that the JWT",
                    "sub"       => "Subject of the JWT",
                    "iat"       => $iat, //Time the JWT issued at
                    "exp"       => $exp, // Expiration time of token
                    "nomorTelepon"  => $nomorTelepon,
                ); 
                $token = JWT::encode($payload, $key, 'HS256');
                $response= [
                    'status'    => 200,
                    'messages'  => "Login Berhasil",
                    'data'      => [
                                    'nomorTelepon'  => $nomorTelepon,
                                    'role'      => $cekNomorTelepon[0]['role'],
                                    'token'     => $token,
                                ]
                ];  
                return $this->respond($response,200);   
            }else{
                $dataLog = [
                    'nomorTelepon'  => $nomorTelepon,
                    'waktu'         => date('Y-m-d H:i:s'),
                    'keterangan'    => "Gagal Login, dikarenakan salah password"
                ];
                $log->insert($dataLog);
                $response = [
                    'status'    => 400,
                    'messages'  => "Password yang dimasukkan salah"
                ];  
                return $this->respond($response,400);   
            }
        }



    }
 
}