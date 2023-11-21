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

// Consulta SQL para obtener los tableros del usuario actual
$email = $_SESSION['email'];
$sql = "SELECT * FROM tablero WHERE email = '$email'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kanban Dysie</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../estilos/styles.css" rel="stylesheet" />

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            position: relative;
        }
        body{
        background:#6c757d;
        }

        .board {
            width: 100%;
            text-align: center;
            margin: 10px;
            padding: 10px;
        }

        .column-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap; /* Permite que las columnas se ajusten al espacio disponible en pantallas pequeñas */
        }
/* Estilos para el contenedor del tablero */
.tablero-box {
    border: 2px solid #ccc;
    padding: 10px;
    margin: 10px 0px;
    border-radius: 20px;
    position: relative; /* Para que los elementos absolutos estén posicionados en relación con este contenedor */
}

/* Estilos para el botón de eliminación */
.btn-delete {
    color: #fff;/* Hacer el botón redondo */
    padding: 5px;
    cursor: pointer;
    position: absolute;
    top: 5px; /* Ajusta la distancia desde la parte superior */
    right: 5px; /* Ajusta la distancia desde la derecha */
}
.btn-delete:hover{
  background: none;
}

.btn-editar {
  background-color: #ffffff; /* Cambia el color de fondo predeterminado según tus preferencias */
  border: 2px solid #ccc; /* Añade un borde a las tarjetas */
  border-radius: 10px; /* Añade bordes redondeados a las tarjetas */
color:black;
cursor: pointer;
position: absolute;
border-radius:10px;
  top: 5px; /* Ajusta la distancia desde la parte superior */
    
}
h1{
color:white;
}
.tarjeta-nombre{
        background-color: #ffffff; /* Cambia el color de fondo predeterminado según tus preferencias */
        border: 2px solid #ccc; /* Añade un borde a las tarjetas */
        border-radius: 10px; /* Añade bordes redondeados a las tarjetas */
        padding: 10px;
        margin: 10px 0;
        color:black;
    }
    .tablero-title {
            border-radius: 10px;
            color:white;
            background:none;
            font-size: 50px;
            margin-top: 30px;
            text-shadow: 3px 4px 4px rgba(0, 0, 0, 0.5); /* Sombreado del texto */
        }
        input{
        border-radius:10px;
        height: 30px;
        }
.parrafo{
  background-color: #ffffff; /* Cambia el color de fondo predeterminado según tus preferencias */
        border: 2px solid #ccc; /* Añade un borde a las tarjetas */
        border-radius: 10px; /* Añade bordes redondeados a las tarjetas */
        padding: 10px;
        margin: 10px 0;
        color:black;
}
.btn-tarjeta{
        background-color: #ffffff; /* Cambia el color de fondo predeterminado según tus preferencias */
        border: 2px solid #ccc; /* Añade un borde a las tarjetas */
        border-radius: 10px; /* Añade bordes redondeados a las tarjetas */
        color:black;
        margin-left:20px;

}
.btn-tablero{
        background-color: #ffffff; /* Cambia el color de fondo predeterminado según tus preferencias */
        border: 2px solid #ccc; /* Añade un borde a las tarjetas */
        border-radius: 10px; /* Añade bordes redondeados a las tarjetas */
        color:black;
}
/* Estilos para los botones de editar y eliminar en las tarjetas */
/* Estilos para los botones de editar y eliminar en las tarjetas */
.botones-tarjeta {
    position: absolute;
    top: 5px;
    right: 5px;
}

.btn-editar-tarjeta,
.btn-eliminar-tarjeta {
    display: inline-block;
    padding: 5px;
    margin-right: 5px;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
}

.btn-editar-tarjeta {
    background-color: #007bff; /* Color azul para el botón de editar */
}

.btn-eliminar-tarjeta {
    background-color: #dc3545; /* Color rojo para el botón de eliminar */
}

/* Ajuste para la alineación del texto en la tarjeta */
.tarjeta {
    position: relative;
}

.tarjeta-nombre {
    margin: 0; /* Ajusta el margen del texto para evitar espacio adicional */
}


