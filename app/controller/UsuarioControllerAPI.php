<?php

namespace app\controller;

use app\core\Controller;
use app\model\UsuarioModelAPI;
use app\classes\Input;

class UsuarioControllerAPI extends Controller
{
    //Instância da classe UserModel
    private $usuarioModel;

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->usuarioModel = new usuarioModelAPI();
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
            $result = $this->usuarioModel->getAll();
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
            $usuario = end($uri); 
            $result = $this->usuarioModel->getById($usuario);
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
            $usuario = $this->getInput($parametros);
    
            $result = $this->usuarioModel->insert($usuario);
            if ($result <= 0) {
                echo json_encode('Erro ao cadastrar um novo usuario');
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
            $usuario = $this->getInput($parametros);                   
            $result = $this->usuarioModel->update($usuario);            
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
            $usuario = end($uri); 
            $result = $this->usuarioModel->delete($usuario); 
            
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
            'nome'      => $param['nome'],
            'senha'     => $param['senha'],
        ];
    }

    /**
     * Valida se os campos recebidos estão válidos
     *
     * @param  Object $usuario
     * @param  bool $validateId
     * @return bool
     */
    private function validate(Object $usuario, bool $validateId = true)
    {
        if ($validateId && $usuario->id <= 0)
            return false;

        if (strlen($usuario->nome) < 3)
            return false;

        if (strlen($usuario->email) < 5)
            return false;

        if (strlen($usuario->senha) < 6)
            return false;

        return true;
    }
}
