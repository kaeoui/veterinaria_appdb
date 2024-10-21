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

    <div class="container">
        <h1>Solicitar Cita para su Mascota</h1>
        <form id="citaForm">
            <label for="fecha">Fecha:</label>
            <input type="datetime-local" id="fecha" required>
            <label for="nombreMascota">Nombre de la Mascota:</label>
            <select id="nombreMascota" required>
                <option value="">Seleccionar mascota</option>
                <!-- Aquí se cargarán los nombres de las mascotas desde la base de datos -->
            </select>

            <div id="datosMascota" style="display:none;">
                <h3>Datos de la Mascota</h3>
                <p id="edadMascota"></p>
                <p id="pesoMascota"></p>
                <!-- Otros datos relevantes -->
            </div>

            <label for="servicio">Seleccionar Servicio:</label>
            <select id="servicio" required>
                <option value="">Seleccionar servicio</option>
                <!-- Aquí se cargarán los servicios desde la base de datos -->
            </select>

            <label for="clinica">Clínica:</label>
            <select id="clinica" required>
                <option value="">Seleccionar clínica</option>
                <!-- Aquí se cargarán las clínicas basadas en el servicio seleccionado -->
            </select>

            <button type="submit">Solicitar Cita</button>
        </form>

        <div id="estadoCita">
            <!-- Aquí se mostrará el estado de la cita después de solicitarla -->
</div>
</div>
<script src="script.js"></script>

</body>
        </html>

