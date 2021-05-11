<?php

namespace app\controller;

use app\core\Controller;
use app\model\EmpresaModelAPI;
use app\classes\Input;

class EmpresaControllerAPI extends Controller
{

    //Instância da classe EmpresaModel
    private $empresaModel;

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->empresaModel = new empresaModelAPI();
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
            $result = $this->empresaModel->getAll();
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
            $empresa = end($uri); 
            $result = $this->empresaModel->getById($empresa);
            echo json_encode($result);
            die();
        } else {
            echo json_encode('erro');
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
            $empresa = $this->getInput($parametros);
            $result = $this->empresaModel->insert($empresa);
            if ($result <= 0) {
                echo json_encode('Erro ao cadastrar um novo empresa');
                die();
            } else {
                echo json_encode('success');
            }
        } else {
            echo json_encode('erro');
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
            $empresa = $this->getInput($parametros);           
            $result = $this->empresaModel->update($empresa);            
            if ($result <= 0) {
                echo json_encode('Erro ao cadastrar um novo empresa');
                die();
            } else {
                echo json_encode('success');
            }
        } else {
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
            $empresa = end($uri); 
            $result = $this->empresaModel->delete($empresa);             
            if ($result->id != '') {
                echo json_encode('erro');
                die();
            } else {
                echo json_encode('success');
            }            
        } else {
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
            'id'          => $param['id'],
            'id_usuario'  => $param['id_usuario'],
            'nome'        => $param['nome']
        ];
    }

    /**
     * Valida se os campos recebidos estão válidos
     *
     * @param  Object $empresa
     * @param  bool $validateId
     * @return bool
     */
    private function validate(Object $empresa, bool $validateId = true)
    {
        if ($validateId && $empresa->id <= 0)
            return false;

        if (strlen($empresa->nome) < 3)
            return false;

        if (strlen($empresa->email) < 5)
            return false;

        if (strlen($empresa->senha) < 6)
            return false;

        return true;
    }
}
