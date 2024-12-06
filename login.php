<?php
session_start(); // Iniciar sesión

include('../conexion.php'); 

$error_message = ""; // Inicializar la variable para evitar errores

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password']; // La contraseña que ingresa el usuario

    // Consultar si el usuario existe en la base de datos
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // La contraseña es correcta, crear sesión
            $_SESSION['user_id'] = $user['id']; // Almacenar el ID del usuario
            $_SESSION['nombre'] = $user['nombre']; // Almacenar nombre del usuario
            $_SESSION['rol_id'] = $user['rol_id']; // Almacenar el rol del usuario

            // Redirigir al dashboard o página de inicio
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = "Contraseña incorrecta.";
        }
    } else {
        $error_message = "El correo electrónico no está registrado.";
    }
}
?>

<!-- login.html -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Vincular Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card" style="width: 25rem;">
        <div class="card-header text-center">
            <h4>Iniciar sesión</h4>
        </div>
        <div class="card-body">
            <!-- Mostrar el mensaje de error si existe -->
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
            </form>
            <div class="text-center mt-3">
                <p>¿No tienes cuenta? <a href="registro.html">Registrate aquí</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Vincular Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
