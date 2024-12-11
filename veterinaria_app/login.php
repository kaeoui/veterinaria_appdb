<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body> 
    <header>
    <div class="header-container">
        <img src="img/logo_icon.png" alt="Logo Veterinaria" class="logo">
        <h1>Veterinaria Patitas Felices</h1>
        <nav>
            <ul>
                <li><a href="pagina_principal.php">Home</a></li>
            </ul>
        </nav>
        
    </div>
    </header>

    <section id="login">
        <div id="login-box">
        <h2>Bienvenido al Sistema Citas</h2>
        <p>Inicio de Sesión</p>
    
                <center>
                <form id="loginForm" method="post" action="">
                    <input type="text" name="usuario_nombre" id="usuario_nombre" class="textbox"
                        placeholder="Nombre de usuario" style="width: 300px; height: 30px;" autocomplete="off" required /><br><br>
                    <input type="password" name="contraseña" id="contraseña" class="textbox"
                        placeholder="Contraseña" style="width: 300px; height: 30px;" autocomplete="off" required /><br><br>
                    <input type="submit" name="btn" value="Iniciar sesión" class="submitbutton" />
                </form>
                </center>
           
        <p>Sino tienes una cuenta debes Registrarte</p>
        <li><a href="php/crear_usuario.php">Crear una Cuenta</a></li>
     </div>
    </section>


    <footer>
        <p>&copy; 2024 Veterinaria Patitas Felices. Todos los derechos reservados.</p>
        <p>Teléfono: +506 7000 1234 | Correo: contacto@patitasfelices.com</p>
    </footer>

</body>

</html>



    <?php
    session_start();

    $mysqli = new mysqli('localhost', 'root', 'karina', 'veterinaria_db');

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    if (isset($_POST['btn'])) {
        if (empty($_POST['usuario_nombre']) || empty($_POST['contraseña'])) {
            echo 'Por favor, ingrese usuario y contraseña.';
        } else {
            $usuario_nombre = $mysqli->real_escape_string($_POST['usuario_nombre']);
            $contraseña = $_POST['contraseña'];
            $query = "SELECT * FROM usuarios WHERE usuario_nombre = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("s", $usuario_nombre);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $usuarioData = $result->fetch_assoc();

                if (password_verify($contraseña, $usuarioData['contraseña'])) {
                    $_SESSION['id_usuario'] = $usuarioData['id_usuario'];  // Ajusta según la columna de ID en tu DB
                    $_SESSION['usuario_nombre'] = $usuarioData['usuario_nombre'];

                    header('Location: pagina_principal.php');
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
