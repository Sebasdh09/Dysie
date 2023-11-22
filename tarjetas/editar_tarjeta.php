<?php
// Verifica si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos (asegúrate de tener tus propias credenciales)
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
    $idTarjeta = $_POST['id_tarjetas'];
    $nuevoNombre = $_POST['nombre_tarjeta'];

    // Agrega mensajes de depuración
    error_log("Inicio de la actualización de tarjeta");

    // Actualiza el nombre de la tarjeta en la base de datos
    $sql = "UPDATE tarjeta SET `nom_tarjeta` = '$nuevoNombre' WHERE `id_tarjetas` = $idTarjeta";

    if ($conn->query($sql) === TRUE) {
        // Redirige a la página principal después de editar la tarjeta (ajusta la URL según tu estructura)
        header("Location: ../inicio/index.php");
        exit();
    } else {
        echo "Error al editar la tarjeta: " . $conn->error;
        // o error_log("Error al editar la tarjeta: " . $conn->error);
    }

    // Agrega mensajes de depuración
    error_log("Fin de la actualización de tarjeta");
    
    $conn->close();
}
?>
