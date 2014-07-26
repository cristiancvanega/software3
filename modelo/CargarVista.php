<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargaVista
 *
 * @author CRISTIAN
 */
class CargarVista {

    function rutaFoto($argumentos) {
        extract($argumentos);

//        $conn = pg_connect("host=192.168.1.57 port=5432 dbname=prysoftware user=postgres password=postgres");
        $conn = pg_connect("host=localhost port=5432 dbname=prysoftware user=postgres password=postgres");

        if (!$conn) {
            echo "Connection error occurred.\n";
            exit;
        }
//
        $result = pg_query($conn, "SELECT ruta, descripcion FROM productos where id = $id");
        if (!$result) {
            echo "An error pg_query.\n";
            exit;
        }
        pg_close();
//        $result = pg_query($conn, "SELECT ruta FROM productos where id = 1");
        if (!$result) {
            echo "<img src=vista/imagenes/foto1.jpg id=imgProducto>";
            exit;
        }
        $row = pg_fetch_row($result);
        echo "<img id=" . "img" . $id . " src=" . $row[0] . " id=imgProducto> "
                . "<br><br>"
                . "<p>" . $row[1] . "</p>";
    }
    function cargaProductos() {
        $conn = pg_connect("host=localhost port=5432 dbname=prysoftware user=postgres password=postgres");

        if (!$conn) {
            echo "Connection error occurred.\n";
            exit;
        }
//
        $result = pg_query($conn, "SELECT nombre FROM productos");
        if (!$result) {
            echo "An error pg_query.\n";
            exit;
        }
        pg_close();
        $i=1;
        while ($row = pg_fetch_row($result)) {
            echo "<label id=" . $i . ">" . $row[0] ."</label>";
            echo "<br /> . <br /> . <br />";
            $i++;
        }
    }

    function getCantidad($args){
        extract($args);
        $conn = pg_connect("host=localhost port=5432 dbname=prysoftware user=postgres password=postgres");

        if (!$conn) {
            echo "Connection error occurred.\n";
            exit;
        }
//
        $result = pg_query($conn, "SELECT cantidad FROM productos where id = $id");
        if (!$result) {
            echo "An error pg_query.\n";
            exit;
        }
        pg_close();
//        $result = pg_query($conn, "SELECT ruta FROM productos where id = 1");
        if (!$result) {
            echo 0;
            exit;
        }
        $row = pg_fetch_row($result);
        echo $row[0];
    }
}
