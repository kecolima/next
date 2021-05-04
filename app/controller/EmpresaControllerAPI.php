<?php

namespace app\controller;

use app\core\Controller;
use app\model\EmpresaModel;
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
        //return json_encode($result);
        echo json_encode($result);
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
    
    public function insert()
    { 
        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);
        $parametros = $jsonBody; 

        $empresa = $this->getInput($parametros);

        $result = $this->empresaModel->insert($empresa);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo empresa';
            die();
        }
       
        if (!$this->validate($empresa, false)) {
            return  $this->showMessage(
                'Formulário inválido', 
                'Os dados fornecidos são inválidos',
                BASE  . 'novo-empresa/',
                422
            );
        }

        $result = $this->empresaModel->insert($empresa);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo empresa';
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
        $body = file_get_contents('php://input');
        $jsonBody = json_decode($body, true);
        $parametros = $jsonBody; 

        $empresa = $this->getInput($parametros);

        $result = $this->empresaModel->update($empresa);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo empresa';
            die();
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
            'nome'      => $param['nome']
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
