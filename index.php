<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de Alumnos</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        label, p {
            font-size: 18px;
            font-style: bold;
            margin-top: 20px;
        }

        .parallax-container {
            min-height: 200px;
            line-height: 0;
            height: auto;
            color: rgba(255, 255, 255, .9);
        }
    </style>
</head>
<body>
<div class="parallax-container">
    <div class="parallax"><img
            src="https://www.edu-casio.es/wp-content/uploads/2018/05/casio-educasio-header-libros-sobre-matematicas.png"
            alt="Unsplashed background img 2"></div>
</div>

<h1 class="center">Registro de Alumnos</h1>
<?php
    session_start();
    
    if (isset($_SESSION['mensaje'])) {
        echo '<p style="color: green;">' . $_SESSION['mensaje'] . '</p>';
        unset($_SESSION['mensaje']);
    }
    // Comprobar si hay al menos un registro en la sesión
    $hayRegistros = isset($_SESSION['alumnos']) && count($_SESSION['alumnos']) > 0;
    ?>
    <hr>
    
    <div class="container">
    <div class="row">
        <div class="col s12 m12 l12 ">
            <div class="card">
                <div class="card-content">
                    <form action="procesar.php" method="post">
                        <div>
                            <label for="cedula">Cédula de Identidad:</label>
                            <input type="text" id="cedula" name="cedula[]" required maxlength="15">
                        </div>
                            <label for="nombre">Nombre del Alumno:</label>
                            <input type="text" id="nombre" name="nombre[]" required pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ\s]+$">
                            <div>

                            <label for="matematicas">Nota de Matemáticas:</label>
                            <input type="number" id="matematicas" name="matematicas[]" required min="0" max="20" step=".01">
                            </div>
                            <div>
                            <label for="fisica">Nota de Física:</label>
                            <input type="number" id="fisica" name="fisica[]" required min="0" max="20" step=".01">
                            </div>
                            <div>
                            <label for="programacion">Nota de Programación:</label>
                            <input type="number" id="programacion" name="programacion[]" required min="0" max="20" step=".01">
                        </div>
                        <div class="center-align">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Registrar Alumno
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
        <a href="procesar.php" class="waves-effect waves-light btn">Consultar</a>
    </div>

    <br><br>
</div>
<br><br><br>

<footer class="page-footer purple lighten-1">
    <div class="footer-copyright">
        <div class="container">
            <p>Copyright ©2023 rubilopez.site</p>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('.parallax');
        var instances = M.Parallax.init(elems);
    });
</script>
</body>
</html>
