<?php
    /****************************************************************************************************************
     * Método encargado de recuperar todos los consumibles registrados en la BBDD de Odoo                           *
     ****************************************************************************************************************/
    
    // incluimos la librería de conexión
    if(isset($_GET['configuracion'])){

        $params = json_decode($_GET['configuracion'], TRUE);

        $url = 'http://' . $params['ip'] . ':' . $params['port'];
        $db  = $params['bd'];
        $username = $params['user'];
        $password = $params['pass']; 

        require_once('connection.php');

        $msg= is_numeric($uid) ? 'ok' : 'error';
           
        echo json_encode(['result' => $msg]);
    }
    
?>    