<?php
/**
 * Description of Ciudad
 * Las instancias de esta clase se conectan con la base de datos a traves de
 * una referencia que se tiene de ADODB.
 * @author Carlos
 */

class Ciudad implements Persistible {
    /**
     * Recibe un array de datos a insertar y con ellos crea una nueva fila en
     * la tabla con_Ciudad
     * @param <type> $argumentos La descripción del tema de congreso a insertar
     */
    function add($argumentos) {
        extract($argumentos);
        $ok = UtilConexion::$pdo->exec("SELECT ciudad_insertar('$ciudad_id', '$ciudad_nombre', '$fk_departamento')");
        echo json_encode($ok ? array('ok' => $ok, "mensaje" => "") : array('ok' => $ok, "mensaje" => " Faltan datos o el registro ya existe"));
    }

    /**
     * Actualiza una fila de Ciudads.
     * @param <type> $argumentos Un array con el id a buscar y los otros nuevos datos,
     * estos datos se proporcionan de la siguiente manera:
     * $argumentos[0]: Id de la Ciudad a buscar y actualizar, los demás datos
     * corresponden a las columnas que se van a actualizar
     */
    function edit($argumentos) {
        extract($argumentos);
        file_put_contents('1.txt', $argumentos);
        $ok = UtilConexion::$pdo->exec("SELECT ciudad_actualizar('$id', '$ciudad_id', '$ciudad_nombre', '$fk_departamento')");
        echo json_encode($ok ? array('ok' => $ok, "mensaje" => "") : array('ok' => $ok, "mensaje" => " Faltan datos o modificación no permitida"));
    }

    /**
     * Elimina las Ciudads cuyos IDs se pasen como argumentos.
     * @param <type> $argumentos los IDs de las Ciudads a ser eliminadas.
     * $argumentos es un cadena que contiene uno o varios números separados por
     * comas, que corresponden a los IDs de las filas a eliminar.
     */
    function del($argumentos) {
        // El formato que espera postgres es: SELECT sede_eliminar('{v1,...,vn}');
        $datos = "'{".$argumentos['id']."}'";
        $ok =UtilConexion::$pdo->exec("select ciudad_eliminar($datos)");
        echo json_encode($ok ? array('ok' => $ok, "mensaje" => "") : array('ok' => $ok, "mensaje" => " Falló la eliminación del registro"));
    }

    /**
     * Devuelve los datos necesarios para construir una tabla dinámica.
     * @param <type> $argumentos los argumentos enviados por:
     * Ciudad.js.crearTablaCiudads()
     */
    function select($argumentos) {
        $where = UtilConexion::getWhere($argumentos); // Se construye la clausula WHERE
        extract($argumentos);
        if (isset($id)) {
            $where = "WHERE departamento_id = '$id'";
        } else {
            $where = "WHERE departamento_id = 'ninguno'";
        }
        $count = UtilConexion::$pdo->query("SELECT ciudad_id FROM ciudad_select $where")->rowCount();
        // Calcula el total de páginas por consulta
        if( $count > 0 ) {
            $total_pages = ceil($count / $rows);
        } else {
            $total_pages = 0;
        }

        // Si por alguna razón página solicitada es mayor que total de páginas
        // Establecer a página solicitada total paginas  (¿por qué no al contrario?)
        if ($page > $total_pages) $page = $total_pages;

        // Calcular la posición de la fila inicial
        $start = $rows * $page - $rows;
        //  Si por alguna razón la posición inicial es negativo ponerlo a cero
        // Caso típico es que el usuario escriba cero para la página solicitada
        if($start < 0) $start = 0;
        // Se construye el JSON
        $response->total = $total_pages;
        $response->page = $page;
        $response->records = $count;
        $i=0;

        $sql = "SELECT * FROM ciudad_select $where ORDER BY $sidx $sord LIMIT $rows OFFSET $start";
        foreach (UtilConexion::$pdo->query($sql) as $row) {
            $response->rows[$i]['id']=$row['ciudad_id'];  // No cambiar el rows[$i]['id'] se requiere en vista
            $response->rows[$i]['cell'] = array($row['ciudad_id'],
                                                $row['ciudad_nombre'],
                                                $row['departamento_nombre']);
            $i++;
        }
        echo json_encode($response);
    }

    function getSelect($argumentos) {
        extract($argumentos);
        $where = "";
        if ($departamento != "") {
            $where = "WHERE departamento_id = '$departamento'";
        }
        $rs = UtilConexion::$pdo->exec("SELECT ciudad_nombre, ciudad_id FROM ciudad_select $where");
        $lista = $rs->GetMenu('lstCiudades', "", false, false, 1, 'id="lstCiudades"');
        echo $lista;
    }

