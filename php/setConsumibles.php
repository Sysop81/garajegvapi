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


        $listadoConsumibles = array(
            array('codigo'=> 1, 'nombre'=>'Aceite de motor','base_i'=>15.2),
            array('codigo'=> 2, 'nombre'=>'Filtro de aceite','base_i'=>10.5),
            array('codigo'=> 3, 'nombre'=>'Liquido de frenos','base_i'=>9.90),
            array('codigo'=> 4, 'nombre'=>'Pastillas de freno','base_i'=>35.75),
            array('codigo'=> 5, 'nombre'=>'Filtro de aire','base_i'=>31.20),
            array('codigo'=> 6, 'nombre'=>'Juego de neumaticos','base_i'=>400.0),
            array('codigo'=> 7, 'nombre'=>'Lubricante','base_i'=>15.2),
            array('codigo'=> 8, 'nombre'=>'Liquido refrigerante','base_i'=>13.2),
            array('codigo'=> 9, 'nombre'=>'Correa distribucion','base_i'=>99.0),
            array('codigo'=> 10,'nombre'=>'Polea motor 2','base_i'=>50.0)
        );

        $listResult = array();
       
        foreach( $listadoConsumibles as $consumible ) {

            
            $id = $models->execute_kw($db, $uid, $password,
                  'consumible', 'create',
                  array(array('codigo'=>intval($consumible['codigo']),
                              'nombre'=> $consumible['nombre'],
                              'iva' =>'21',
                              'base_i'=> $consumible['base_i'])
                  ));
            
            if(is_numeric($id)){
                array_push($listResult,$id);
            }     
                  
		}

        $msg = count($listResult) == 10 ? 'ok':'error';


        echo json_encode(['result' => $msg]); 

    }