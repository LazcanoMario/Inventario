<?php

include('../conexion.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $rol_id = intval($_POST['rol']); // Asegurarse de que rol_id es un número entero

    // Verificar si el correo electrónico ya existe
    $check_email = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($check_email);
    $stmt->bind_param("s", $email);  // "s" indica que el parámetro es una cadena
    $stmt->execute();
    $result_email = $stmt->get_result();

    if ($result_email->num_rows > 0) {
        // Si el correo ya existe, redirigir al login
        echo "<script>alert('El correo electrónico ya está registrado. Por favor, inicia sesión.'); window.location.href = 'login.php';</script>";
        exit(); 
    } else {
        // Insertar el nuevo usuario usando una consulta preparada
        $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hashear la contraseña

        $sql = "INSERT INTO usuarios (nombre, email, password, rol_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $email, $password_hash, $rol_id); // "s" para cadena, "i" para entero

        if ($stmt->execute()) {
            // Mostrar mensaje de éxito y redirigir al login después de 3 segundos
            echo "<script>alert('Usuario registrado con éxito.'); window.location.href = 'login.php';</script>";
            exit(); 
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>
