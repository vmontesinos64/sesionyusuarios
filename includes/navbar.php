<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Panel</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <span class="nav-link text-white d-inline"><?= $_SESSION['nombre'] . " " . $_SESSION['apellidos'] ?> </span>
                <span class="nav-link text-warning d-inline"><?= "/Usuario: " . $_SESSION['usuario'] ?> (<?= " Perfil: " . $_SESSION['rol'] ?>)</span>
            </li>
        </ul>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                Opciones
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="index.php">Inicio</a></li>
                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</nav>