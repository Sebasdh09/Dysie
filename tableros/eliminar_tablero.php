<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: ../registro/login.php");
    exit();
}

// Verifica si se proporciona un id_tablero válido
if (isset($_GET['id_tablero'])) {
    $id_tablero = $_GET['id_tablero'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para eliminar el tablero
    $sql = "DELETE FROM tablero WHERE id_tablero = $id_tablero";
    if ($conn->query($sql) === TRUE) {
        // Tablero eliminado con éxito
        header("Location: ../inicio/index.php");
        exit();
    } else {
        echo "Error al eliminar el tablero: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirige si no se proporciona un id_tablero válido
    header("Location: ../inicio/index.php");
    exit();
}
