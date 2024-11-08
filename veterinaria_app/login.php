<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>App Veterinaria</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('img/dogs2.webp');
            background-size: 100% 120%;
            background-repeat: no-repeat;
        }

        h1 {
            background-color: rgb(12, 82, 3);
            color: aliceblue;
            text-align: center;
        }

        p {
            color: aliceblue;
            background-color: rgb(14, 71, 2);
            font-size: large;
            text-align: center;
        }

        nav {
            background-color: rgb(132, 190, 126);
            color: aliceblue;
            text-align: center;
        }

        nav a {
            color: aliceblue;
            margin: 0 15px;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Proyecto Clínica Veterinaria</h1>
    <p>Sistema de citas</p>

    <div id="hideBox">
        <div id="highBox">
            <center>
                <form id="loginForm" method="post" action="">
                    <input type="text" name="usuario_nombre" id="usuario_nombre" class="textbox"
                        placeholder="Nombre de usuario" style="width: 300px;" autocomplete="off" required /><br><br>
                    <input type="password" name="contraseña" id="contraseña" class="textbox"
                        placeholder="Contraseña" style="width: 300px;" autocomplete="off" required /><br><br>
                    <input type="submit" name="btn" value="Iniciar sesión" class="submitbutton" />
                </form>
            </center>
        </div>
        <br>
        <center>
            <nav>
                <a href="#">Contacto</a>
                <a href="php/crear_usuario.php">Crear usuario</a>
                <a href="#">Agendar una cita</a>
                <a href="#">Nuestro equipo</a>
            </nav>
        </center>
    </div>

    <?php
    // Iniciar la sesión
    session_start();

    // Conectar a la base de datos
    $mysqli = new mysqli('localhost', 'root', '', 'veterinaria_db');

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Verificar si se hizo clic en el botón de inicio de sesión
    if (isset($_POST['btn'])) {
        // Validar que los campos no estén vacíos
        if (empty($_POST['usuario_nombre']) || empty($_POST['contraseña'])) {
            echo 'Por favor, ingrese usuario y contraseña.';
        } else {
            $usuario_nombre = $mysqli->real_escape_string($_POST['usuario_nombre']);
            $contraseña = $_POST['contraseña'];

            // Consulta para obtener las credenciales del usuario
            $query = "SELECT * FROM usuarios WHERE usuario_nombre = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("s", $usuario_nombre);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $usuarioData = $result->fetch_assoc();

                // Verificar la contraseña
                if (password_verify($contraseña, $usuarioData['contraseña'])) {
                    // Inicio de sesión exitoso, establecer la sesión
                    $_SESSION['id_usuario'] = $usuarioData['id_usuario'];  // Ajusta según la columna de ID en tu DB
                    $_SESSION['usuario_nombre'] = $usuarioData['usuario_nombre'];

                    // Redirigir a la página principal
                    header('Location: principal.php');
                    exit();
                } else {
                    echo "Contraseña incorrecta.";
                }
            } else {
                echo "Usuario no encontrado.";
            }
            $stmt->close();
        }
    }

    // Cerrar la conexión
    $mysqli->close();
    ?>

</body>
</html>
