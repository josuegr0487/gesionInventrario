<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

class Login
{ //Clase para controllar el inicio y cierre de sesion del usuario

    private $db_connection = null;
    public $errors = array();
    public $messages = array();

    public function __construct() //se inicia cuando se crea un objeto de la clase login
    {
        session_start(); //para crear y leer la sesion

        if (isset($_GET["logout"])) { //si se cierra la session
            $this->doLogout();
        } elseif (isset($_POST["login"])) { //inicia sesion tras realizar submit al formulario
            $this->dologinWithPostData();
        }
    }

    private function dologinWithPostData() //inicia sesion
    {
        //valida el formulario
        if (empty($_POST['user_name'])) {
            $this->errors[] = "El campo usuario es obligatorio";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "El campo password es obligatorio";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {


            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); //crea conexion a la base de datos

            if (!$this->db_connection->set_charset("utf8")) { //cambia el conjunto de caracteres a utf8 
                $this->errors[] = $this->db_connection->error;
            }

            if (!$this->db_connection->connect_errno) { //conexion exitosa a la base de datos

                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                $sql = "SELECT user_id, user_name, firstname, user_email, user_password_hash
                        FROM usuarios
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                //obtiene la informacion de la base de datos
                $result_of_login_check = $this->db_connection->query($sql);

                if ($result_of_login_check and $result_of_login_check->num_rows == 1) {  // si el susuario existe

                    $result_row = $result_of_login_check->fetch_object();

                    //Comprueba que la contraseña coincida con un hash
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        // graba la informacion del usuario en PHP SESION
                        $_SESSION['user_id'] = $result_row->user_id;
                        $_SESSION['firstname'] = $result_row->firstname;
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_login_status'] = 1;
                    } else {
                        $this->errors[] = "Usuario y/o contraseña no coinciden.";
                    }
                } else {
                    $this->errors[] = "Usuario y/o contraseña no coinciden.";
                }
            } else {
                $this->errors[] = "Problema con la  conexión de la base de datos.";
            }
        }
    }


    public function doLogout() //cierra sesion
    {
        //Elimina los datos de la sesion
        $_SESSION = array();
        session_destroy();
        $this->messages[] = "El usuario ha cerrado sesion";
    }

    public function isUserLoggedIn() //devuelve el status de la sesion actual 
    {
        if (isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] == 1) {
            return true; //sesion abierta
        }
        return false; //no existe sesion (default)
    }
}
