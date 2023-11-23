<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DYSIE</title>
    <link rel="shortcut icon" href="assets/imagenes/logo_dysie.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #adb5bd;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        main {
            width: 100%;
            padding: 20px;
            margin: auto;
            margin-top: 15px;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
        }

        .contenedor__todo {
            width: 100%;
            max-width: 800px;
            position: relative;
        }

        .caja__trasera {
            width: 100%;
            padding: 10px 20px;
            display: flex;
            justify-content: center;
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            background: #212529;

        }

        .caja__trasera div {
            margin: 100px 40px;
            color: white;
            transition: all 500ms;
        }


        .caja__trasera div p,
        .caja__trasera button {
            margin-top: 30px;
        }

        .caja__trasera div h3 {
            font-weight: 400;
            font-size: 26px;
        }

        .caja__trasera div p {
            font-size: 16px;
            font-weight: 300;
        }

        .caja__trasera button {
            padding: 10px 40px;
            border: 2px;
            font-size: 14px;
            background: #0d6efd;
            font-weight: 600;
            cursor: pointer;
            color: white;
            outline: none;
            transition: all 300ms;
        }

        .caja__trasera button:hover {
            background-color: #6c757d;
        }

        /*Formularios*/

        .contenedor__login-register {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 380px;
            position: relative;
            top: -185px;
            left: 10px;

            /*La transicion va despues del codigo JS*/
            transition: left 500ms cubic-bezier(0.175, 0.885, 0.320, 1.275);
        }

        .contenedor__login-register form {
            width: 100%;
            padding: 80px 20px;
            background: #495057;
            position: absolute;
            border-radius: 20px;
        }

        .contenedor__login-register form h2 {
            font-size: 30px;
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        .contenedor__login-register form input {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            border: none;
            background: #F2F2F2;
            font-size: 16px;
            outline: none;
        }

        .contenedor__login-register form button {
            padding: 10px 40px;
            margin-top: 40px;
            border: none;
            font-size: 14px;
            background: #0d6efd;
            font-weight: 600;
            cursor: pointer;
            color: white;
            outline: none;
        }

        .contenedor__login-register form button:hover {
            background-color: #6c757d
        }



        .formulario__login {
            opacity: 1;
            display: block;
        }

        .formulario__register {
            display: none;
        }



        @media screen and (max-width: 850px) {

            main {
                margin-top: 50px;
            }

            .caja__trasera {
                max-width: 350px;
                height: 300px;
                flex-direction: column;
                margin: auto;
            }

            .caja__trasera div {
                margin: 0px;
                position: absolute;
            }


            /*Formularios*/

            .contenedor__login-register {
                top: -10px;
                left: -5px;
                margin: auto;
            }

            .contenedor__login-register form {
                position: relative;
            }
        }

        /* Estilos para la alerta de error */
        .alert-danger {
            background-color: #0d6efd;
            /* Color de fondo rojo */
            color: white;
            /* Color del texto */
            padding: 15px;
            /* Espaciado interno */
            text-align: center;
            /* Alineación del texto al centro */
            margin-bottom: 10px;
            /* Espaciado inferior */
        }

        /* Estilos para la alerta de éxito */
        .alert-success {
            background-color: #0d6efd;
            /* Color de fondo verde */
            color: white;
            /* Color del texto */
            padding: 15px;
            /* Espaciado interno */
            text-align: center;
            /* Alineación del texto al centro */
            margin-bottom: 10px;
            /* Espaciado inferior */
        }

        .boton_inicio:hover {
            background-color: #9cd2d3;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            display: inline-block;
            height: 250px;
            width: 250px;
        }
    </style>
    </script>
</head>

<body>
    <?php
    if (isset($_SESSION["error"])) {
        echo '<div class="alert alert-danger">' . $_SESSION["error"] . '</div>';
        unset($_SESSION["error"]); // Limpia la variable de sesión
    }

    if (isset($_SESSION["registro_exitoso"]) && $_SESSION["registro_exitoso"]) {
        echo '<div class="alert alert-success">Registro exitoso. Puedes iniciar sesión ahora.</div>';
        unset($_SESSION["registro_exitoso"]); // Limpia la variable de sesión
    }
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

    ?>
    <!-- Logo -->
    <div class="logo">
        <a href="../index.html"><img src="../assets/Dysie (5).png" alt=""></a>
    </div>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>
            </div>
            <div class="contenedor__login-register">
                <form id="formularioL" method="POST" action="procesar_login.php" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="email" class="form-control" id="txt_emailL" placeholder="Email" name="txt_emailL" required>
                    <input type="password" class="form-control" id="txt_contraseñaL" placeholder="Contraseña" name="txt_contraseñaL" minlength="8" required>
                    <button type="submit" class="boton_inicio">Entrar</button>
                </form>

                <form id="formulario" method="POST" action="procesar_registro.php" class="formulario__register">
                    <h2>Registrarse</h2>
                    <input type="text" class="form-control" id="txt_nombre" placeholder="Nombres" name="txt_nombre" required>
                    <input type="text" class="form-control" id="txt_apellido" placeholder="Apellidos" name="txt_apellido" required>
                    <input type="email" class="form-control" id="txt_email" placeholder="Email" name="txt_email" required>
                    <input type="password" class="form-control" id="txt_contraseña" placeholder="Contraseña" name="txt_contraseña" minlength="8" required><br><br>
                    <p style="color:white;">Fecha de nacimiento:</p>
                    <input type="date" id="txt_fecha" name="txt_fecha" required>
                    <button type="submit" class="boton_inicio">Registrar</button>
                </form>
            </div>
        </div>
    </main>
    <script src="../javasS/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>