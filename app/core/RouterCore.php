<?php

namespace app\core;

class RouterCore
{
    private $uri;
    private $method;
    private $getArr = [];

    public function __construct()
    {
        $this->initialize();
        require_once('../app/config/Router.php');
        $this->execute();
    }

    private function initialize()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, '?'))
            $uri = mb_substr($uri, 0, strpos($uri, '?'));

        $ex = explode('/', $uri);

        $uri = $this->normalizeURI($ex);
       
        for ($i = 0; $i < UNSET_URI_COUNT; $i++) {
            unset($uri[$i]);
        }

        $this->uri = implode('/', $this->normalizeURI($uri));
        
        if (DEBUG_URI)
            dd($this->uri);
    }

    private function get($router, $call)
    {
        $this->getArr[] = [
            'router' => $router,
            'call' => $call
        ];
    }

    private function post($router, $call)
    {
        $this->getArr[] = [
            'router' => $router,
            'call' => $call
        ];
    }

    private function execute()
    {         
        switch ($this->method) {           
            case 'GET':
                $this->executeGet();
                break;
            case 'POST':          
                $this->executePost();
                break;
            case 'DELETE':
                $this->executeDelete();
                break;
        }
    }

    private function executeGet()
    {
        $uri_id = $this->uri; 
        $url = explode('/', $uri_id);
        $controller = $url[1];
        if ($url[0] === 'api') {
            if ($url[1]) {                
                array_shift($url);         
                if($url[1]){                  
                    $cont = 'app\\controller\\'.$controller.'ControllerAPI';
                    $get['call'] = $controller.'ControllerAPI@getById';
                    $this->executeControllerAPI($get['call'], false);
                    /*
                    try {
                        $response = call_user_func_array(array(new $cont, $method), $url);    
                        http_response_code(200);
                        echo json_encode(array('status' => 'sucess', 'data' => $response));
                        exit;
                    } catch (\Exception $e) {
                        http_response_code(404);
                        echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                    */
                } if($url[0] == "auth") {
                    $cont = 'app\\controller\\'.$controller.'Controller';
                    $get['call'] = $controller.'Controller@login';
                    $this->executeControllerAPI($get['call'], false);
                } else {
                    $cont = 'app\\controller\\'.$controller.'ControllerAPI';
                    $get['call'] = $controller.'ControllerAPI@index';
                    $this->executeControllerAPI($get['call'], false);
                }
            } else {
                http_response_code(404);
                echo json_encode(array('status' => 'error', 'data' =>  $response), JSON_UNESCAPED_UNICODE);
                exit;
            }

        } else {
            $uri = $this->uri;
            $uri = explode('/',$uri);
            foreach ($this->getArr as $get) {                
                $r = substr($get['router'], 1);
                if (substr($r, -1) == '/') {
                    $r = substr($r, 0, -1);
                }
                if ($r == $uri[0]) {
                    if($uri[0] == 'pesquisa'){
                        if (is_callable($get['call'])) {
                            $get['call']();
                            break;
                        } else {
                            $this->executeController($get['call']);
                        }
                    } else {                         
                        if (is_callable($get['call'])) {
                            $get['call']();
                            break;
                        } else {
                            $this->executeController($get['call']);
                        }
                    }                    
                } 
            }
        }
    }

    private function executePost()
    {
        $uri_id = $this->uri; 
        $url = explode('/', $uri_id);
        if ($url[0] === 'api') {

            $controller = explode('-',$url[1]);
            $body = file_get_contents('php://input');
            $jsonBody = json_decode($body, true);
            $parametros = $jsonBody; 
            if ($controller[0] === 'update') {
                
                    $cont = 'app\\controller\\'.$controller[1].'ControllerAPI';
                    $get['call'] = $controller[1].'ControllerAPI@update';
                 
                    $this->executeControllerAPI($get['call'],  $parametros);
                    /*
                    try {
                        $response = call_user_func_array(array(new $cont, $method), $url);    
                        http_response_code(200);
                        echo json_encode(array('status' => 'sucess', 'data' => $response));
                        exit;
                    } catch (\Exception $e) {
                        http_response_code(404);
                        echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                    */
            } else if ($controller[0] === 'insert') {

                    $cont = 'app\\controller\\'.$controller[1].'ControllerAPI';
                    $get['call'] = $controller[1].'ControllerAPI@insert';                   

                    $this->executeControllerAPI($get['call'],  $parametros);
                    /*
                    try {
                        $response = call_user_func_array(array(new $cont, $method), $url);    
                        http_response_code(200);
                        echo json_encode(array('status' => 'sucess', 'data' => $response));
                        exit;
                    } catch (\Exception $e) {
                        http_response_code(404);
                        echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                    */                            
            } else if ($controller[0] === "auth") {
                $cont = 'app\\controller\\'.$controller[0].'Controller';
                $get['call'] = $controller[0].'Controller@login';
                $this->executeControllerAPI($get['call'], false);
            } else {
                http_response_code(404);
                echo json_encode(array('status' => 'error', 'data' =>  $response), JSON_UNESCAPED_UNICODE);
                exit;
            }  

        } else {
            $uri = $this->uri;
            $uri = explode('/',$uri);
            foreach ($this->getArr as $get) {
                $r = substr($get['router'], 1);
                
                if (substr($r, -1) == '/') {
                    $r = substr($r, 0, -1);
                }
               
                if ($r == $uri[0]) {
                    if (is_callable($get['call'])) {
                        $get['call']();
                        return;
                    }
                    $this->executeController($get['call']);
                } 
            }
        }
    }

    private function executeDelete()
    {        
        $uri_id = $this->uri; 
        $url = explode('/', $uri_id);
        if ($url[0] === 'api') {

            $controller = explode('-',$url[1]);
            $body = file_get_contents('php://input');
            $jsonBody = json_decode($body, true);
            $parametros = $jsonBody; 
            
            if ($controller[0] === 'delete') {
           
                    $cont = 'app\\controller\\'.$controller[1].'ControllerAPI';
                    $get['call'] = $controller[1].'ControllerAPI@delete';
                 
                    $this->executeControllerAPI($get['call'],  $url[2]);
                    /*
                    try {
                        $response = call_user_func_array(array(new $cont, $method), $url);    
                        http_response_code(200);
                        echo json_encode(array('status' => 'sucess', 'data' => $response));
                        exit;
                    } catch (\Exception $e) {
                        http_response_code(404);
                        echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                    */
            } else {
                http_response_code(404);
                echo json_encode(array('status' => 'errorrr', 'data' =>  $response), JSON_UNESCAPED_UNICODE);
                exit;
            }  

        } else {
            foreach ($this->getArr as $get) {
                $r = substr($get['router'], 1);
    
                if (substr($r, -1) == '/') {
                    $r = substr($r, 0, -1);
                }
    
                if ($r == $this->uri) {
                    if (is_callable($get['call'])) {
                        $get['call']();
                        return;
                    }
    
                    $this->executeController($get['call']);
                }
            }
        }
    }

    private function executeController($get)
    {     
        $ex = explode('@', $get);
        if (!isset($ex[0]) || !isset($ex[1])) {
            (new \app\controller\MessageController)->message('Dados inv??lidos', 'Controller ou m??todo n??o encontrado: ' . $get, 404);
            return;
        }

        $cont = 'app\\controller\\' . $ex[0];
        if (!class_exists($cont)) {
            (new \app\controller\MessageController)->message('Dados inv??lidos', 'Controller n??o encontrada: ' . $get, 404);
            return;
        }

        if (!method_exists($cont, $ex[1])) {
            (new \app\controller\MessageController)->message('Dados inv??lidos', 'M??todo n??o encontrado: ' . $get, 404);
            return;
        }

        call_user_func_array([
            new $cont,
            $ex[1]
        ], []);
    }

    private function executeControllerAPI($get, $parametros)
    {           
        $ex = explode('@', $get);
        if (!isset($ex[0]) || !isset($ex[1])) {
            (new \app\controller\MessageController)->message('Dados inv??lidos', 'Controller ou m??todo n??o encontrado: ' . $get, 404);
            return;
        }

        $cont = 'app\\controller\\' . $ex[0];
        if (!class_exists($cont)) {
            (new \app\controller\MessageController)->message('Dados inv??lidos', 'Controller n??o encontrada: ' . $get, 404);
            return;
        }

        if (!method_exists($cont, $ex[1])) {
            (new \app\controller\MessageController)->message('Dados inv??lidos', 'M??todo n??o encontrado: ' . $get, 404);
            return;
        }

        call_user_func_array([
            new $cont,
            $ex[1]
        ], []);        
    }

    private function normalizeURI($arr)
    {
        return array_values(array_filter($arr));
    }
}
