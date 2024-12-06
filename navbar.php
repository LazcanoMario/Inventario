<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
        .navbar {
            background: linear-gradient(45deg, #6a11cb, #2575fc); 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }
        .navbar-brand img {
            height: 50px; 
            border-radius: 10px; 
        }
        .navbar-brand {
            font-size: 1.5rem; 
            font-weight: bold;
            color: white !important; 
        }
        .nav-link {
            color: white !important; 
            transition: color 0.3s ease; 
        }
        .nav-link.active {
            font-weight: bold;
            color: #ffd700 !important; 
        }
        .nav-link:hover {
            color: #ff6347 !important; 
        }
        .navbar-toggler {
            border-color: white; 
        }
        .navbar-toggler-icon {
            background-image: url("https://img.icons8.com/ios-glyphs/30/ffffff/menu.png"); /
        }
        .btn-cta {
            background-color: #ffd700; 
            color: black;
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-cta:hover {
            background-color: #ffc107;
            color: black;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logotipo -->
            <a class="navbar-brand" href="dashboard.php">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTzxSMw2-1EXip1YtFI8TNxHyTd51-w50bT5Q&s" alt="Mi Tienda" class="d-inline-block align-text-top">
                Mi Tienda
            </a>
            <!-- Botón del menú en pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'productos.php') ? 'active' : ''; ?>" href="productos.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'historial_cambios.php') ? 'active' : ''; ?>" href="historial_cambios.php">Historial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'logout.php') ? 'active' : ''; ?>" href="logout.php">Cerrar sesión</a>
                    </li>
                </ul>
                
                
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
