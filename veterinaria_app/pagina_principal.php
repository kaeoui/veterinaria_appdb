<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

include('conexion.php');

$sql = "SELECT nombre, descripcion, precio, imagen FROM servicios";
$result = $conexion->query($sql);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veterinaria Patitas Felices</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>

        <div class="navbar">
            <a style="color: white;" href="php/cerrar_sesion.php">Cerrar sesión</a>
        </div>

        <div class="header-container">
            <img src="img/logo_icon.png" alt="Logo Veterinaria" class="logo">
            <h1>Veterinaria Patitas Felices</h1>
            <nav>
                <ul>
                    <li><a href="php/citas.php">Agendar Cita</a></li>
                    <li><a href="php/mascotas.php">Registrar Mascota</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#testimonios">Testimonios</a></li>
                    <li><a href="#galeria">Galería</a></li>
                    <li><a href="#ubicacion">Ubicación</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="intro">
        <h2>Bienvenidos a Veterinaria Patitas Felices</h2>
        <p>En nuestra clínica, cuidamos a tus mascotas como si fueran parte de nuestra familia. </p>
        <p>Contamos con un equipo de profesionales dedicados y apasionados por el bienestar de tus compañeros peludos. </p>
    </section>

    <section id="servicios">
        <h2 class="titulo-servicios">Nuestros Servicios</h2> 
        <?php
    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        echo '<div class="grid-container">';

        while($row = $result->fetch_assoc()) {
            echo '<div class="grid-item">';
    
            // Mostrar imagen si existe
            if ($row["imagen"]) {
                echo "<img class='servicio-imagen' src='" . htmlspecialchars($row["imagen"]) . "' alt='Imagen de " . htmlspecialchars($row["nombre"]) . "'>";
            }
    
            // Nombre y descripción
            echo '<p><strong>' . htmlspecialchars($row["nombre"]) . ':</strong> ' . htmlspecialchars($row["descripcion"]) . '</p>';
            
            // Precio
            echo '<p class="precio">Precio: $' . htmlspecialchars($row["precio"]) . '</p>';
            
            echo '</div>';
        }

        echo '</div>'; 
    } else {
        echo "<p style='text-align: center;'>No se encontraron servicios.</p>";
    }
    ?>
</section>


    <section id="testimonios">
        <h2>Testimonios de nuestros clientes</h2>
        <blockquote>
            <p>"El equipo de Patitas Felices ha sido increíble con mi perro Max. Siempre están atentos y lo cuidan con mucho amor. No iría a ningún otro lugar." – María García</p>
        </blockquote>
        <blockquote>
            <p>"Gracias a la rápida atención de los veterinarios, mi gata se recuperó de una cirugía complicada. ¡Recomiendo mucho esta clínica!" – Juan Pérez</p>
        </blockquote>
    </section>

    <section id="galeria">
        <h2>Galería de Fotos</h2>
        <div class="galeria-container">
            <img src="img/vet.png" alt="Perro feliz">
            <img src="img/gato.png" alt="Gato jugando">
            <img src="img/perro_feliz.png" alt="Consulta veterinaria">
            <img src="img/vet2.png" alt="Mascotas jugando">

        </div>
    </section>

    <section id="ubicacion">
        <h2>Ubicación</h2>
        <p>Calle de los Perros, 456, San José, Costa Rica</p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31430.748238473916!2d-84.11170897119647!3d9.928069872695453!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0e30e1d2a4db5%3A0x2c2f7a5d95c9f62f!2sSan%20Jos%C3%A9!5e0!3m2!1ses!2scr!4v1696240207195!5m2!1ses!2scr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </section>

    <footer>
        <p>&copy; 2024 Veterinaria Patitas Felices. Todos los derechos reservados.</p>
        <p>Teléfono: +506 7000 1234 | Correo: contacto@patitasfelices.com</p>
    </footer>
</body>
</html>
