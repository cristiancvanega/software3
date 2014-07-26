<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reportes
 *
 * @author CRISTIAN
 */
class Reportes{
    function reporteVentas($argumentos) {
        extract($argumentos);  
        echo $cantidad;
//        file_put_contents('prueba.txt', $argumentos);
//        $ok = UtilConexion::$pdo->exec("SELECT empleado_insertar ('$cedula', '$nombre', '$apellido', '$cargo');");
//        echo json_encode($ok ? array('ok' => $ok, "mensaje" => "") : array('ok' => $ok, "mensaje" => " Faltan datos o el registro ya existe"));
    }
}
