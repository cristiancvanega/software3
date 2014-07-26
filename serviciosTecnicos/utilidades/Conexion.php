<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author CRISTIAN
 */
class Conexion {
    public static $pdo;                     // Una referencia a un objeto de tipo PDO (PHP Data Object)
    public static $propiedadesConexion;
    private static $conexion;
    private static $comspec;                // Procesador de comandos (En Win7 C:\Windows\system32\cmd.exe)
    private static $rutaAplicacion;
    private static $rutaRaiz;
    private static $conn;

    /**
     * La función construct es privada para evitar que el objeto pueda ser creado mediante new.
     * Cuando este método se llama, crea una conexión a una base de datos.
     */

    private function __construct() {
        date_default_timezone_set('America/Bogota');
        self::$comspec = $_SERVER['COMSPEC'];
        self::$rutaRaiz = $_SERVER['DOCUMENT_ROOT']; // "C:/wamp/www/";
        self::$rutaAplicacion = self::$rutaRaiz . "ProyectoSWIII/"; // "C:/wamp/www/Proyecto SW III/";
    }

    /**
     * Es posible que un script envié varios mensajes getInstance(...) a un objeto de tipo Conexion,
     * sinembargo siempre se retornará la misma instancia de Conexión, garantizando así la
     * implementacion del Patrón Singleton
     * @param <type> $driver El tipo de driver: postgres, mysql, etc.
     * @param <type> $servidor El host: localhost o cualquier IP válida
     * @param <type> $usuario El usuario que tiene privilegios de acceso a la base de datos
     * @param <type> $clave La clave del usuario
     * @return <type> Una instancia de tipo Conexion
     */
    public static function getInstance() {
        // la siguiente condición garantiza que sólo se crea una instancia
        if (!isset(self::$conexion)) {
            self::$conexion = new self();  // llamado al constructor
            $baseDeDatos = 'prysoftware';
            $servidor = '10.2.109.176';
            $puerto = '5432';
            $usuario = 'postgres';
            $contrasena = 'postgres';  // Aquí va la clave de tu usuario Postgres   <<<<<<<<<<<<<<<<<<<<<<
            self::$pdo = new PDO("pgsql:host=$servidor port=$puerto dbname=$baseDeDatos", $usuario, $contrasena);
//            self::$conn = pg_connect("host=192.168.1.57 port=5432 dbname=prysoftware user=postgres password=postgres");
        }
        return self::$conexion;
    }

    /**
     * Se sobreescribe este 'método mágico' para evitar que se creen clones de esta clase
     */
    private function __clone() { /*...*/ }

}
