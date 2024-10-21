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
    </style>
</head>
<body>

<div class="navbar">
    <a href="javascript:history.back()">Volver</a>
</div>

<h2>Registro de Mascota</h2>
<form id="contactForm">
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
        <label for="breed">Digita la raza:</label>
        <input type="text" id="breed" name="breed">
    </div>

    <label for="edad">Edad de la mascota:</label>
    <input type="text" id="edad" name="edad" required>

    <button type="submit"> Guardar </button>
</form>

<script>
    // Mostrar/Ocultar campo de raza basado en la selección del tipo de mascota
    document.getElementById("tipo").addEventListener("change", function() {
        const selectedType = this.value;
        const breedInput = document.getElementById("breedInput");

        if (selectedType === "perro") {
            breedInput.style.display = "block"; // Mostrar campo de raza
        } else {
            breedInput.style.display = "none"; // Ocultar campo de raza
            document.getElementById("breed").value = ""; // Limpiar el campo de raza si no es perro
        }
    });

    document.getElementById("contactForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar el envío del formulario

        const nombre = document.getElementById("nombre").value.trim();
        const selectedType = document.getElementById("tipo").value;
        const breed = document.getElementById("breed").value.trim();
        const edad = document.getElementById("edad").value.trim();

        // Validación simple
        if (nombre === "" || selectedType === "" || (selectedType === "perro" && breed === "") || edad === "") {
            alert("Por favor, completa todos los campos.");
        } else {
            alert("Formulario enviado con éxito!\nTipo de mascota: " + selectedType + (selectedType === "perro" ? "\nRaza: " + breed : ""));
            // Aquí puedes agregar el código para enviar los datos a un servidor
            this.reset(); // Limpiar el formulario
        }
    });
</script>

</body>
</html>
