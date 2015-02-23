<!DOCTYPE html>
<html lang="es-ES">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Verificación de correo electrónico</h1>

        <div>
            <h3>Gracias por crear una cuenta de CDKeysFast</h3>
            <p>Por favor, accede al siguiente enlace para verificar tu dirección de correo electrónico:<br/>
                {{ URL::route('confirm_user', ['id' => $id, 'confirmation_code' => $confirmation_code]) }}.</p>
        </div>

    </body>
</html>
