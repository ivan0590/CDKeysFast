<!DOCTYPE html>
<html lang="es-ES">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Confirmación de cambio de contraseña</h1>

        <div>
            <p>Si has decidido cambiar tu contraseña accede al siguiente enlace para confirmarlo:<br/>
                {{ URL::route('confirm_password', ['id' => $id, 'change_password_code' => $change_password_code]) }}.</p>
        </div>

    </body>
</html>
