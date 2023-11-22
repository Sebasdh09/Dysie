<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: ../registro/login.php");
    exit();
}

// Conexión a la base de datos (configura con tus propios valores)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dysie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre del tablero y el color del formulario
    $nombreTablero = $_POST["nombre-tablero"];
    $colorTablero = $_POST["color-tablero"]; // Obtener el color del formulario
    $email = $_SESSION['email']; // Obtenemos el correo electrónico del usuario desde la sesión

    // Consulta SQL para insertar el tablero en la base de datos
    $sql = "INSERT INTO tablero (nom_tablero, email, color) VALUES ('$nombreTablero', '$email', '$colorTablero')";

    if ($conn->query($sql) === TRUE) {
        // Redirige de vuelta a index.php después de guardar el tablero
        header("Location: ../inicio/index.php");
        exit();
    } else {
        echo "Error al guardar el tablero: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirige de vuelta a index.php si no se ha enviado el formulario
    header("Location: ../inicio/index.php");
    exit();
}
