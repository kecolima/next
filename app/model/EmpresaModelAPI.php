<?php

namespace app\model;

use app\core\Model;

/**
 * Classe responsável por gerenciar a conexão com a tabela empresa.
 */
class EmpresaModelAPI
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
     * Insere um novo registro na tabela de Empresas e retorna seu ID em caso de sucesso
     *
     * @param  Object $params Lista com os parâmetros a serem inseridos
     * @return int Retorna o ID do Empresa inserido ou -1 em caso de erro
     */
    public function insert(object $params)
    {
        $sql = 'INSERT INTO empresa (nome, id_user) VALUES (:nome, :id_user)';

        $params = [
            ':nome'      => $params->nome,            
            ':id_user'   => $params->id_user
        ];

        if (!$this->pdo->executeNonQuery($sql, $params))
            return -1; //Código de erro

        return $this->pdo->getLastID();
    }

    /**
     * Atualiza um registro na base de dados através do ID do Empresa
     *
     * @param  Object $params Lista com os parâmetros a serem inseridos
     * @return bool True em caso de sucesso e false em caso de erro
     */
    public function update(object $params)
    {          
        $sql = 'UPDATE empresa SET nome = :nome, id_user = :id_user WHERE id = :id';      
        $params = [
            ':id'        => $params->id,
            ':nome'      => $params->nome,
            ':id_user'   => $params->id_user
        ];

        return $this->pdo->executeNonQuery($sql, $params);
    }

    /**
     * Deleta um registro na base de dados através do ID do Empresa
     *
     * @param  Object $params deleta com os parâmetros a serem inseridos
     * @return bool True em caso de sucesso e false em caso de erro
     */
    public function delete(int $id)
    {
        $sql = 'DELETE FROM empresa WHERE id = :id';

        $param = [
            ':id' => $id
        ];

        $dr = $this->pdo->executeQuery($sql, $param);        

        return $this->collection($dr);
    }

    /**
     * Retorna todos os registros da base de dados em ordem ascendente por nome
     *
     * @return arra[object]
     */
    public function getAll()
    {
        //Excrevemos a consulta SQL e atribuimos a váriavel $sql
        $sql = 'SELECT id, nome, id_user FROM empresa ORDER BY nome ASC';

        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr
        $dt = $this->pdo->executeQuery($sql);

        //Declara uma lista inicialmente nula
        $listaEmpresa = null;

        //Percorremos todas as linhas do resultado da busca
        foreach ($dt as $dr)
            //Atribuimos a última posição do array o Empresa devidamente tratado
            $listaEmpresa[] = $this->collection($dr);

        //Retornamos a lista de Empresas
        return $listaEmpresa;
    }

    /**
     * Retorna todos os registros da base de dados em ordem ascendente por nome
     *
     * @return arra[object]
     */
    public function getUsers()
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
            $listaUser[] = $this->collectionUsers($dr);

        //Retornamos a lista de Users
        return $listaUser;
    }

    /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do Empresa ou se não encontrar com seus valores nulos
     */
    public function getById(int $id)
    {
        $sql = 'SELECT id, nome FROM empresa WHERE id = :id';

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
    public function getValidarEmpresa(object $params)
    {        
        $sql = 'SELECT * FROM empresa WHERE nome = :nome';
        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr

        $param = [
            ':nome' => $params->nome
        ];

        $dt = $this->pdo->executeQuery($sql, $param);     
       
        if ($dt) {
            return -1; //Código de erro
        }           

        return 1;
    }

     /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do Empresa ou se não encontrar com seus valores nulos
     */
    public function getEmpresa(string $param)
    {        
        $sql = 'SELECT * FROM empresa WHERE nome = :valor';
        //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr

        $param = [
            ':valor' => $param
        ];

        $dt = $this->pdo->executeQuery($sql, $param); 
        
        //Declara uma lista inicialmente nula
        $listaEmpresa = null;

        //Percorremos todas as linhas do resultado da busca
        foreach ($dt as $dr) 

        //Atribuimos a última posição do array o Empresa devidamente tratado
        
        $listaEmpresa[] = $this->collection($dr);
            
        //Retornamos a lista de Empresas
        return $listaEmpresa;
    }

     /**
     * Retorna um único registro da base de dados através do ID informado
     *
     * @param  int $id ID do objeto a ser retornado
     * @return object Retorna um objeto populado com os dados do Empresa ou se não encontrar com seus valores nulos
     */
    public function getEmpresas(int $id_user)
    {
       //Excrevemos a consulta SQL e atribuimos a váriavel $sql 
       
       $sql = 'SELECT * FROM empresa  WHERE id_user = :id_user ORDER BY nome ASC ';
       //Executamos a consulta chamando o método da modelo. Atribuimos o resultado a variável $dr

       $param = [
        ':id_user' => $id_user
       ];

       $dt = $this->pdo->executeQuery($sql, $param); 
      
       //Declara uma lista inicialmente nula
       $listaEmpresa = null;

        //Percorremos todas as linhas do resultado da busca
        foreach ($dt as $dr) 

        //Atribuimos a última posição do array o Empresa devidamente tratado
          
        $listaEmpresa[] = $this->collection($dr);
        
       //Retornamos a lista de Empresas
       return $listaEmpresa;
    }

    /**
     * Converte uma estrutura de array vinda da base de dados em um objeto devidamente tratado
     *
     * @param  array|object $param Revebe o parâmetro que é retornado na consulta com a base de dados
     * @return object Retorna um objeto devidamente tratado com a estrutura de Empresas
     */
    private function collection($param)
    {
        return (object)[
            'id'             => $param['id']       ?? null,
            'nome'           => $param['nome']     ?? null,
            'id_user'        => $param['id_user']  ?? null,
            'link_editar'    => BASE.'api/editar-empresa/'.$param['id']  ?? null,
            'link_deletar'   => BASE.'api/excluir-empresa/'.$param['id'] ?? null
        ];
    }

     /**
     * Converte uma estrutura de array vinda da base de dados em um objeto devidamente tratado
     *
     * @param  array|object $param Revebe o parâmetro que é retornado na consulta com a base de dados
     * @return object Retorna um objeto devidamente tratado com a estrutura de Users
     */
    private function collectionUsers($param)
    {        
        return (object)[
            'id'               => $param['id']                                              ?? null,
            'name'             => $param['name']                                            ?? null,
            'email'            => $param['email']                                           ?? null,
            'password'         => $param['password']                                        ?? null,
            'link_empresa'     => BASE.'api/ver-empresa/'.$param['id'].'/'.$param['name']   ?? null,
            'link_editar'      => BASE.'api/editar-user/'.$param['id']                      ?? null,
            'link_deletar'     => BASE.'api/excluir-user/'.$param['id']                     ?? null
        ];
    }
}
