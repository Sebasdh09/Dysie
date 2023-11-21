<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: login.php");
    exit();
}


    // Conexión a la base de datos (debes configurar tus propios valores)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
// Función para calcular la diferencia de días entre dos fechas
function daysDifference($date1, $date2) {
    $datetime1 = strtotime($date1);
    $datetime2 = strtotime($date2);
    $difference = abs($datetime1 - $datetime2);
    return floor($difference / (60 * 60 * 24));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_account"])) {
    $new_nombre = $_POST["new_nombre"];
    $new_raw_password = $_POST["new_password"];
    $account_id = $_POST["account_id"]; // Agrega esta línea para obtener el account_id


    // Valida los datos ingresados en el formulario aquí (longitud, formato de correo, etc.)

    // Encriptar la nueva contraseña
    $new_password = password_hash($new_raw_password, PASSWORD_DEFAULT);

    // Consulta para verificar la fecha de la última actualización
    $sql_last_update = "SELECT fecha_update FROM usuario WHERE id_usuario = ?";
    $stmt_last_update = $conn->prepare($sql_last_update);
    $stmt_last_update->bind_param("i", $account_id);
    $stmt_last_update->execute();
    $stmt_last_update->bind_result($last_update);
    $stmt_last_update->fetch();
    $stmt_last_update->close();

    // Obtiene la fecha actual
    $current_date = date("Y-m-d");

    try {
        // Intenta actualizar los datos en la base de datos
        $sql = "UPDATE usuario SET nombre_usu = ?,  contra = ?, fecha_update = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $new_nombre, $new_password, $current_date, $account_id);

        if ($stmt->execute()) {
            $_SESSION["success"] = "Usuario actualizado con éxito.";
        } else {
            throw new Exception("Error al actualizar el usuario: " . $stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION["success"] = "Usuario actualizado con éxito.";
    }

    // Redirige a la página donde se listan los usuarios o al índice
    header("Location: edit_usu.php");
    exit();
}

// Obtener la información del usuario a editar
if (isset($_GET["id_usuario"])) {   
    $account_id = $_GET["id_usuario"];

    // Consulta para verificar si el usuario existe
    $sql_check = "SELECT id_usuario, nombre_usu FROM usuario WHERE id_usuario = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $account_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $nombre = $row["nombre_usu"];
    } else {
        $_SESSION["error"] = "Usuario no encontrado.";
        header("Location: view_accounts.php");
        exit();
    }

    $stmt_check->close();
} else {
    // Si no hay id_usuario en la URL, redirige o maneja la situación de alguna manera
    $_SESSION["error"] = "ID de usuario no proporcionado.";
    header("Location: edit_usu.php");
    exit();
}


// Cerrar la conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../estilos/styles.css" rel="stylesheet">
    <title>Editar Usuario</title>
    <style>
        /* Estilos para el cuerpo de la página */
body {
    font-family: Arial, sans-serif;
            background-color: #6c757d;
            margin: 0;
}


/* Encabezado del formulario */
h2 {
    text-align: center;
    color: white;
    margin-top: 50px;
}

/* Formulario */
form {
    margin-top: 20px;
}

/* Etiquetas de entrada */
label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: white;
}

/* Entradas de texto y contraseña */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

/* Botón de enviar */
button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    padding: 10px 20px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

/* Mensajes de alerta */
.alert {
    margin-top: 20px;
    padding: 10px;
    border-radius: 3px;
}

.alert-success {
    background-color: #dff0d8;
    color: #3c763d;
    border: 1px solid #d6e9c6;
}

.alert-danger {
    background-color: #f2dede;
    color: #a94442;
    border: 1px solid #ebccd1;
}

/* Botón de regreso */
.btn-back {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    text-decoration: none;
    display: inline-block;
    margin-top: 20px;
}

.btn-back:hover {
    background-color: #555;
}
.text_nav .text_nav0{
    color: white;
    text-decoration: none; 
    margin-right: 20px;

}

.text_nav {
    width: 100%;
    text-align: center;
    padding: 5px;
    text-decoration: none;  
}
.text_nav:hover{
    background-color: #9cd2d3;
    padding: 12px;
    border-radius: 10px;
}

a {
            text-decoration: none;
            font-weight: bold;
        }
        footer {
        background-color: black;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 40px;
}

    </style>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="logo" href="../inicio/index.php">
        <img src="../assets/Dysie (3).png" alt="">
    </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="btn btn-outline-light" href="../logout.php" style="margin-right: 10px;">Cerrar Sesion</a></li>
                        <li class="nav-item"><a class="btn btn-primary" href="../usuario/view_accounts.php">Perfil</a></li>
                    </ul>
                </div>
            </div>
        </nav>
</head>
<body>
<div class="container">
        <h2>Editar Usuario</h2>

        <!-- Formulario para editar el usuario -->
        <form method="post" action="./edit_usu.php">
            <label for="new_nombre">Nuevo Nombre:</label>
            <input type="text" name="new_nombre" value="<?php echo $nombre; ?>" required>

            <label for="new_password">Nueva Contraseña:</label>
            <input type="password" name="new_password" minlength="8" required>

            <input type="hidden" name="account_id" value="<?php echo $account_id; ?>">

            <button type="submit" name="edit_account">Guardar Cambios</button>
        </form>

        <?php
        if (isset($_SESSION["success"])) {
            echo '<div class="alert alert-success">';
            echo $_SESSION["success"];
            echo '</div>';
            unset($_SESSION["success"]);
        }

        ?>

        <!-- Botón de regreso a la lista de usuarios o al índice -->
        <a class="btn-back" href="view_accounts.php">Regresar al perfil</a>
    </div>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
            <div class="container px-5"><p class="m-0 text-center text-white">Copyright &copy; 2023 Kanban Dysie</p></div>
        </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>