</style>
</head>

    <?php
    // Verificar si hay un mensaje de error en la variable de sesión
    if (isset($_SESSION["error"])) {
        echo '<div class="alert alert-danger">';
        echo $_SESSION["error"];
        echo '</div>';
        // Limpia el mensaje de error después de mostrarlo
        unset($_SESSION["error"]);
        if (isset($_SESSION["registro_exitoso"]) && $_SESSION["registro_exitoso"]) {
    echo '<div class="alert alert-success">Registro exitoso. Puedes iniciar sesión ahora.</div>';
    unset($_SESSION["registro_exitoso"]); // Limpia la variable de sesión
    
    if (isset($_SESSION["error"])) {
    echo '<div class="alert alert-danger">';
    echo $_SESSION["error"];
    echo '</div>';
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
    echo '<div class="alert alert-success">';
    echo $_SESSION["success"];
    echo '</div>';
    unset($_SESSION["success"]);
}

}
    }?>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="logo" href="index.php">
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
    <div class="board">
        <h1>Tableros</h1>
        <form action="../tableros/guardar_tablero.php" method="POST">
    <input type="text" name="nombre-tablero" placeholder="Nombre del tablero" required><br><br>
    <label for="color-tablero">Color Del Tablero:</label>
    <select name="color-tablero" required>
    <option value="#B0C4DE">Azul Acero</option>
    <option value="#BC8F8F">Rosado Rosáceo</option>
    <option value="#D2B48C">Marrón Arena</option>
    <option value="#D8BFD8">Lavanda Blanquecina</option>
    <option value="#F0E68C">Amarillo Caqui</option>
    <!-- Agrega más colores neutros que desees -->
</select>
    <button class="btn-tablero" type="submit">Añadir tablero</button>
</form>
<div class="row">
            <?php
            $tableros_per_row = 3; // Cantidad de tableros por fila
            $count = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($count % $tableros_per_row === 0) {
                        if ($count > 0) {
                            echo '</div><div class="row">';
                        }
                    }
                    echo '<div class="col-md-' . 12 / $tableros_per_row . '">';
                    echo '<div class="tablero-box" style="background-color:' . $row['color'] . ';">'; // Agrega el color del tablero al estilo
                    
                    // Agregar el botón de edición con el ícono de pincel al lado izquierdo del título
                    echo '<div class="btn-editar" style="background-color:none;">';
                    echo '<a class="btn" href="javascript:void(0);" onclick="mostrarEditor(\'' . $row['id_tablero'] . '\', \'' . $row['nom_tablero'] . '\')"><i class="bi bi-pencil-fill"></i> Editar</a>';
                    echo '</div>';
                    
                    echo '<h1 class="tablero-title" id="tablero-title-' . $row['id_tablero'] . '">' . $row['nom_tablero'] . '</h1>';
                    echo '<a class="btn btn-danger btn-delete" href="../tableros/eliminar_tablero.php?id_tablero=' . $row['id_tablero'] . '">&#10006;</a>'; // Botón de eliminación
        

                    // Consulta SQL para obtener las tarjetas del tablero actual
                    $idTablero = $row['id_tablero'];
                    $sql_tarjetas = "SELECT * FROM tarjeta WHERE id_tablero = '$idTablero'";
                    $result_tarjetas = $conn->query($sql_tarjetas);

                    echo '<div class="tarjetas-container">';

                    if ($result_tarjetas->num_rows > 0) {
                        while ($row_tarjeta = $result_tarjetas->fetch_assoc()) {
                            echo '<div class="tarjeta" style="background-color: ' . $row_tarjeta['color'] . ';">';                            echo '<p class="tarjeta-nombre">' . $row_tarjeta['nom_tarjeta'] . '</p>';
                            // Botón de editar
                            echo '<a class="btn-editar-tarjeta btn btn-primary" href="javascript:void(0);" onclick="mostrarEditorTarjeta(\'' . $row_tarjeta['id_tarjetas'] . '\', \'' . $row_tarjeta['nom_tarjeta'] . '\')"><i class="bi bi-pencil-fill"></i> Editar</a>';                            
                            // Botón de eliminar
                            echo '<a class="btn-eliminar-tarjeta btn btn-danger" href="../tarjetas/eliminar_tarjeta.php?id_tarjetas=' . $row_tarjeta['id_tarjetas'] . '">&#10006;</a>';
                            
                            echo '</div>';
                        }
                        
                    } else {
                        echo '<p class="parrafo">No hay tarjetas en este tablero.</p>';
                    }

                    // Formulario para agregar tarjetas (asegúrate de incluir el ID del tablero)
                    echo '<form action="../tarjetas/agregar_tarjeta.php" method="POST">';
                    echo '<input type="hidden" name="id_tablero" value="' . $idTablero . '">';
                    echo '<input type="text" name="nombre-tarjeta" placeholder="Nombre de la tarjeta" required>';
                    echo '<button class="btn-tarjeta" type="submit">Agregar tarjeta</button>';
                    echo '</form>';

                    echo '</div>'; // Cierre de tarjetas-container
                    echo '</div>'; // Cierre de tablero-box
                    echo '</div>'; // Cierre de col-md-4
                    $count++;
                }
            } else {
                echo '<p class="parrafo">No hay tarjetas en este tablero.</p>';
            }
            ?>
        </div>
    </div>
