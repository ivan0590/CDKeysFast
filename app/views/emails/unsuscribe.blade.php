<!DOCTYPE html>
<html lang="es-ES">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1>Confirmación de eliminación de cuenta</h1>

        <div>
            <p>Si has decidido eliminar tu cuenta de CDKeysFast accede al siguiente enlace para confirmarlo:<br/>
                {{ URL::route('confirm_unsuscribe', ['id' => $id, 'unsuscribe_code' => $unsuscribe_code]) }}.</p>
        </div>

    </body>
</html>
