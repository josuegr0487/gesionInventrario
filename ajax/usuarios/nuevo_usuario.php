<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

//Valida los campos del form
if (empty($_POST['firstname'])) {
    $errors[] = "Nombres vacíos";
} elseif (empty($_POST['lastname'])) {
    $errors[] = "Apellidos vacíos";
} elseif (empty($_POST['user_name'])) {
    $errors[] = "Nombre de usuario vacío";
} elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
    $errors[] = "Contraseña vacía";
} elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
    $errors[] = "la contraseña y la repetición de la contraseña no son lo mismo";
} elseif (strlen($_POST['user_password_new']) < 6) {
    $errors[] = "La contraseña debe tener como mínimo 6 caracteres";
} elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
    $errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
} elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
    $errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
} elseif (empty($_POST['user_email'])) {
    $errors[] = "El correo electrónico no puede estar vacío";
} elseif (strlen($_POST['user_email']) > 64) {
    $errors[] = "El correo electrónico no puede ser superior a 64 caracteres";
} elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Su dirección de correo electrónico no está en un formato de correo electrónico válida";
} elseif (   //si los datos son correctos
    !empty($_POST['user_name'])
    && !empty($_POST['firstname'])
    && !empty($_POST['lastname'])
    && strlen($_POST['user_name']) <= 64
    && strlen($_POST['user_name']) >= 2
    && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
    && !empty($_POST['user_email'])
    && strlen($_POST['user_email']) <= 64
    && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
    && !empty($_POST['user_password_new'])
    && !empty($_POST['user_password_repeat'])
    && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
) {
    require_once("../../config/db.php"); //configuracion para conectar a la base de datos
    require_once("../../config/conexion.php"); //funcion que conecta a la base de datos

    $firstname = mysqli_real_escape_string($con, (strip_tags($_POST["firstname"], ENT_QUOTES)));
    $lastname = mysqli_real_escape_string($con, (strip_tags($_POST["lastname"], ENT_QUOTES)));
    $user_name = mysqli_real_escape_string($con, (strip_tags($_POST["user_name"], ENT_QUOTES)));
    $user_email = mysqli_real_escape_string($con, (strip_tags($_POST["user_email"], ENT_QUOTES)));
    $user_password = $_POST['user_password_new'];
    $date_added = date("Y-m-d H:i:s");
    $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT); //encripta la contraseña del usuario con la función password_hash () 
    //verifica si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
    $query_check_user_name = mysqli_query($con, $sql);
    $query_check_user = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == 1) {
        $errors[] = "Lo sentimos , el nombre de usuario ó la dirección de correo electrónico ya está en uso.";
    } else { //se crea nuevo usuario
        $sql = "INSERT INTO usuarios (firstname, lastname, user_name, user_password_hash, user_email, date_added)
                        VALUES('" . $firstname . "','" . $lastname . "','" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "','" . $date_added . "');";
        $query_new_user_insert = mysqli_query($con, $sql);

        if ($query_new_user_insert) { //si el usuario se creo exitosamente
            $messages[] = "La cuenta ha sido creada con éxito.";
        } else { //si existio error al crear el usuario
            $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
        }
    }
} else {
    $errors[] = "Un error desconocido ocurrió.";
}

if (isset($errors)) {
?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
<?php
}
if (isset($messages)) {

?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
<?php
}

?>