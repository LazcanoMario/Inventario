<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);
    $descripcion = trim($_POST['descripcion']);
    $categoria_id = intval($_POST['categoria_id']);

    // Insertar el nuevo producto
    $sql = "INSERT INTO productos (nombre, precio, cantidad, descripcion, categoria_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiss", $nombre, $precio, $cantidad, $descripcion, $categoria_id);

    if ($stmt->execute()) {
        // Obtener el ID del nuevo producto
        $producto_id = $conn->insert_id;

        // Registrar el cambio en el historial de cambios
        $usuario_id = $_SESSION['user_id']; // Obtener el ID del usuario que realizó el cambio
        $accion = 'Agregar'; // Acción realizada

        // Insertar en la tabla de historial_cambios
        $sql_historial = "INSERT INTO historial_cambios (producto_id, accion, usuario_id) VALUES (?, ?, ?)";
        $stmt_historial = $conn->prepare($sql_historial);
        $stmt_historial->bind_param("isi", $producto_id, $accion, $usuario_id);
        $stmt_historial->execute();

        echo "Producto agregado con éxito.";
        header('Location: productos.php'); // Redirigir a la lista de productos
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Obtener categorías para el formulario
$categorias_query = "SELECT * FROM categorias";
$categorias_result = $conn->query($categorias_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Card para contener el formulario -->
                <div class="card">
                    <div class="card-header bg-success text-white text-center">
                        <h3 class="mb-0">Agregar Producto</h3>
                    </div>
                    <div class="card-body">
                        <form action="agregar_producto.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del producto</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="categoria_id" class="form-label">Categoría</label>
                                <select class="form-select" id="categoria_id" name="categoria_id" required>
                                    <option value="" disabled selected>Selecciona una categoría</option>
                                    <?php while ($categoria = $categorias_result->fetch_assoc()): ?>
                                        <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="productos.php" class="btn btn-outline-secondary">Volver</a>
                                <button type="submit" class="btn btn-success">Agregar Producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
