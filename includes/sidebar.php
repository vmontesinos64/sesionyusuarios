<div class="d-flex">
    <div id="sidebar" class="bg-light border-end p-3" style="width: 250px;">
        <?php
        require_once $_SESSION['ROOT_PATH'] . "/includes/menu-builder.php";
        $menu = construirSidebar($conn, $_SESSION['rol']);
        if (empty($menu)) {
            echo "<p class='text-danger'>No se generó ningún menú para el rol: {$_SESSION['rol']}</p>";
        } else {
            echo $menu;
        }
        ?>
    </div>
    <div class="flex-grow-1 p-4">
        <!-- Aquí va el contenido principal -->
    </div>
</div>