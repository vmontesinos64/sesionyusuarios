$(document).ready(function() {
  cargarUsuarios();

  $('#formUsuario').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'guardar.php',
      method: 'POST',
      data: $(this).serialize(),
      success: function() {
        $('#formUsuario')[0].reset();
        cargarUsuarios();
        const toast = new bootstrap.Toast(document.getElementById('toastOK'));
        toast.show();
      }
    });
  });

  function cargarUsuarios() {
    $.getJSON('listar.php', function(data) {
      let filas = '';
      data.forEach(function(usuario) {
        filas += `<tr>
          <td>${usuario.nombre}</td>
          <td>${usuario.correo}</td>
          <td><button class="btn btn-sm btn-danger">Eliminar</button></td>
        </tr>`;
      });
      $('#tablaUsuarios').html(filas);
    });
  }
});
