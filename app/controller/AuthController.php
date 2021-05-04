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
        //dd($parametros);
        $user = $this->getInput($parametros); 

        $result = $this->userModel->getValidarUser($user);

        //dd($result);
        
        if ($result == 1) {
        
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT'
            ];
            $header = json_encode($header);
            $header = base64_encode($header);
            
            $payload = [
                'iss' => 'localhost',
                'name' => 'Diogo',
                'email' => 'diogo.fragabemfica@gmail.com'
            ];

            $payload = json_encode($payload);
            $payload = base64_encode($payload);
            
            $signature = hash_hmac('sha256',"$header.$payload",'minha-senha',true);
            $signature = base64_encode($signature);
            
            $token = "$header.$payload.$signature";

           echo $token;
        } 

        throw new \Exception('Não autenticado');
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function index()
    {
        echo 'teste';        
    }

    /**
     * Carrega a página com o formulário para cadastrar um novo empresa
     *
     * @return void
     */
    public function novo()
    {   
        $result = $this->empresaModel->getUsers(); 
        $this->load('empresa/novo', array('users' => $result));
    }

    public function insert()
    {
        $empresa = $this->getInput(); 
        
        /*
        if (!$this->validate($empresa, false)) {
            return  $this->showMessage(
                'Formulário inválido', 
                'Os dados fornecidos são inválidos',
                BASE  . 'novo-empresa/',
                422
            );
        }
        */

        $result_empresa = $this->empresaModel->getValidarEmpresa($empresa);       

        if ($result_empresa <= 0) {
            echo 'Empresa já cadastrado';
            die();
        }

        $result = $this->empresaModel->insert($empresa);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo empresa';
            die();
        }

        redirect(BASE . 'editar-empresa/' . $result);
    }

    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function pesquisar()
    {
        $param = Input::get('pes');

        $this->load('empresa/novo', [
            'termo' => $param
        ]);
    }

    /**
     * Carrega a página com o formulário para cadastrar um novo empresa
     *
     * @return void
     */
    public function editar()
    {       
        $resultUsers = $this->empresaModel->getUsers(); 
        $uri = $_SERVER['REQUEST_URI'];        
        $uri = explode('/',$uri);
        $empresa_id = end($uri);    
        $result = $this->empresaModel->getById($empresa_id); 
        $this->load('empresa/editar', array('empresa' => $result, 'users' => $resultUsers));
    }

    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function update()
    {       
        $empresa = $this->getInput(); 
        //dd($empresa);
        $id = Input::post('id');
        //$empresa['id'] = $empresa_id;
        //$empresa['id'] = 1;
         
        //dd($empresa);    
        /*
        if (!$this->validate($empresa, false)) {
            return  $this->showMessage(
                'Formulário inválido', 
                'Os dados fornecidos são inválidos',
                BASE  . 'novo-empresa/',
                422
            );
        }
        */
        $result = $this->empresaModel->update($empresa, $id);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo empresa';
            die();
        }

        redirect(BASE . 'editar-empresa/' . $id); 
    }

     /**
     * Carrega a página com o formulário para cadastrar um novo empresa
     *
     * @return void
     */
    public function excluir()
    {    
        $uri = $_SERVER['REQUEST_URI'];        
        $uri = explode('/',$uri);
        $id = end($uri);    
        $result = $this->empresaModel->getById($id); 
        $this->load('empresa/excluir', array('empresa' => $result));
    }

    /**
     * Deleta na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function delete()
    {
        $uri = $_SERVER['REQUEST_URI'];        
        $uri = explode('/',$uri);
        $empresa = end($uri); 

        $result = $this->empresaModel->delete($empresa);

        //dd($result);
       
        if ($result <= 0) {
            echo 'Erro ao deletar uma novo empresa';
            die();
        }

        redirect(BASE . 'empresa'); 
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
            'nome'     => $param['nome']
        ];
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function getEmpresas()
    {           
        $uri = $_SERVER['REQUEST_URI'];        
        $uri = explode('/',$uri);
        $user = end($uri);
        $empresa =$uri[ count($uri) - 2 ];         
        $result = $this->empresaModel->getEmpresas($empresa);
        $this->load('empresa/empresas', array('empresas' => $result, 'user' => $user));       
    }

    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function buscar()
    {        
        $param = $_GET['pes'];
        $result = $this->empresaModel->getEmpresa($param);
        $this->load('empresa/main', array('empresas' => $result));  
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
