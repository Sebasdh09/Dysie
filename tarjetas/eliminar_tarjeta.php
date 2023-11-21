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

// Verifica si se proporciona un ID de tarjeta válido
if (isset($_GET['id_tarjetas']) && is_numeric($_GET['id_tarjetas'])) {
    // Usa una sentencia preparada para evitar la inyección de SQL
    $id_tarjeta = $_GET['id_tarjetas'];


    // Consulta SQL para eliminar la tarjeta principal
    $sql = "DELETE FROM tarjeta WHERE id_tarjetas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_tarjeta);

    // Ejecuta la consulta principal
    if ($stmt->execute()) {
        // Redirige a la página de inicio después de la eliminación exitosa
        header("Location: ../inicio/index.php");
        exit();
    } else {
        // Manejo de errores
        echo "Error al eliminar tarjeta: " . $stmt->error;
    }

    // Cierra las sentencias preparadas
    $stmt_dependencias->close();
    $stmt->close();
} 

// Cierra la conexión a la base de datos
$conn->close();
?>
