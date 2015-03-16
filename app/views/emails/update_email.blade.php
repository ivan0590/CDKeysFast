<!DOCTYPE html>
<html lang="es-ES">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Confirmación de cambio de correo electrónico</h1>

        <div>
            <p>Si has decidido cambiar tu email accede al siguiente enlace para confirmarlo:<br/>
                {{{ URL::route('confirm_email', ['id' => $id, 'change_email_code' => $change_email_code]) }}}.</p>
        </div>

    </body>
</html>
