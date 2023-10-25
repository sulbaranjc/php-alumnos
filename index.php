<?php
require_once 'Alumno.php';

$isEditing = false;
$alumnoToEdit = null;


$filename = "data.json";

// Cargar datos desde el archivo JSON y convertir cada entrada en un objeto Alumno.
$alumnos = file_exists($filename) ? array_map(function($data) {
    return new Alumno($data['nombre'], $data['apellido'], $data['telefono'], $data['email'], $data['nota1'], $data['nota2'], $data['nota3'], $data['asistencia'], $data['examenFinal']);
}, json_decode(file_get_contents($filename), true)) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'add':
            $alumno = new Alumno($_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['nota1'], $_POST['nota2'], $_POST['nota3'], $_POST['asistencia'], $_POST['examenFinal']);
            $alumnos[] = $alumno;
            
            // Convertir los objetos Alumno de nuevo a arrays para guardar en el archivo JSON.
            file_put_contents($filename, json_encode(array_map(function(Alumno $alumno) {
                return [
                    'nombre' => $alumno->getNombre(),
                    'apellido' => $alumno->getApellido(),
                    'telefono' => $alumno->getTelefono(),
                    'email' => $alumno->getEmail(),
                    'nota1' => $alumno->getNota1(),
                    'nota2' => $alumno->getNota2(),
                    'nota3' => $alumno->getNota3(),
                    'asistencia' => $alumno->getAsistencia(),
                    'examenFinal' => $alumno->getExamenFinal(),
                ];
            }, $alumnos)));
            break;
            case 'update':
                if (isset($_POST['index'])) {
                    $index = intval($_POST['index']);
                    $alumno = new Alumno($_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['email'], $_POST['nota1'], $_POST['nota2'], $_POST['nota3'], $_POST['asistencia'], $_POST['examenFinal']);
                    $alumnos[$index] = $alumno;
                    file_put_contents($filename, json_encode(array_map(function(Alumno $alumno) {
                        return [
                            'nombre' => $alumno->getNombre(),
                            'apellido' => $alumno->getApellido(),
                            // ... (los demás campos)
                        ];
                    }, $alumnos)));
                }
                break;

        // Puedes añadir lógica para modificar y eliminar aquí...
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['index'])) {
    $isEditing = true;
    $indexToEdit = intval($_GET['index']);
    
    if (isset($alumnos[$indexToEdit])) {
        $alumnoToEdit = $alumnos[$indexToEdit];
    }
}

?>

<!-- A continuación, puedes continuar con la parte HTML de tu index.php, como el formulario y la tabla de listado de alumnos. -->



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>CRUD Alumnos</title>
</head>
<body>

<!-- Navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">CRUD Alumnos</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Alumnos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Informes</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Ayuda
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Acerca de</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Formulario -->
<div class="container mt-4">
    <h2 class="text-center"><?= $isEditing ? 'Editar Alumno' : 'Registro de Alumnos' ?></h2>
    <form action="index.php" method="post" class="mb-4">

        <!-- Si estamos editando, incluir un campo oculto con el índice del alumno a editar -->
        <?php if ($isEditing): ?>
            <input type="hidden" name="index" value="<?= $indexToEdit ?>">
        <?php endif; ?>

        <!-- Nombre y Apellido en la misma línea -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $isEditing ? $alumnoToEdit->getNombre() : '' ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $isEditing ? $alumnoToEdit->getApellido() : '' ?>" required>
                </div>
            </div>
        </div>

        <!-- Teléfono y Email en la misma línea -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= $isEditing ? $alumnoToEdit->getTelefono() : '' ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $isEditing ? $alumnoToEdit->getEmail() : '' ?>" required>
                </div>
            </div>
        </div>

        <!-- Notas, asistencia y finales -->
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="nota1" class="form-label">Nota 1 (20%)</label>
                    <input type="number" class="form-control" id="nota1" name="nota1" step="0.1" min="0" max="10" value="<?= $isEditing ? $alumnoToEdit->getNota1() : '' ?>" required>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="nota2" class="form-label">Nota 2 (20%)</label>
                    <input type="number" class="form-control" id="nota2" name="nota2" step="0.1" min="0" max="10" value="<?= $isEditing ? $alumnoToEdit->getNota2() : '' ?>" required>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="nota3" class="form-label">Nota 3 (20%)</label>
                    <input type="number" class="form-control" id="nota3" name="nota3" step="0.1" min="0" max="10" value="<?= $isEditing ? $alumnoToEdit->getNota3() : '' ?>" required>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="asistencia" class="form-label">Asistencia (10%)</label>
                    <input type="number" class="form-control" id="asistencia" name="asistencia" step="0.1" min="0" max="10" value="<?= $isEditing ? $alumnoToEdit->getAsistencia() : '' ?>" required>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="examenFinal" class="form-label">Finales (30%)</label>
                    <input type="number" class="form-control" id="examenFinal" name="examenFinal" step="0.1" min="0" max="10" value="<?= $isEditing ? $alumnoToEdit->getExamenFinal() : '' ?>" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="action" value="<?= $isEditing ? 'update' : 'add' ?>">
            <?= $isEditing ? 'Guardar' : 'Agregar' ?>
        </button>
    </form>
</div>
<!-- Tabla de Alumnos -->
<table class="table container">
    <h3 class="text-center">Listado de Alumnos</h3>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Nota Acumulada</th>
            <th>Acciones</th>
            <!-- Otros encabezados de tabla... -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alumnos as $index => $alumno) : ?>
            <tr>
                <td><?= $alumno->getNombre() ?></td>
                <td><?= $alumno->getApellido() ?></td>
                <td><?= $alumno->getNotaAcumulada() ?></td>
                <td>
                    <!-- Enlaces para Editar y Eliminar -->
                    <a href="index.php?action=edit&index=<?= $index ?>">
                        <img src="imgs/file-edit-line.png" alt="Editar" width="24px">
                    </a>
                    <a href="eliminar.php?index=<?= $index ?>">
                        <img src="imgs/delete-bin-line.png" alt="Eliminar" width="24px">
                    </a>
                </td>
                <!-- Más celdas... -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
