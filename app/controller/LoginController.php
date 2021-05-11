<?php

namespace app\controller;

use app\core\Controller;
use app\model\UsuarioModel;
use app\classes\Input;

class LoginController extends Controller
{
    //Instância da classe EmpresaModel
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
        $usuario = $this->getInput();
        $result_usuario = $this->usuarioModel->getValidarUserLogin($usuario);
        $result_usuario = $result_usuario[0];
       
        if ($result_usuario <= 0) {
            echo 'Usuário não cadastrado';
            redirect(BASE);
            die();
        }  else {
            $_SESSION = $result_usuario;            
            $this->load('home/main', array('result_usuario' => $result_usuario));
        }   
    }

    /**
     * Método responsável pelo logout do sistema
     *
     * @return String
     */
    public function logout()
    {     
        session_destroy();           
        redirect(BASE);
        die();       
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