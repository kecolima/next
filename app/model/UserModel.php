<?php

namespace app\model;

use app\core\Model;

/**
 * Classe responsável por gerenciar a conexão com a tabela user.
 */
class UserModel
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
        $sql = 'INSERT INTO user (name, email, password) VALUES (:name, :email, :password)';

        $params = [
            ':name'      => $params->name,
            ':email'     => $params->email,
            ':password'     => $params->password
        ];

        if (!$this->pdo->executeNonQuery($sql, $params))
            return -1; //Código de erro

        return $this->pdo->getLastID();
    }

    /**
     * Atualiza um registro na base de dados através do ID do User
     *
     * @param  Object $params Lista com os parâmetros a serem inseridos
     * @return bool True em caso de sucesso e false em caso de erro
     */
    public function update(object $params, $id)
    {
        $sql = 'UPDATE user SET name = :nome, email = :email, password = :senha, data = :data WHERE id = :id';

        $params = [
            ':id'        => $id,
            ':nome'      => $params->nome,
            ':email'     => $params->email,
            ':senha'     => $params->senha,
            ':data'     => null,
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
        $sql = 'SELECT id, name, email, password, data FROM user ORDER BY name ASC';

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
        $sql = 'SELECT id, name, email, password, data FROM user WHERE id = :id';

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
        $sql = 'SELECT * FROM user WHERE name = :valor';
        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr

        $param = [
            ':valor' => $param
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
        $sql = 'DELETE FROM user WHERE id = :id';

        $param = [
            ':id' => $id
        ];
        
        $dr = $this->pdo->executeQuery($sql, $param);   
        
        $sql = 'UPDATE empresa SET id_user = :id WHERE id_user = :id_user';      
        $params = [
            ':id_user' => $id,
            ':id'      => '0'
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
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :senha';
        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr

        $param = [
            ':email' => $params->email,
            ':senha' => $params->senha
        ];

        $dt = $this->pdo->executeQuery($sql, $param);     
       
        if ($dt) {
            return 1; 
        }           

        return -1; //Código de erro
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
            'id'               => $param['id']                                          ?? null,
            'name'             => $param['name']                                        ?? null,
            'email'            => $param['email']                                       ?? null,
            'password'         => $param['password']                                    ?? null,
            'link_empresa'     => BASE.'ver-empresa/'.$param['id'].'/'.$param['name']   ?? null,
            'link_editar'      => BASE.'editar-user/'.$param['id']                      ?? null,
            'link_deletar'     => BASE.'excluir-user/'.$param['id']                      ?? null
        ];
    }
}
