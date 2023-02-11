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


        $listadoMecanicos = array(
            array('dni'=> '21345567F', 'nombre'=>'Jose Ramon','apellido1'=>'Lopez','apellido2'=>'Guillén','cargo'=>'encargado'),
            array('dni'=> '22355668G', 'nombre'=>'Francisco','apellido1'=>'Matinez','apellido2'=>'Valencia','cargo'=>'jefetaller'),
            array('dni'=> '23365769H', 'nombre'=>'Martin','apellido1'=>'Muñoz','apellido2'=>'Perez','cargo'=>'mecanicoof1'),
            array('dni'=> '21375860I', 'nombre'=>'Carmen','apellido1'=>'Gallego','apellido2'=>'Acosta','cargo'=>'aprendiz')
        );

        $listResult = array();

        foreach( $listadoMecanicos as $mecanico ) {

            $id = $models->execute_kw($db, $uid, $password,
                  'mecanico', 'create',
                  array(array('dni'=>$mecanico['dni'],
                              'nombre'=> $mecanico['nombre'],
                              'apellido1'=> $mecanico['apellido1'],
                              'apellido2'=> $mecanico['apellido2'],
                              'cargo' => $mecanico['cargo'])
                  ));
            
            if(is_numeric($id)){
                array_push($listResult,$id);
            }      
                  
		}

        $msg = count($listResult) == 4 ? 'ok':'error';


        echo json_encode(['result' => $msg]);

    }