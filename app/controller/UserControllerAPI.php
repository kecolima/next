<?php

namespace app\controller;

use app\core\Controller;
use app\model\UserModelAPI;
use app\classes\Input;

class UserControllerAPI extends Controller
{
    //Instância da classe UserModel
    private $userModel;

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->userModel = new userModelAPI();
    }

    /**
     * Método para validar o JWT
     * 
     * @return bool
     */
    public function validarJWT()
    {  
        $http_header = apache_request_headers();
        $bearer = explode(' ',$http_header['Authorization']);

        $jwt = $bearer[1];
        $key = 'minha-chave';
        $part = explode(".",$jwt);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $valid = hash_hmac('sha256',"$header.$payload",$key,true);
        $valid = base64_encode($valid);

        if($signature == $valid){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function index()
    {                  
        $jwt = $this->validarJWT();

        if ($jwt) {
            $result = $this->userModel->getAll();
            echo json_encode($result);
        } else {
            echo json_encode('erro');
        }
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function getById()
    {   
        $jwt = $this->validarJWT();

        if($jwt){      
            $uri = $_SERVER['REQUEST_URI'];        
            $uri = explode('/',$uri);
            $user = end($uri); 
            $result = $this->userModel->getById($user);
            echo json_encode($result);
            die();
        }else {
            echo json_encode('erro');
            die();
        }
    }
    
    /**
     * Realiza a inserção na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function insert()
    {           
        $jwt = $this->validarJWT();

        if($jwt){  
            $body = file_get_contents('php://input');
            $jsonBody = json_decode($body, true);
            $parametros = $jsonBody;
            $user = $this->getInput($parametros);
    
            $result = $this->userModel->insert($user);
            if ($result <= 0) {
                echo json_encode('Erro ao cadastrar um novo user');
                die();
            } else {
                echo json_encode('sucess');
            }
        } else {
            echo json_encode('erro');
            die();
        } 
    }
    
    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function update()
    {   
        $jwt = $this->validarJWT();  
       
        if($jwt){  
            $body = file_get_contents('php://input');
            $jsonBody = json_decode($body, true);
            $parametros = $jsonBody; 
            $user = $this->getInput($parametros);                   
            $result = $this->userModel->update($user);            
            if ($result <= 0) {
                echo json_encode('erro');
                die();
            }
            echo json_encode('success');
        }else {
            echo json_encode('erro');
        }
    }

    /**
     * Realiza a deleção na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function delete()
    {            
        $jwt = $this->validarJWT();

        if($jwt){      
            $uri = $_SERVER['REQUEST_URI'];        
            $uri = explode('/',$uri);
            $user = end($uri); 
            $result = $this->userModel->delete($user); 
            
            if ($result->id != '') {
                echo json_encode('erro');
                die();
            } else {
                echo json_encode('success');
            }            
        }else {
            echo json_encode('erro');
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
            'id'        => $param['id'],
            'email'     => $param['email'],
            'senha'     => $param['senha'],
            'nome'      => $param['nome'],
        ];
    }

    /**
     * Valida se os campos recebidos estão válidos
     *
     * @param  Object $user
     * @param  bool $validateId
     * @return bool
     */
    private function validate(Object $user, bool $validateId = true)
    {
        if ($validateId && $user->id <= 0)
            return false;

        if (strlen($user->nome) < 3)
            return false;

        if (strlen($user->email) < 5)
            return false;

        if (strlen($user->senha) < 6)
            return false;

        return true;
    }
}
