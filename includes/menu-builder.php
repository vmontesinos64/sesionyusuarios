<?php
function construirSidebar($conn, $rol) {
  // 1. Obtener todas las categorías
  $sqlCategorias = "SELECT id_categoria, desc_categoria, patern_categoria FROM categorias";
  $resCat = $conn->query($sqlCategorias);

  $categorias = [];
  while ($row = $resCat->fetch_assoc()) {
    $id = $row['id_categoria'];
    $categorias[$id] = [
      'desc' => $row['desc_categoria'],
      'padre' => $row['patern_categoria'],
      'recursos' => []
    ];
  }

  // 2. Obtener los recursos permitidos para el rol
  $sqlPermisos = "SELECT recurso, id_categoria FROM permisos WHERE rol = ? AND acceso = 'permitido'";
  $stmt = $conn->prepare($sqlPermisos);
  $stmt->bind_param("s", $rol);
  $stmt->execute();
  $resPerm = $stmt->get_result();

  while ($row = $resPerm->fetch_assoc()) {
    $id = $row['id_categoria'];
    if (isset($categorias[$id])) {
      $categorias[$id]['recursos'][] = $row['recurso'];
    }
  }

  return renderizarAcordeon($categorias);
}

/*
function construirSidebar($conn, $rol) {
  $sql = "SELECT p.recurso, c.id_categoria, c.desc_categoria, c.patern_categoria
          FROM permisos p
          JOIN categorias c ON p.id_categoria = c.id_categoria
          WHERE p.rol = ? AND p.acceso = 'permitido'";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $rol);
  $stmt->execute();
  $result = $stmt->get_result();
  $categorias = [];
  while ($row = $result->fetch_assoc()) {
    $id = $row['id_categoria'];
    if (!isset($categorias[$id])) {
      $categorias[$id] = [
        'desc' => $row['desc_categoria'],
        'padre' => $row['patern_categoria'],
        'recursos' => []
      ];
    }
    $categorias[$id]['recursos'][] = $row['recurso'];
  }
var_dump($categorias);
  return renderizarAcordeon($categorias);
}
*/

function renderizarAcordeon($categorias, $padre = null, $nivel = 0) {
  $html = '<div class="accordion" id="menuAccordion' . $nivel . '">';
  foreach ($categorias as $id => $cat) {
    if ($cat['padre'] == $padre) {
      $collapseId = "collapse{$id}";
      $headingId = "heading{$id}";
      $html .= '
        <div class="accordion-item">
          <h2 class="accordion-header" id="' . $headingId . '">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#' . $collapseId . '" aria-expanded="false" aria-controls="' . $collapseId . '">
              ' . $cat['desc'] . '
            </button>
          </h2>
          <div id="' . $collapseId . '" class="accordion-collapse collapse" aria-labelledby="' . $headingId . '" data-bs-parent="#menuAccordion' . $nivel . '">
            <div class="accordion-body">
              <ul class="list-group list-group-flush">';
      foreach ($cat['recursos'] as $recurso) {
        $html .= '<li class="list-group-item"><a href="' . $recurso . '" class="text-decoration-none">' . $recurso . '</a></li>';
      }
      $html .= '</ul>';
      // Subcategorías
      $html .= renderizarAcordeon($categorias, $id, $nivel + 1);
      $html .= '</div></div></div>';
    }
  }
  $html .= '</div>';
  return $html;
}
?>