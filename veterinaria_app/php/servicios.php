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
    <div class="grid-item">Elemento 1</div>
    <div class="grid-item">Elemento 2</div>
    <div class="grid-item">Elemento 3</div>
    <div class="grid-item">Elemento 4</div>
    <div class="grid-item">Elemento 5</div>
    <div class="grid-item">Elemento 6</div>
</div>

</body>
</html>
