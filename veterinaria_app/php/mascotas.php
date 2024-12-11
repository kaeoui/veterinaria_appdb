<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Mascota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
        }


        h2 {
            text-align: center;
        }

        .loginmascota-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;

        }

        #registroMascotaForm {
            width: 400px;
            height: 500px;
            background-color: rgba(0, 0, 0, 0.2);
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);

        }

        input,
        select {
            width: 350px;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;

        }

        button:hover {
            background-color: black;
        }

        #breedInput {
            display: none;
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
        <a href="../pagina_principal.php">Volver</a>
    </div>

    <?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "Por favor, inicie sesión para registrar una mascota.";
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mysqli = new mysqli('localhost', 'root', 'karina', 'veterinaria_db');

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $mascota_id = $mysqli->real_escape_string($_POST['mascota_id']); 
    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $tipo = $mysqli->real_escape_string($_POST['tipo']);
    $raza = $mysqli->real_escape_string($_POST['raza']);
    $edad = $mysqli->real_escape_string($_POST['edad']);
    $peso = $mysqli->real_escape_string($_POST['peso']);
    $id_usuario = $_SESSION['id_usuario']; 

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
    <h2 class="text-align: center;">Registro de Mascota</h2>
    <div class="loginmascota-container">

        <form method="POST" id="registroMascotaForm">
            <label for="nombreMascota">Nombre de la Mascota:</label>
            <input type="text" placeholder="Nombre de la Mascota" id="nombre" name="nombre" required> <br> </br>

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
            <label for="nombreMascota">Raza de la Mascota:</label>

                <input type="text" placeholder="Raza de la Mascota" id="raza" name="raza">
            </div> <br> </br>

            <label for="nombreMascota">Edad de la Mascota:</label>
            <input type="number" placeholder="Edad" id="edad" name="edad" required> <br> </br>

            <label for="nombreMascota">Peso de la Mascota:</label>
            <input type="number" step="0.01" placeholder="Peso" id="peso" name="peso" required><br> </br>

            <input type="hidden" id="mascota_id" name="mascota_id">

            <button type="submit">Guardar</button>
        </form>
    </div>

    <script>
        document.getElementById("registroMascotaForm").addEventListener("submit", function (event) {
            event.preventDefault();

            var mascotaId = "MAS-" + Math.random().toString(36).substr(2, 9);
            console.log("ID generado:", mascotaId);
            document.getElementById("mascota_id").value = mascotaId;

            document.getElementById("mensajeId").style.display = "block";
            document.getElementById("idMascotaDisplay").textContent = mascotaId;

            const formData = new FormData(this);
            fetch('', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    alert("Mascota registrada exitosamente!");
                })
                .catch(error => console.error('Error:', error));
        });

        document.getElementById("tipo").addEventListener("change", function () {
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