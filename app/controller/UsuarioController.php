<?php

namespace app\controller;

use app\core\Controller;
use app\model\UsuarioModel;
use app\classes\Input;

class UsuarioController extends Controller
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
        $this->usuarioModel = new usuarioModel();
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function index()
    {
        $result = $this->usuarioModel->getAll();            
        $this->load('usuario/main', array('usuarios' => $result)); 
    }

    /**
     * Carrega a página com o formulário para cadastrar um novo User
     *
     * @return void
     */
    public function novo()
    {
        $this->load('usuario/novo');
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
        $usuario_id = end($uri);    
        $result = $this->usuarioModel->getById($usuario_id); 
        $this->load('usuario/editar', array('usuario' => $result));
    }

    public function insert()
    {
        $usuario = $this->getInput();
        /*
        if (!$this->validate($usuario, false)) {
            return  $this->showMessage(
                'Formulário inválido', 
                'Os dados fornecidos são inválidos',
                BASE  . 'novo-usuario/',
                422
            );
        }
        */
        
        $result_usuario = $this->usuarioModel->getValidarUser($usuario);       

        if ($result_usuario <= 0) {
            echo 'Usuário já cadastrado';
            die();
        }

        $result = $this->usuarioModel->insert($usuario);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo Usuário';
            die();
        }
        
        redirect(BASE . 'editar-usuario/' . $result);
    }

    /**
     * Realiza a busca na base de dados e exibe na página de resultados
     *
     * @return void
     */
    public function pesquisar()
    {
        $param = Input::post('pes');
        $this->load('usuario/novo', [
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
        $usuario = $this->getInput(); 
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
        $result = $this->usuarioModel->update($usuario,$id);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo empresa';
            die();
        }

        redirect(BASE . 'editar-usuario/' . $id);      
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
            'senha'     => Input::post('txtSenha'),
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
        $usuario = end($uri); 

        $result = $this->usuarioModel->delete($usuario);        
       
        if ($result <= 0) {
            echo 'Erro ao deletar uma novo usuaario';
            die();
        }

        redirect(BASE . 'usuario'); 
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
        $usuario_id = end($uri);    
        $result = $this->usuarioModel->getById($usuario_id); 
        $this->load('usuario/excluir', array('usuario' => $result));
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
        $result = $this->usuarioModel->getUser($param);
        $this->load('usuario/main', array('usuarios' => $result)); 
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
