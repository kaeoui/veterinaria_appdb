<?php session_start(); 
include_once "../conexion.php";
?> 

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Veterinaria Patitas Felices</title>
        <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
            <div class="header-container">
                <img src="../img/logo_icon.png" alt="Logo Veterinaria" class="logo">
                <h1>Veterinaria Patitas Felices</h1>
                <nav>
                    <ul>
                        <li><a href="../pagina_principal.php">Home</a></li>
                        <li><a href="../login.php">Volver</a></li>
                    </ul>
                </nav>
            </div>
    </header>

<section id="registro"> 
        <form action="#" method="post">
            <h2>Registro</h2>
    <form action="crear_usuario.php" method="POST">
        <input type="text" placeholder="Nombre Completo" id="nombre" name="nombre" required>

        <input type="text" placeholder="Nombre de usuario" id="usuario_nombre" name="usuario_nombre" required>
        <input type="email" placeholder="Correo" id="correo" name="correo" required>

        <input type="password" placeholder="Contraseña" id="contraseña" name="contraseña" required>

        <label for="tipo_usuario">Tipo de Usuario</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="veterinario">Veterinario</option>
            <option value="cliente">Cliente</option>
        </select>

        <input type="text" placeholder="Teléfono" id="telefono" name="telefono" required>

        <input type="text" placeholder="Dirección" id="direccion" name="direccion" required>

        <button type="submit" class="submit-btn">Crear Usuario</button>
    </form>

    </section>

    <?php
    $conexion = new mysqli('localhost', 'root', 'karina', 'veterinaria_db');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $usuario_nombre = isset($_POST['usuario_nombre']) ? $_POST['usuario_nombre'] : null;
        $correo = isset($_POST['correo']) ? $_POST['correo'] : null;
        $contraseña = isset($_POST['contraseña']) ? password_hash($_POST['contraseña'], PASSWORD_BCRYPT) : null;
        $tipo_usuario = isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario'] : null;
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
        $fecha_creacion = date("Y-m-d H:i:s"); // Fecha de creación automática
        
        if ($nombre && $usuario_nombre && $correo && $contraseña && $tipo_usuario && $telefono && $direccion) {
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, usuario_nombre, correo, contraseña, tipo_usuario, telefono, direccion, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $nombre, $usuario_nombre, $correo, $contraseña, $tipo_usuario, $telefono, $direccion, $fecha_creacion);

            if ($stmt->execute()) {
                echo "Usuario registrado con éxito.";
            } else {
                echo "Error al registrar usuario: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Por favor, completa todos los campos.";
        }
    }

    $conexion->close();
    ?>

</div>

</body>
</html>

</body>
</html>