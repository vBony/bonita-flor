<?php
use core\controllerHelper;

class agendamentoController extends controllerHelper {
    public function viewIndex(){
        $this->loadView('agendar', array());
    }

    public function apiIndex(){
        $this->send(200, 'olá mundo!');
    }
}