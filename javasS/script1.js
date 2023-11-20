// Manejar el envío del formulario
$('#form-board').submit(function(event) {
  event.preventDefault(); // Prevenir el envío del formulario por defecto
  
  // Obtener el nombre del tablero desde el formulario
  const nombreTablero = $('#nombre-tablero').val();
  
  // Realizar una solicitud AJAX para guardar el tablero en la base de datos
  $.ajax({
      type: 'POST', // Método HTTP POST para enviar datos
      url: 'guardar_tablero.php', // Archivo PHP para manejar la solicitud
      data: { nombre_tablero: nombreTablero }, // Datos a enviar
      success: function(response) {
          // Aquí puedes manejar la respuesta del servidor, por ejemplo, mostrar un mensaje de éxito
          alert('Tablero creado exitosamente');
      },
      error: function(error) {
          // Manejar errores si ocurren durante la solicitud
          console.error('Error al crear el tablero: ' + error.responseText);
      }
  });
});
