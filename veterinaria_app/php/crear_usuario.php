<?php session_start(); 
include_once "../conexion.php";
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
</head>
<body>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="../login.php">Volver</a>
</div>

<div class="container">
    <h2>Registro de Usuario</h2>
    <form action="crear_usuario.php" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="usuario_nombre">Crea un usuario</label>
        <input type="text" id="usuario_nombre" name="usuario_nombre" required>

        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" required>

        <label for="contraseña">Contraseña</label>
        <input type="password" id="contraseña" name="contraseña" required>

        <label for="tipo_usuario">Tipo de Usuario</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="veterinario">Veterinario</option>
            <option value="cliente">Cliente</option>
        </select>

        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono" required>

        <label for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" required>

        <button type="submit" class="submit-btn">Crear Usuario</button>
    </form>

    <?php
    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'veterinaria_db');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verificar si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario y verificar que existen
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $usuario_nombre = isset($_POST['usuario_nombre']) ? $_POST['usuario_nombre'] : null;
        $correo = isset($_POST['correo']) ? $_POST['correo'] : null;
        $contraseña = isset($_POST['contraseña']) ? password_hash($_POST['contraseña'], PASSWORD_BCRYPT) : null;
        $tipo_usuario = isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario'] : null;
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
        $fecha_creacion = date("Y-m-d H:i:s"); // Fecha de creación automática
        
        // Verificar que todos los campos necesarios no estén vacíos
        if ($nombre && $usuario_nombre && $correo && $contraseña && $tipo_usuario && $telefono && $direccion) {
            // Preparar la consulta
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, usuario_nombre, correo, contraseña, tipo_usuario, telefono, direccion, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $nombre, $usuario_nombre, $correo, $contraseña, $tipo_usuario, $telefono, $direccion, $fecha_creacion);

            // Ejecutar y verificar
            if ($stmt->execute()) {
                echo "Usuario registrado con éxito.";
            } else {
                echo "Error al registrar usuario: " . $stmt->error;
            }

            // Cerrar conexiones
            $stmt->close();
        } else {
            echo "Por favor, completa todos los campos.";
        }
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>

</div>

</body>
</html>

</body>
</html>