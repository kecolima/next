<?php

namespace app\controller;

use app\core\Controller;
use app\model\UserModel;
use app\classes\Input;

class AuthController extends Controller
{

    //Instância da classe EmpresaModel
    private $userModel;

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->userModel = new userModel();
    }

    /**
     * Método construtor
     *
     * @return String
     */
    public function login()
    {

        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);
        $parametros = $jsonBody; 
        $user = $this->getInput($parametros); 

        $result = $this->userModel->getValidarUser($user);

        $host = 'localhost';        
        $email = $parametros['email'];
        $senha = $parametros['senha']; 

        if ($result == 1) {
        
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];
            $header = json_encode($header);
            $header = base64_encode($header);
            
            $payload = [
                'iss' => 'localhost',
                'email' => $email
            ];

            $payload = json_encode($payload);
            $payload = base64_encode($payload);
            
            $signature = hash_hmac('sha256',"$header.$payload",'minha-chave',true);
            $signature = base64_encode($signature);
            
            $token = "$header.$payload.$signature";

            echo $token;

        } else {

            echo 'Não autenticado';

        }
        
    }
    
    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
    */
    private function getInput($param)
    {
        return (object)[
            'email'    => $param['email'],
            'senha'    => $param['senha'],
        ];
    }
}
