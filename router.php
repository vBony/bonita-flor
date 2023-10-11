<?php
global $routes;
$routes = array();
$routes['/'] = '/';
$routes['/agendar'] = '/agendamento/viewIndex';
$routes['/api/agendamento'] = '/agendamento/apiIndex';
$routes['/api/agendamento/disponibilidade'] = '/agendamento/apiDisponibilidade';