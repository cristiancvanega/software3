<?php

/**
 * Controlador de fachada que recibe mensajes de la capa de presentación,
 * Instancia la base de datos,
 * Delega a otras clases las peticiones recibidas y en algunas ocasiones
 * Envía las respuestas recibidas a la capa de presentación.
 * Basado en el patron GoF "Facade", ver Larman
 * @author Carlos Cuesta Iglesias
 */
header('Content-Type: text/html; charset=UTF-8');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  // disable IE caching
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//linea 11 a 16: para no utilizar el caché
$errores = '';
error_reporting(E_ERROR); // Para PHP 6 E_STRICT es parte de E_ALL -- ¿ --- error_reporting(E_ALL | E_STRICT); para verificación exhaustivo --- ?
ini_set('display_errors', 'ON');
ini_set('log_errors', 'On');
ini_set('error_log', 'Ver errores.log');
session_start();
/** Include path * */
//set_include_path(get_include_path() . PATH_SEPARATOR . '../../Includes/phpExcel/Classes/');

/** PHPExcel_IOFactory */
include ('class.ezpdf.php');

try { //via post 
    spl_autoload_register('__autoload'); //Registra todas las librerias que se van necesitando linea 55
    $args = $_POST;  //--------------------->  No permite ingreso por URL   SEGURIDAD 1                               
        Conexion::getInstance();
        if (isset($args['clase'])) {        //el array argumentos tiene definido clase
            $clase = $args['clase'];        //array asociativo (tabla hash)
            if (isset($args['oper'])) {
                $metodo = $args["oper"];
                $args['error'] = $errores;
                if ($clase === 'Conexion') {  // Llamado a métodos de clase
                    $clase::$metodo($args);
                } else {                                // Llamado a metodos de instancia
                    $obj = new $clase();
                    $obj->$metodo($args);
                }
            } else {
                throw new Exception('El controlador no ha recibido un mensaje válido.');
            }
        } else {
            throw new Exception('El controlador no sabe a quien enviar el mensaje.');
        }
} catch (Exception $e) {
    echo json_encode(array("ok" => 0, "mensaje" => $e->getMessage()));
//    echo "mierda";
}

/**
 * Intenta cargar aquellas clases que no se incluyen explícitamente.
 * @param <type> $nombreClase el nombre de la clase que se intentará cargar
 * desde la ruta ../modelo/
 * IMPORTANTE: include_once no lanza excepciones
 */
function __autoload($nombreClase) {
    file_put_contents("nombreclase", $nombreClase);
    if ($nombreClase === 'Conexion') { 
        $nombreClase = "../serviciosTecnicos/utilidades/$nombreClase.php";
    } else {
        $nombreClase = "../modelo/$nombreClase.php"; // de no empezar por Util
    }
    include_once($nombreClase);
}

?>
