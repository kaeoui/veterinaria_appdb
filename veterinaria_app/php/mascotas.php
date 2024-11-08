<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Mascota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: orange;
        }
        #breedInput {
            display: none; /* Ocultar por defecto */
        }

        .navbar {
            padding: 10px;
            text-align: right;
        }

        .navbar a {
            color: black;
            font-size: 16px;
        }

        #idGeneradoDisplay {
      font-weight: bold;
      color: green;
    }
    </style>
</head>
<body>

<div class="navbar">
    <a href="../principal.php">Volver</a>
</div>

<h2>Registro de Mascota</h2>

<?php
// Iniciar la sesión para acceder a los datos del usuario
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    echo "Por favor, inicie sesión para registrar una mascota.";
    exit(); // Detener la ejecución si no hay sesión activa
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    $mysqli = new mysqli('localhost', 'root', '', 'veterinaria_db');

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    // Obtener los datos del formulario
    $mascota_id = $mysqli->real_escape_string($_POST['mascota_id']); // Obtener el ID generado de la mascota
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $tipo = $mysqli->real_escape_string($_POST['tipo']);
    $raza = $mysqli->real_escape_string($_POST['raza']);
    $edad = $mysqli->real_escape_string($_POST['edad']);
    $peso = $mysqli->real_escape_string($_POST['peso']);
    $id_usuario = $_SESSION['id_usuario']; // Obtener el ID del usuario logueado

    // Insertar los datos en la base de datos
    $query = "INSERT INTO mascotas (mascota_id, nombre, tipo, raza, edad, peso, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssdis", $mascota_id, $nombre, $tipo, $raza, $edad, $peso, $id_usuario);

    if ($stmt->execute()) {
        echo "Mascota registrada exitosamente!";
    } else {
        echo "Error al registrar la mascota: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
<p id="mensajeId" style="display:none;">Este es el ID de tu mascota: <span id="idMascotaDisplay"></span></p>


<form method="POST" id="registroMascotaForm">
    <label for="nombre">Nombre de la mascota:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="tipo">Selecciona el tipo de mascota:</label>
    <select id="tipo" name="tipo" required>
        <option value="">Seleccione...</option>
        <option value="gato">Gato</option>
        <option value="perro">Perro</option>
        <option value="hamster">Hámster</option>
        <option value="reptil">Reptil</option>
        <option value="otros">Otros</option>
    </select>

    <div id="breedInput">
        <label for="raza">Raza de la mascota:</label>
        <input type="text" id="raza" name="raza">
    </div>

    <label for="edad">Edad de la mascota:</label>
    <input type="number" id="edad" name="edad" required>

    <label for="peso">Peso:</label>
    <input type="number" step="0.01" id="peso" name="peso" required>

    <input type="hidden" id="mascota_id" name="mascota_id"> <!-- Campo oculto para el ID -->

    <button type="submit">Guardar</button>
</form>


<script>
    document.getElementById("registroMascotaForm").addEventListener("submit", function(event) {
    // Evitar el envío del formulario hasta que generemos el ID
    event.preventDefault();

    // Generar un ID único (puedes modificar la lógica si necesitas un ID más complejo)
    var mascotaId = "MAS-" + Math.random().toString(36).substr(2, 9); // Genera un ID al azar

    console.log("ID generado:", mascotaId);  // Verifica que el ID se genera correctamente

    // Asignar el ID generado al campo oculto
    document.getElementById("mascota_id").value = mascotaId;

    // Mostrar el ID generado en la pantalla
    document.getElementById("mensajeId").style.display = "block"; // Hacer visible el mensaje
    document.getElementById("idMascotaDisplay").textContent = mascotaId; // Mostrar el ID

    // Enviar el formulario con el ID generado
    this.submit();
});


    // Mostrar/Ocultar campo de raza basado en la selección del tipo de mascota
    document.getElementById("tipo").addEventListener("change", function() {
        const selectedType = this.value;
        const breedInput = document.getElementById("breedInput");

        if (selectedType === "perro") {
            breedInput.style.display = "block"; 
        } else {
            breedInput.style.display = "none"; 
            document.getElementById("raza").value = ""; 
        }
    });
</script>


</body>