<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "Por favor, inicie sesión para registrar una mascota.";
    exit(); 
}

$mysqli = new mysqli('localhost', 'root', 'karina', 'veterinaria_db');

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$mascotas = [];
$id_usuario = $_SESSION['id_usuario'];


$query = "SELECT mascota_id, nombre, edad, peso FROM mascotas WHERE id_usuario = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $mascotas[] = $row; 
}

$servicios = [];
$queryServicios = "SELECT nombre FROM servicios"; 
$resultServicios = $mysqli->query($queryServicios);

while ($row = $resultServicios->fetch_assoc()) {
    $servicios[] = $row; 
}

$clinicas = [];
$queryClinicas = "SELECT clinica_id, nombre FROM clinicas"; 
$resultClinicas = $mysqli->query($queryClinicas);

while ($row = $resultClinicas->fetch_assoc()) {
    $clinicas[] = $row; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['fecha'], $_POST['mascota_id'], $_POST['clinica_id'], $_POST['servicio_id'])) {
        $fecha = $mysqli->real_escape_string($_POST['fecha']);
        $mascota = $mysqli->real_escape_string($_POST['mascota_id']);
        $clinica = $mysqli->real_escape_string($_POST['clinica_id']);
        $servicio = $mysqli->real_escape_string($_POST['servicio_id']);
        $id_usuario = $_SESSION['id_usuario']; 

        $query = "INSERT INTO citas (fecha, id_usuario, mascota_id, clinica_id, servicio_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ssssi", $fecha, $id_usuario, $mascota_id, $clinica_id, $servicio_id);

        if ($stmt->execute()) {
            echo "Cita registrada exitosamente!";
        } else {
            echo "Error al registrar la cita: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Faltan datos en el formulario.";
    }
}

$resultServicios->close();
$resultClinicas->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Cita</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        form {
            width: 500px;
            height: 450px;
            background-color: rgba(0, 0, 0, 0.2);
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
        }
        input, select {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
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
    <a href="../pagina_principal.php">Volver</a>
</div>
<h1 style="text-align:center;">Solicitar Cita para su Mascota</h1>

<div class="container">
    
    <form id="citaForm" method="POST">
        <label for="fecha">Fecha:</label>
        <input type="datetime-local" id="fecha" name="fecha" required>

        <label for="nombreMascota">Nombre de la Mascota:</label>
        <select id="nombreMascota" name="mascota_id" required>
            <option value="">Seleccionar mascota</option>
            <?php foreach ($mascotas as $mascota): ?>
                <option value="<?php echo $mascota['mascota_id']; ?>"
                        data-edad="<?php echo $mascota['edad']; ?>"
                        data-peso="<?php echo $mascota['peso']; ?>">
                    <?php echo $mascota['nombre']; ?> (ID: <?php echo $mascota['mascota_id']; ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <div id="datosMascota" style="display:none;">
            <h3>Datos de la Mascota</h3>
            <p id="edadMascota"></p>
            <p id="pesoMascota"></p>
        </div>

        <label for="servicio">Seleccionar Servicio:</label>
        <select id="servicio_id" name="servicio_id" required>
            <option value="">Seleccionar servicio</option>
            <?php foreach ($servicios as $servicio): ?>
                <option value="<?php echo $servicio['nombre']; ?>">
                    <?php echo $servicio['nombre']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="clinica">Clínica:</label>
        <select id="clinica_id" name="clinica_id" required>
            <option value="">Seleccionar clínica</option>
            <?php foreach ($clinicas as $clinica): ?>
                <option value="<?php echo $clinica['clinica_id']; ?>">
                    <?php echo $clinica['nombre']; ?>
                </option>
            <?php endforeach; ?>
        </select> <br> </br>

        <button type="submit">Solicitar Cita</button>

    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const selectMascota = document.getElementById("nombreMascota");
    const datosMascotaDiv = document.getElementById("datosMascota");
    const edadMascota = document.getElementById("edadMascota");
    const pesoMascota = document.getElementById("pesoMascota");

    // Mostrar los datos de la mascota seleccionada
    selectMascota.addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            edadMascota.textContent = "Edad: " + selectedOption.dataset.edad + " años";
            pesoMascota.textContent = "Peso: " + selectedOption.dataset.peso + " kg";
            datosMascotaDiv.style.display = "block";
        } else {
            datosMascotaDiv.style.display = "none";
        }
    });
});
</script>

</body>
</html>