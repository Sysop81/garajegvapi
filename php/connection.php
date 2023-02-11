<?php
    /*****************************************************************************************************************
     *                                 Archivo de conexión API Odoo                                                  *
     ****************************************************************************************************************/
    
     $url_auth = $url . '/xmlrpc/2/common';
     $url_exec = $url . '/xmlrpc/2/object';
     

     /******************************************************************************************************************
      *    Conexion XMLRPC API Odoo                                                                                    *
      ******************************************************************************************************************/

     // Requerimos la libreria Ripcord . Go to  https://github.com/poef/ripcord
     require_once("ripcord/ripcord.php");

     // Hacemos Login in Odoo API
     $common = ripcord::client($url_auth);
     $uid = $common->authenticate($db, $username, $password, array());
     $models = ripcord::client($url_exec);

?>