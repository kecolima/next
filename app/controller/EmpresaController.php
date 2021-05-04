<?php

namespace app\controller;

use app\core\Controller;
use app\model\EmpresaModel;
use app\classes\Input;

class EmpresaController extends Controller
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
        $this->empresaModel = new empresaModel();
    }

    /**
     * Carrega a página principal
     *
     * @return void
     */
    public function index()
    {
        $result = $this->empresaModel->getAll();                 
        $this->load('empresa/main', array('empresas' => $result));           
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

;        if ($result_empresa <= 0) {
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
    private function getInput()
    {

        return (object)[
            'id'        => Input::get('id', FILTER_SANITIZE_NUMBER_INT),
            'nome'      => Input::post('txtNome'),
            'id_user'   => Input::post('txtUser')
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
