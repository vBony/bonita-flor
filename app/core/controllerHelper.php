<?php
namespace core;
use auth\Admin as AdminAuth;
use models\Admin as AdminModel;
class controllerHelper{

    public function loadView($viewName, $viewData = array(), $show_header = true){
        extract($viewData);

        require 'app/views/'.$viewName.'.php';
    }

    public function loadTemplate($viewData = array()){
        extract ($viewData);

        require 'app/views/template.php';
    }

    public function loadValidator($validatorName){
        require 'app/models/validators/'.$validatorName.'.php';
    }

    public static function baseUrl(){
        return $_ENV['BASE_URL'];
    }

    public function loadComponent($viewName, $viewData = array()){
        extract($viewData);

        require 'app/views/'.$viewName.'.php';
    }

    public function loadViewInTemplate($viewName, $viewData = array()){
        extract($viewData);
        require 'app/views/'.$viewName.'.php';
    }

    public function send(int $code, array $message = array()){
        http_response_code($code);
        $message = json_encode($message);
        
        echo $message;
    }

    public function post($key = null){
        if(!empty($key)){
            if(isset($_POST[$key])){
                return $_POST[$key];
            }
        }else{
            return $_POST;
        }

        return null;
    }

    public function isLogged(){
        $auth = new AdminAuth();
        $auth->isLogged();

        $idAdmin = $auth->getIdUserLogged();

        $admin = new AdminModel();
        return $admin->buscar($idAdmin);
    }
}

?>