<?php
use core\controllerHelper;

class agendamentoController extends controllerHelper {
    public function viewIndex(){
        $this->loadView('agendar', array());
    }
}