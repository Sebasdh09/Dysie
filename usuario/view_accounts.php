<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: ../registro/login.php");
    exit();
}

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

// Obtener el correo electrónico del usuario que ha iniciado sesión
$user_email = $_SESSION['email'];

// Consulta para obtener los datos del usuario que ha iniciado sesión
$sql = "SELECT id_usuario, nombre_usu, email FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$user = null;
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}

$stmt->close();

// Cerrar la conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../estilos/styles.css" rel="stylesheet"/>
    <title>Perfil de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #6c757d;
            margin: 0;
        }

        h2 {
            text-align: center;
            font-size: 60px;
            color: white;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: 120px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color:#0d6efd;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            font-weight: bold;
        }


        .btn-edit{
            padding: 5px 10px;
            background-color: #0d6efd;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-eliminar {
            background-color: transparent ;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;

        }

        .btn-edit:hover, .btn-eliminar:hover {
            background-color: #9cd2d3;
        }
        footer {
        background-color: black;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 40px;
}
.perfil{
    margin-top:100px;
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
    <div class="perfil">
        <h2>Perfil de Usuario</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Acciones</th>
            </tr>
            <?php if ($user) { ?>
                <tr>
                <td><?php echo $user["id_usuario"]; ?></td>
                <td><?php echo $user["nombre_usu"]; ?></td>
                <td><?php echo $user["email"]; ?></td>
                <td>
                    <a class="btn-edit" href="edit_usu.php?id_usuario=<?php echo $user["id_usuario"]; ?>">Editar</a>
                    <a class="btn-eliminar" href="delete_usu.php?id_usuario=<?php echo $user["id_usuario"]; ?>">Eliminar</a>
                </td>
            </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No se encontró ningún usuario.</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
<footer class="py-5 bg-dark" >
    <div class="container px-5">
        <p class="m-0 text-center text-white">Copyright &copy; 2023 Kanban Dysie</p>
    </div>
</footer>
</html>
