<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: ../registro/login.php");
    exit();
}

// Obtener el nombre de la tarjeta y el id_tablero del formulario
$nombreTarjeta = $_POST["nombre-tarjeta"];
$idTablero = $_POST["id_tablero"]; // Obtén el id_tablero del formulario

// Conexión a la base de datos (configura con tus propios valores)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dysie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para insertar la tarjeta en la base de datos con el id_tablero
$sql = "INSERT INTO tarjeta (nom_tarjeta, id_tablero) VALUES ('$nombreTarjeta', '$idTablero')";

if ($conn->query($sql) === TRUE) {
    // Redirige de vuelta a la página donde se muestran los tableros y tarjetas
    header("Location: ../inicio/index.php");
    exit();
} else {
    echo "Error al guardar la tarjeta: " . $conn->error;
}

$conn->close();


?>
