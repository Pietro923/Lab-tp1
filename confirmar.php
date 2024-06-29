<?php
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Aquí puedes agregar la lógica para confirmar el registro del usuario en tu base de datos

    echo '<script>alert("Usuario registrado correctamente"); window.location.href="correo.html";</script>';
} else {
    echo 'Error en la confirmación del registro.';
}
?>