</div>
<!-- Formulario emergente para la edición de tableros -->
<div id="modalEditar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarEditor()">&times;</span>
        <h2>Editar Tablero</h2>
        <form id="formEditarTablero" action="../tableros/editar_tablero.php" method="POST">
            <input type="hidden" id="editTableroId" name="id_tablero">
            <label for="editTableroNombre">Nuevo Nombre:</label>
            <input type="text" id="editTableroNombre" name="nombre_tablero" required>
            <label for="editTableroColor">Nuevo Color:</label>
            <select id="editTableroColor" name="color_tablero" required>
            <option value="#B0C4DE">Azul Acero</option>
            <option value="#BC8F8F">Rosado Rosáceo</option>
            <option value="#D2B48C">Marrón Arena</option>
            <option value="#D8BFD8">Lavanda Blanquecina</option>
            <option value="#F0E68C">Amarillo Caqui</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>

<div id="modalEditarTarjeta" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarEditorTarjeta()">&times;</span>
        <h2>Editar Nombre de Tarjeta</h2>
        <form id="formEditarTarjeta" action="../tarjetas/editar_tarjeta.php" method="POST">
            <input type="hidden" id="editTarjetaId" name="id_tarjetas">
            <label for="editTarjetaNombre">Nuevo Nombre:</label>
            <input type="text" id="editTarjetaNombre" name="nombre_tarjeta" required>
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>

<script>
    function mostrarEditor(idTablero, nombreTablero, colorTablero) {
    document.getElementById('editTableroId').value = idTablero;
    document.getElementById('editTableroNombre').value = nombreTablero;

    // Selecciona la opción correspondiente en la lista desplegable
    var select = document.getElementById('editTableroColor');
    for (var i = 0; i < select.options.length; i++) {
        if (select.options[i].value === colorTablero) {
            select.selectedIndex = i;
            break;
        }
    }

    document.getElementById('modalEditar').style.display = 'block';
}

function cerrarEditor() {
    document.getElementById('modalEditar').style.display = 'none';
}

function guardarCambios() {
    var form = document.getElementById('formEditarTablero');
    var formData = new FormData(form);

    // Realiza una solicitud AJAX para enviar los datos al servidor PHP
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../tableros/editar_tablero.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Analiza la respuesta JSON del servidor
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Actualiza el color en tiempo real en el tablero
                var idTablero = document.getElementById('editTableroId').value;
                var tableroTitle = document.getElementById('tablero-title-' + idTablero);
                tableroTitle.style.backgroundColor = response.color;
            } else {
                console.error("Error al guardar cambios: " + response.error);
            }

            // Cierra el formulario emergente
            cerrarEditor();
        }
    };
    xhr.send(formData);
}
</script>
<script>
    function mostrarEditor(idTablero, nombreTablero, colorTablero) {
    document.getElementById('editTableroId').value = idTablero;
    document.getElementById('editTableroNombre').value = nombreTablero;

    // Selecciona la opción correspondiente en la lista desplegable
    var select = document.getElementById('editTableroColor');
    for (var i = 0; i < select.options.length; i++) {
        if (select.options[i].value === colorTablero) {
            select.selectedIndex = i;
            break;
        }
    }

    document.getElementById('modalEditar').style.display = 'block';
}
    function cerrarEditorTarjeta() {
        document.getElementById('modalEditarTarjeta').style.display = 'none';
    }
</script>
<!-- Scripts al final del documento -->
<script>
        // Deshabilita el botón de retroceso del navegador
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

<footer class="py-5 bg-dark">
            <div class="container px-5"><p class="m-0 text-center text-white">Copyright &copy; 2023 Kanban Dysie</p></div>
        </footer>
</html>