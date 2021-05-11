<?php

namespace app\model;

use app\core\Model;

/**
 * Classe responsável por gerenciar a conexão com a tabela usuario.
 */
class UsuarioModelAPI
{

    //Instância da classe model
    private $pdo;

    /**
     * Método construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->pdo = new Model();
    }

    /**
     * Insere um novo registro na tabela de Users e retorna seu ID em caso de sucesso
     *
     * @param  Object $params Lista com os parâmetros a serem inseridos
     * @return int Retorna o ID do User inserido ou -1 em caso de erro
     */
    public function insert(object $params)
    {   
        $sql = 'INSERT INTO usuario (nome, email, senha, data) VALUES (:nome, :email, :senha, :data)';

        $params = [
            ':nome'      => $params->nome,
            ':email'     => $params->email,
            ':senha'     => $params->senha,
            ':data'      => date('Y/m/d'),
        ];

        if (!$this->pdo->executeNonQuery($sql, $params)){
            return -1; //Código de erro
        } else {
            return $this->pdo->getLastID();
        }
    }

    /**
     * Atualiza um registro na base de dados através do ID do User
     *
     * @param  Object $params Lista com os parâmetros a serem inseridos
     * @return bool True em caso de sucesso e false em caso de erro
     */
    public function update(object $params)
    {
        $sql = 'UPDATE usuario SET nome = :nome, email = :email, senha = :senha, data = :data WHERE id = :id';

        $params = [
            ':id'        => $params->id,
            ':nome'      => $params->nome,
            ':email'     => $params->email,
            ':senha'     => $params->senha,
            ':data'      => date('Y/m/d'),
        ];

        return $this->pdo->executeNonQuery($sql, $params);
    }

    /**
     * Retorna todos os registros da base de dados em ordem ascendente por nome
     *
     * @return arra[object]
     */
    public function getAll()
    {
        //Excrevemos a consulta SQL e atribuimos a váriavel $sql
        $sql = 'SELECT id, nome, email, senha, data FROM usuario ORDER BY nome ASC';

        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr
        $dt = $this->pdo->executeQuery($sql);

        //Declara uma lista inicialmente nula
        $listaUser = null;

        //Percorremos todas as linhas do resultado da busca
        foreach ($dt as $dr)
            //Atribuimos a última posição do array o User devidamente tratado
            $listaUser[] = $this->collection($dr);

        //Retornamos a lista de Users
        return $listaUser;
    }

    /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do User ou se não encontrar com seus valores nulos
     */
    public function getById(int $id)
    {
        $sql = 'SELECT id, nome, email, senha, data FROM usuario WHERE id = :id';

        $param = [
            ':id' => $id
        ];

        $dr = $this->pdo->executeQueryOneRow($sql, $param);

        return $this->collection($dr);
    }

    /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do Empresa ou se não encontrar com seus valores nulos
     */
    public function getUser(string $param)
    {        
        $sql = 'SELECT * FROM usuario WHERE nome = :nome';
        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr

        $param = [
            ':nome' => $param
        ];

        $dt = $this->pdo->executeQuery($sql, $param); 
        
        //Declara uma lista inicialmente nula
        $listaUser = null;

        //Percorremos todas as linhas do resultado da busca
        foreach ($dt as $dr) 

        //Atribuimos a última posição do array o Empresa devidamente tratado
        
        $listaUser[] = $this->collection($dr);
            
        //Retornamos a lista de Users
        return $listaUser;
    }

    /**
     * Deleta um registro na base de dados através do ID do Empresa
     *
     * @param  Object $params deleta com os parâmetros a serem inseridos
     * @return bool True em caso de sucesso e false em caso de erro
     */
    public function delete(int $id)
    {
        $sql = 'DELETE FROM usuario WHERE id = :id';

        $param = [
            ':id' => $id
        ];
        
        $dr = $this->pdo->executeQuery($sql, $param);   
        
        $sql = 'UPDATE empresa SET id_usuario = :id WHERE id_usuario = :id_usuario';      
        $params = [
            ':id_usuario' => $id,
            ':id'         => '0'
        ];

        $this->pdo->executeNonQuery($sql, $params);  

        return $this->collection($dr);
    }
    
    /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do Empresa ou se não encontrar com seus valores nulos
     */
    public function getValidarUser(object $params)
    {   
        $sql = 'SELECT * FROM usuario WHERE email = :email';
        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr

        $param = [
            ':email' => $params->email,
        ];

        $dt = $this->pdo->executeQuery($sql, $param);     
       
        if ($dt['id']) {
            return -1; //Código de erro
        }  

        return 1; 
    }

    /**
     * Converte uma estrutura de array vinda da base de dados em um objeto devidamente tratado
     *
     * @param  array|object $param Revebe o parâmetro que é retornado na consulta com a base de dados
     * @return object Retorna um objeto devidamente tratado com a estrutura de Users
     */
    private function collection($param)
    {        
        return (object)[
            'id'               => $param['id']                                             ?? null,
            'nome'             => $param['nome']                                           ?? null,
            'email'            => $param['email']                                          ?? null,
            'link_empresa'     => BASE.'api/ver-empresa/'.$param['id'].'/'.$param['nome']  ?? null,
            'link_editar'      => BASE.'api/editar-usuario/'.$param['id']                  ?? null,
            'link_deletar'     => BASE.'api/excluir-usuario/'.$param['id']                 ?? null
        ];
    }
}
