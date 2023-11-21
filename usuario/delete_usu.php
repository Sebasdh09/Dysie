<?php
session_start();
include_once "config.php";

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: login.php");
    exit();
}

// Verifica si se ha proporcionado un ID de usuario para eliminar
if (isset($_GET["id_usuario"])) {
    $account_id = $_GET["id_usuario"];

    // Consulta para eliminar el usuario
    $sql = "DELETE FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $account_id);
    if ($stmt->execute()) {
        $_SESSION["success"] = "Usuario eliminado con éxito.";
    } else {
        $_SESSION["error"] = "Error al eliminar el usuario: " . $stmt->error;
    }

    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();

// Redirige de nuevo a la lista de usuarios
header("Location: login.php");
exit();
?>