    /**
     * http://localhost/gea/controlador/fachada.php?clase=Ciudad&oper=getLista&json=0
     * Devuelve un array asociativo de la forma:
     *      {"id1":"Dato1", "id2":"Dato2", ...,"idN":"DatoN"}
     * Util para crear combos en la capa de presentación
     * @param <type> $argumentos
     */
    public function getLista($argumentos) {
        $json = TRUE;
        $where = "";
        extract($argumentos);
        if (isset($departamento)) {
            $where = "WHERE departamento_id = '$departamento'";
        }
        $filas[''] = 'Seleccione una ciudad';
        $filas += UtilConexion::$pdo->query("SELECT ciudad_id, ciudad_nombre FROM ciudad_select $where ORDER BY ciudad_nombre")->fetchAll(PDO::FETCH_KEY_PAIR);
        $filas = Utilidades::getCombo($filas, $idSelect, $otrosDatos, $soloItems);
        file_put_contents('getListaFull.txt', $filas);
        echo $json ? json_encode($filas) : $filas;
    }

    public function getListaFull($argumentos) {
        $json = TRUE;
        extract($argumentos);
        $filas[''] = 'Seleccione una ciudad';
        //$filas += UtilConexion::$pdo->query("SELECT ciudad_id, ciudaddepto FROM ciudad_select $where ORDER BY ciudad_nombre")->fetchAll(PDO::FETCH_KEY_PAIR);
        $filas += UtilConexion::$pdo->query("select ciudad_id, departamento_nombre || ' ' || ciudad_nombre AS ciudaddepto from ciudad_select order by 1")->fetchAll(PDO::FETCH_KEY_PAIR);
        $filas = Utilidades::getCombo($filas, $idSelect, $otrosDatos, $soloItems);
        file_put_contents('getListaFull.txt', $filas);
        echo $json ? json_encode($filas) : $filas;
    }

    /**
     * Devuelve el código de una ciudad y un departamento dado su nombre de la ciudad y el departamento
     * @param string $argumentos un array que tiene el nombre de la ciudad y del departamento separados sólo por espacio
     */
    public function getLocalidad($argumentos) {
        extract($argumentos);
        $localidad = explode(' ', $localidad);
        if (count($localidad) == 2) {
            $ciudad = ucfirst($localidad[0]);
            $departamento = strtoupper($localidad[1]);
            if (($fila = UtilConexion::$pdo->query("SELECT * FROM ciudad_select WHERE ciudad_nombre = '$ciudad' AND departamento_nombre = '$departamento'")->fetch(PDO::FETCH_ASSOC))) {
                return array('idDepto'=>$fila['departamento_id'], 'depto'=>$fila['departamento_nombre'], 'idCiudad'=>$fila['ciudad_id'], 'ciudad'=>$fila['ciudad_nombre']);
            }
        } else {
            return array('idDepto'=>0, 'depto'=>'', 'idCiudad'=>0, 'ciudad'=>'');
        }
    }
    
        public function exportarCiudades($param) {
        $objPHPExcel = new PHPExcel();
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $objWorksheet->setTitle('Departamentos');
//$objWorksheet->setCellValue('A1','LEO');
        //$objWorksheet = $objPHPExcel->getSheetByName('Worksheet 1');
        $i = 2;
        $objWorksheet->setCellValue("A1", 'id');
        $objWorksheet->setCellValue("B1", 'nombre');
        $objWorksheet->setCellValue("C1", 'id_depto');
        $objWorksheet->setCellValue("D1", 'departamento');
        foreach (UtilConexion::$pdo->query("select * from ciudad") as $row) {
//            echo print_r($row, true);
            $objWorksheet->setCellValue("A$i", $row['id']);
            $objWorksheet->setCellValue("B$i", $row['nombre']);
            $objWorksheet->setCellValue("C$i", $row['fk_departamento']);
            $id = $row['fk_departamento'];
            foreach (UtilConexion::$pdo->query("select nombre from departamento where id='$id'") as $value) {
                $ciudad = $value['nombre'];
            }
            $objWorksheet->setCellValue("D$i", "$ciudad");
            $i++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('prueba.xlsX');

        echo "hola";
    }
    
    

    public function descargar($argumentos) {
        extract($argumentos);        
        file_put_contents('prueba-descargar.txt', print_r($argumentos, true));
        try {
            if (!is_file($nombreArchivo)) {
                $nombreArchivo = pathinfo($nombreArchivo, PATHINFO_BASENAME);
                throw new Exception("El archivo $nombreArchivo no se encuentre disponible");
            } else {
                $rutaArchivo = $nombreArchivo;
                $nombreArchivo = pathinfo($nombreArchivo, PATHINFO_BASENAME);

                // Se inicia la descarga de los archivos solicitados o de un archivo de texto informando sobre errores
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Content-Type: application/force-download");
                header("Content-Disposition: attachment; filename=\"$nombreArchivo\"\n");  // Oculta la ruta de descarga y permite espacios en nombres de archivos
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: " . filesize($rutaArchivo));
                @readfile($rutaArchivo);
            }
        } catch (Exception $e) {
            echo json_encode(['ok' => 0, 'mensaje' => $e->getMessage()]);  // Este mensaje no soporta formateo del html incluso usando htmlspecialchars()
        }
    }

}

?>
