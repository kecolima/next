<?php

namespace app\controller;

use app\core\Controller;
use app\model\UserModel;
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
        $this->userModel = new userModel();
    }

    /**
     * Método para validar o JWT
     * 
     * @return bool
     */
    public function validarJWT(){

        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);
        $parametros = $jsonBody;        
        //dd($parametros);
        $token = $this->getInput($parametros);
        $token = $token->token;
        
        $part = explode(".",$token);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $valid = hash_hmac('sha256',"$header.$payload",'minha-senha',true);
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
        //dd($jwt);
        if ($jwt) {

            $result = $this->userModel->getAll();
            //return json_encode($result);
            echo json_encode($result);

        }
        
        echo json_encode('erro');
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

        }

        echo json_encode('erro');

    }
    
    public function insert()
    { 
        $jwt = $this->validarJWT();
        if($jwt){ 

            $body = file_get_contents('php://input');
            $jsonBody = json_decode($body, true);
            $parametros = $jsonBody; 

            //dd($parametros);

            $user = $this->getInput($parametros);
            
            $result = $this->userModel->insert($user);

            if ($result <= 0) {
                echo 'Erro ao cadastrar um novo user';
                die();
            }
        } else {
            echo json_encode('erro');
        }       
             
        /*
            if (!$this->validate($user, false)) {
                return  $this->showMessage(
                    'Formulário inválido', 
                    'Os dados fornecidos são inválidos',
                    BASE  . 'novo-user/',
                    422
                );
            }
        */       

        
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
            $user = $this->getInput();
            //$param['id'] = Input::get('id');
            $user = $this->getInput();
            dd($user);
            $this->load('user/editar', [
                'id' => user['id'],           
            ]); 
            
            $result = $this->userModel->update($user);

            if ($result <= 0) {
                echo 'Erro ao editar um novo user';
                die();
            }

            redirect(BASE . 'editar-user/' . $result);
        }

        echo json_encode('erro');
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
            'password'  => $param['senha'],
            'name'      => $param['name'],
            'data'      => $param['data'],
            'token'     => $param['token']
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
