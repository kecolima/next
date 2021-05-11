<?php

$this->get('/', 'LoginController@index');
$this->get('/login-usuario', 'LoginController@login');
$this->get('/logout', 'LoginController@logout');

$this->get('/home', 'PagesController@home');
$this->get('/contato', 'PagesController@contato');
$this->post('/pesquisa', 'PagesController@pesquisar');

$this->get('/usuario', 'UsuarioController@index');
$this->get('/novo-usuario', 'UsuarioController@novo');
$this->get('/editar-usuario', 'UsuarioController@editar');
$this->get('/excluir-usuario', 'UsuarioController@excluir');
$this->post('/update-usuario', 'UsuarioController@update');
$this->post('/insert-usuario', 'UsuarioController@insert');
$this->post('/delete-usuario', 'UsuarioController@delete');
$this->post('/buscar-usuario', 'UsuarioController@buscar');

$this->get('/empresa', 'EmpresaController@index');
$this->get('/novo-empresa', 'EmpresaController@novo');
$this->get('/editar-empresa', 'EmpresaController@editar');
$this->get('/excluir-empresa', 'EmpresaController@excluir');
$this->post('/update-empresa', 'EmpresaController@update');
$this->post('/insert-empresa', 'EmpresaController@insert');
$this->post('/delete-empresa', 'EmpresaController@delete');
$this->get('/buscar-empresa', 'EmpresaController@buscar');
$this->get('/ver-empresa', 'EmpresaController@getEmpresas');

$this->get('api/usuario', 'UsuarioControllerAPI@index');
$this->get('api/usuario/{id}', 'UsuarioControllerAPI@getById');
$this->post('api/update-usuario', 'UsuarioControllerAPI@update');
$this->post('api/insert-usuario', 'UsuarioControllerAPI@insert');
$this->get('api/delete-usuario/{id}', 'UsuarioControllerAPI@delete');

$this->get('api/empresa', 'EmpresaControllerAPI@index');
$this->get('api/empresa/{id}', 'EmpresaControllerAPI@getById');
$this->post('api/update-empresa', 'EmpresaControllerAPI@update');
$this->post('api/insert-empresa', 'EmpresaControllerAPI@insert');
$this->get('api/delete-empresa/{id}', 'EmpresaControllerAPI@delete');

$this->get('api/auth', 'AuthController@login');
