<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    // Si no está logueado, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

include('../conexion.php');

$sql = "SELECT nombre, descripcion, precio, duracion_estimada FROM servicios";
$result = $conexion->query($sql);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Servicios Disponibles </title>
    <style>

        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;

        }
        .grid-container {
            display: grid; /* Activar grid */
            grid-template-columns: repeat(3, 1fr); /* 3 columnas de igual tamaño */
            grid-template-rows: repeat(3, 1fr); /* 3 filas de igual tamaño */
            height: 100vh; /* Altura del contenedor igual a la altura de la ventana */
            gap: 10px;
            
        }
        .grid-item {
            background-color: green;
            color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .navbar {
            padding: 10px;
            text-align: right;
        }

        .navbar a {
            color: black;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="javascript:history.back()">Volver</a>
</div>

<h2 style="text-align: center;"> Servicios Disponibles </h2> 


<div class="grid-container">
        <?php
        // Verificar si la consulta devolvió resultados
        if ($result->num_rows > 0) {
            // Recorrer las filas y mostrar un div por cada servicio
            while($row = $result->fetch_assoc()) {
                echo '<div class="grid-item">';
                echo '<h3>' . htmlspecialchars($row["nombre"]) . '</h3>';
                echo '<p>' . htmlspecialchars($row["descripcion"]) . '</p>';
                echo '<p>Precio: $' . htmlspecialchars($row["precio"]) . '</p>';
                echo '<p>Duración: ' . htmlspecialchars($row["duracion_estimada"]) .  '</p>';
                echo '</div>';
            }
        } else {
            echo "No se encontraron servicios.";
        }
        ?>
    </div>
</div>


<?php
$conn->close();
?>
</body>
</html>
