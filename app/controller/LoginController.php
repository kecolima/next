<?php

namespace app\controller;

use app\core\Controller;
use app\model\UserModel;
use app\classes\Input;

class LoginController extends Controller
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
    public function index()
    {
        $this->load('login/login');
    }

    /**
     * Método responsável por validar o JWT
     *
     * @return String
     */
    public function login()
    {
        $user = $this->getInput();
        $result_user = $this->userModel->getValidarUser($user);

        if ($result_user <= 0) {
            echo 'Usuário não cadastrado';
            die();
        } 
        
        redirect(BASE);
        //echo $result;
        
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {
        return (object)[ 
            'email'     => Input::post('txtEmail'),
            'senha'     => Input::post('txtSenha')
        ];
    }
}