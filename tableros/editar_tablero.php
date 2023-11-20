<?php

// Verifica si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica la conexión
    if ($conn->connect_error) {
        die("La conexión a la base de datos ha fallado: " . $conn->connect_error);
    }

    // Obtiene los datos del formulario
    $idTablero = $_POST['id_tablero'];
    $nuevoNombre = $_POST['nombre_tablero'];
    $nuevoColor = $_POST['color_tablero'];

    // Actualiza el nombre del tablero en la base de datos
    $sql = "UPDATE tablero SET nom_tablero = '$nuevoNombre', color = '$nuevoColor' WHERE id_tablero = '$idTablero'";


    if ($conn->query($sql) === TRUE) {
        // Redirige a la página principal después de editar el tablero (ajusta la URL según tu estructura)
        header("Location: ../inicio/index.php");
        exit();
    } else {
        echo "Error al editar el tablero: " . $conn->error;
    }

    $conn->close();
}
?>
