<?php
    /****************************************************************************************************************
     * Método encargado de recuperar todos los consumibles registrados en la BBDD de Odoo                           *
     ****************************************************************************************************************/

    
    if(isset($_GET['configuracion'])){

        $params = json_decode($_GET['configuracion'], TRUE);

        $url = 'http://' . $params['ip'] . ':' . $params['port'];
        $db  = $params['bd'];
        $username = $params['user'];
        $password = $params['pass']; 

        require_once('connection.php');

        $vehiculos = $models->execute_kw($db, $uid, $password,'vehiculo', 'search_read',
                                array(array(array('create_date', '>' ,'2020-09-05 22:00:00'))));

        echo json_encode($vehiculos);  
    }