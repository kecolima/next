<?php
//dd('aqui');
$this->get('/', 'PagesController@home');
$this->get('/contato', 'PagesController@contato');
$this->post('/pesquisa', 'PagesController@pesquisar');

$this->get('/user', 'UserController@index');
$this->get('/novo-user', 'UserController@novo');
$this->get('/editar-user', 'UserController@editar');
$this->get('/excluir-user', 'UserController@excluir');
$this->post('/update-user', 'UserController@update');
$this->post('/insert-user', 'UserController@insert');
$this->post('/delete-user', 'UserController@delete');
$this->post('/buscar-user', 'UserController@buscar');


$this->get('/empresa', 'EmpresaController@index');
$this->get('/novo-empresa', 'EmpresaController@novo');
$this->get('/editar-empresa', 'EmpresaController@editar');
$this->get('/excluir-empresa', 'EmpresaController@excluir');
$this->post('/update-empresa', 'EmpresaController@update');
$this->post('/insert-empresa', 'EmpresaController@insert');
$this->post('/delete-empresa', 'EmpresaController@delete');
$this->get('/buscar-empresa', 'EmpresaController@buscar');
$this->get('/ver-empresa', 'EmpresaController@getEmpresas');

$this->get('api/user', 'UserControllerAPI@index');
$this->get('api/user/{id}', 'UserControllerAPI@getById');
$this->post('api/update-user', 'UserControllerAPI@update');
$this->post('api/insert-user', 'UserControllerAPI@insert');
$this->get('api/delete-user/{id}', 'UserControllerAPI@delete');

$this->get('api/empresa', 'EmpresaControllerAPI@index');
$this->get('api/empresa/{id}', 'EmpresaControllerAPI@getById');
$this->post('api/update-empresa', 'EmpresaControllerAPI@update');
$this->post('api/insert-empresa', 'EmpresaControllerAPI@insert');
$this->get('api/delete-empresa/{id}', 'EmpresaControllerAPI@delete');

$this->get('api/auth', 'AuthController@login');
