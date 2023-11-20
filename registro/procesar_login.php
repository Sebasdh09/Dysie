<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Recuperar el valor del formulario de inicio de sesión
$email = $_POST["txt_emailL"];
$contrasena = $_POST["txt_contraseñaL"];

// Conectar a la base de datos y verificar las credenciales
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dysie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Verificar si el email existe en la base de datos
$stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    // Verificar la contraseña utilizando password_verify
    if (password_verify($contrasena, $row["contra"])) {
        // Inicio de sesión exitoso, establecer una variable de sesión
        $_SESSION["email"] = $row["email"]; // Puedes guardar más información de usuario si es necesario

        // Redirigir al "dashboard" u otra página
        header("Location: ../inicio/index.php");
        exit();
    } else {
        // Contraseña incorrecta, establecer un mensaje de error
        $_SESSION["error"] = "Correo o Contraseña incorrectos. Por favor, intenta de nuevo.";
        header("Location: login.php");
        exit();
    }
} else {
    // Usuario no encontrado, establecer un mensaje de error
    $_SESSION["error"] = "Correo electrónico no encontrado. Por favor, intenta de nuevo.";
    header("Location: login.php");
    exit();
}

$stmt->close();
$conn->close();

} else {
    // Redirigir de vuelta al formulario de inicio de sesión si no se envió el formulario
    header("Location: login.php");
    exit();
}

?>

