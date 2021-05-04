<?php

namespace app\controller;

use app\core\Controller;
use app\model\UserModel;
use app\classes\Input;

class UserController extends Controller
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
     * Carrega a página principal
     *
     * @return void
     */
    public function index()
    {
        $result = $this->userModel->getAll();          
        $this->load('user/main', array('users' => $result)); 
    }

    /**
     * Carrega a página com o formulário para cadastrar um novo User
     *
     * @return void
     */
    public function novo()
    {
        $this->load('user/novo');
    }

    /**
     * Carrega a página com o formulário para cadastrar um novo empresa
     *
     * @return void
     */
    public function editar()
    {    
        $uri = $_SERVER['REQUEST_URI'];        
        $uri = explode('/',$uri);
        $user_id = end($uri);    
        $result = $this->userModel->getById($user_id); 
        $this->load('user/editar', array('user' => $result));
    }

    public function insert()
    {
        $user = $this->getInput();
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
        
        $result_user = $this->userModel->getValidarUser($user);       

        if ($result_user <= 0) {
            echo 'Usuário já cadastrado';
            die();
        }

        $result = $this->userModel->insert($user);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo Usuário';
            die();
        }
        
        redirect(BASE . 'editar-user/' . $result);
    }

    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function pesquisar()
    {
        $param = Input::post('pes');
        dd($param);
        $this->load('user/novo', [
            'termo' => $param
        ]);
    }

    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function update()
    {
        $user = $this->getInput(); 
        $id = Input::post('id');   
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
        $result = $this->userModel->update($user,$id);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo empresa';
            die();
        }

        redirect(BASE . 'editar-user/' . $id);      
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {

        return (object)[
            'id'        => Input::get('id', FILTER_SANITIZE_NUMBER_INT),
            'nome'      => Input::post('txtNome'),
            'email'     => Input::post('txtEmail'),
            'senha'     => Input::post('txtSenha')
        ];
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
        $user = end($uri); 

        $result = $this->userModel->delete($user);        
       
        if ($result <= 0) {
            echo 'Erro ao deletar uma novo empresa';
            die();
        }

        redirect(BASE . 'user'); 
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
        $user_id = end($uri);    
        $result = $this->userModel->getById($user_id); 
        $this->load('user/excluir', array('user' => $result));
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function getById()
    {           
        $uri = $_SERVER['REQUEST_URI'];        
        $uri = explode('/',$uri);
        $empresa = end($uri); 
        $result = $this->empresaModel->getById($empresa);
        echo json_encode($result);
    }   
    
    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function buscar()
    {        
        $param = $_GET['pes'];        
        $result = $this->userModel->getUser($param);
        $this->load('user/main', array('users' => $result)); 
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
