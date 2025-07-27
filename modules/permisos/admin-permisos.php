<?php
require_once __DIR__ . "/../../config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";

// Obtener permisos existentes
$permisos = $conn->query("SELECT * FROM permisos ORDER BY recurso, rol");

// Detectar páginas .php sin permiso registrado
$archivos = array_map('basename', glob("../*.php"));
$registrados = array_column($conn->query("SELECT DISTINCT recurso FROM permisos")->fetch_all(), 0);
$sinPermiso = array_diff($archivos, $registrados);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Permisos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">🔐 Panel de Permisos</h2>

  <form method="POST" action="crear-permisos-faltantes.php" class="mb-3">
    <button type="submit" class="btn btn-success">➕ Crear permisos para páginas no registradas (<?= count($sinPermiso) ?>)</button>
  </form>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Rol</th>
        <th>Página</th>
        <th>Acceso</th>
        <th>¿Validación?</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($perm = $permisos->fetch_assoc()): ?>
        <tr>
          <td><?= $perm['rol'] ?></td>
          <td><?= $perm['recurso'] ?></td>
          <td><?= $perm['acceso'] ?></td>
          <td><?= $perm['requiere_validacion'] ? 'Sí' : 'No' ?></td>
          <td>
            <!-- Editar -->
            <button class="btn btn-sm btn-warning editar-btn"
                    data-id="<?= $perm['id'] ?>"
                    data-rol="<?= $perm['rol'] ?>"
                    data-recurso="<?= $perm['recurso'] ?>"
                    data-acceso="<?= $perm['acceso'] ?>"
                    data-validacion="<?= $perm['requiere_validacion'] ?>">✏️</button>

            <!-- Duplicar -->
            <form method="POST" action="duplicar-permiso.php" class="d-inline">
              <input type="hidden" name="id" value="<?= $perm['id'] ?>">
              <button type="submit" class="btn btn-sm btn-info">📄</button>
            </form>

            <!-- Eliminar -->
            <form method="POST" action="eliminar-permiso.php" class="d-inline" onsubmit="return confirm('¿Eliminar este permiso?');">
              <input type="hidden" name="id" value="<?= $perm['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Modal único AJAX -->
<div class="modal fade" id="modalEditar" tabindex="-1">
  <div class="modal-dialog">
    <form id="formEditar" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar permiso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="modalId">
        <label>Rol:</label>
        <select name="rol" id="modalRol" class="form-select">
          <option value="super-user">Super-user</option>
          <option value="profesor">Profesor</option>
          <option value="alumno">Alumno</option>
        </select>

        <label>Página:</label>
        <input type="text" name="recurso" id="modalRecurso" class="form-control">

        <label>Acceso:</label>
        <select name="acceso" id="modalAcceso" class="form-select">
          <option value="permitido">Permitido</option>
          <option value="denegado">Denegado</option>
        </select>

        <label>¿Requiere validación?</label>
        <select name="requiere_validacion" id="modalValidacion" class="form-select">
          <option value="1">Sí</option>
          <option value="0">No</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">💾 Guardar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Abrir modal con datos
  document.querySelectorAll('.editar-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('modalId').value         = btn.dataset.id;
      document.getElementById('modalRol').value        = btn.dataset.rol;
      document.getElementById('modalRecurso').value    = btn.dataset.recurso;
      document.getElementById('modalAcceso').value     = btn.dataset.acceso;
      document.getElementById('modalValidacion').value = btn.dataset.validacion;
      new bootstrap.Modal(document.getElementById('modalEditar')).show();
    });
  });

  // Enviar AJAX
  document.getElementById('formEditar').addEventListener('submit', function(e) {
    e.preventDefault();
    const datos = new FormData(this);
    fetch('editar-permiso-ajax.php', {
      method: 'POST',
      body: datos
    }).then(res => res.text())
      .then(txt => {
        alert(txt);
        location.reload();
      });
  });
</script>
</body>
</html>
