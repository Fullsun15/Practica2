<?php
session_start();

if (!isset($_SESSION['alumnos'])) {
    $_SESSION['alumnos'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedulas = $_POST['cedula'];
    $nombres = $_POST['nombre'];
    $matematicas = $_POST['matematicas'];
    $fisica = $_POST['fisica'];
    $programacion = $_POST['programacion'];

    for ($i = 0; $i < count($cedulas); $i++) {
        $alumno = [
            'cedula' => $cedulas[$i],
            'nombre' => $nombres[$i],
            'matematicas' => $matematicas[$i],
            'fisica' => $fisica[$i],
            'programacion' => $programacion[$i],
        ];

        $_SESSION['alumnos'][] = $alumno;
    }

    // Establecer un mensaje de éxito en la sesión
    $_SESSION['mensaje'] = 'Se ha registrado correctamente';

    // Redirigir de nuevo a index.php
    header('Location: index.php');
    exit();
} 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Alumnos</title>
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
<div class="container">
    <h1>Estadísticas de Alumnos</h1>

    <?php

    if (empty($_SESSION['alumnos'])) {
        
        echo '<p>No hay registros</p>';
    } else {
        
function calcularPromedio($materia) {
    $total = 0;
    $numAlumnos = count($_SESSION['alumnos']);
    foreach ($_SESSION['alumnos'] as $alumno) {
        $total += $alumno[$materia];
    }
    return $total / $numAlumnos;
}


function contarAprobadosAplazados($materia) {
    $aprobados = 0;
    $aplazados = 0;
    foreach ($_SESSION['alumnos'] as $alumno) {
        if ($alumno[$materia] >= 10) {
            $aprobados++;
        } else {
            $aplazados++;
        }
    }
    return ['aprobados' => $aprobados, 'aplazados' => $aplazados];
}

// Calcula las estadísticas
$promedioMatematicas = calcularPromedio('matematicas');
$promedioFisica = calcularPromedio('fisica');
$promedioProgramacion = calcularPromedio('programacion');

$matematicasStats = contarAprobadosAplazados('matematicas');
$fisicaStats = contarAprobadosAplazados('fisica');
$programacionStats = contarAprobadosAplazados('programacion');

$notaMaximaMatematicas = 0;
$notaMaximaFisica = 0;
$notaMaximaProgramacion = 0;

$numAprobadosTodasMaterias = 0;
$numAprobadosUnaMateria = 0;
$numAprobadosDosMaterias = 0;

foreach ($_SESSION['alumnos'] as $alumno) {
    $notaMatematicas = $alumno['matematicas'];
    $notaFisica = $alumno['fisica'];
    $notaProgramacion = $alumno['programacion'];

    if ($notaMatematicas > $notaMaximaMatematicas) {
        $notaMaximaMatematicas = $notaMatematicas;
    }

    if ($notaFisica > $notaMaximaFisica) {
        $notaMaximaFisica = $notaFisica;
    }

    if ($notaProgramacion > $notaMaximaProgramacion) {
        $notaMaximaProgramacion = $notaProgramacion;
    }

    // Verificar cuántas materias aprobó cada alumno
    $numAprobadas = 0;
    if ($notaMatematicas >= 10) {
        $numAprobadas++;
    }
    if ($notaFisica >= 10) {
        $numAprobadas++;
    }
    if ($notaProgramacion >= 10) {
        $numAprobadas++;
    }

    // Contar según la cantidad de materias aprobadas
    if ($numAprobadas == 3) {
        $numAprobadosTodasMaterias++;
    } elseif ($numAprobadas == 1) {
        $numAprobadosUnaMateria++;
    } elseif ($numAprobadas == 2) {
        $numAprobadosDosMaterias++;
    }
}
?>
        <ul class="collapsible expandable" data-collapsible="accordion">
        <li>
            <div class="collapsible-header"><i class="material-icons">assignment</i>PROMEDIO DE NOTAS</div>
            <div class="collapsible-body">
                <ul>
                    <li>Matemáticas: <?php echo number_format($promedioMatematicas, 2); ?></li>
                    <li>Física: <?php echo number_format($promedioFisica, 2); ?></li>
                    <li>Programación: <?php echo number_format($promedioProgramacion, 2); ?></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">assignment</i>NÚMERO DE ALUMNOS APROBADOS Y APLAZADOS</div>
            <div class="collapsible-body">
                <ul>
                    <li>Matemáticas - Aprobados: <?php echo $matematicasStats['aprobados']; ?>, Aplazados: <?php echo $matematicasStats['aplazados']; ?></li>
                    <li>Física - Aprobados: <?php echo $fisicaStats['aprobados']; ?>, Aplazados: <?php echo $fisicaStats['aplazados']; ?></li>
                    <li>Programación - Aprobados: <?php echo $programacionStats['aprobados']; ?>, Aplazados: <?php echo $programacionStats['aplazados']; ?></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">assignment</i>RESÚMEN</div>
            <div class="collapsible-body">
                <ul>
                    <li>Número de Alumnos que Aprobaron Todas las Materias: <?php echo $numAprobadosTodasMaterias; ?></li>
                    <li>Número de Alumnos que Aprobaron una Sola Materia: <?php echo $numAprobadosUnaMateria; ?></li>
                    <li>Número de Alumnos que Aprobaron Dos Materias: <?php echo $numAprobadosDosMaterias; ?></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">assignment</i>NOTAS MÁXIMAS</div>
            <div class="collapsible-body">
                <ul>
                    <li>Matemáticas - Nota Máxima: <?php echo $notaMaximaMatematicas; ?></li>
                    <li>Física - Nota Máxima: <?php echo $notaMaximaFisica; ?></li>
                    <li>Programación - Nota Máxima: <?php echo $notaMaximaProgramacion; ?></li>
                </ul>
            </div>
        </li>
    </ul>
    
        <?php
    }
    ?>
    <a class="btn waves-effect waves-light" href="index.php">Registrar Nuevo Alumno</a>

    <br><br>

    <form action="destruir_sesion.php" method="post">
    <button class="btn waves-effect waves-light" type="submit">Borrar
                <i class="material-icons right">delete</i>
    </form>



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
    
        var elem = document.querySelector('.collapsible.expandable');
        var instance = M.Collapsible.init(elem, {
        accordion: false
        });

    document.addEventListener('DOMContentLoaded', function () {
            var elems = document.querySelectorAll('.parallax');
            var instances = M.Parallax.init(elems);
    });
</script>
</body>
</html>


