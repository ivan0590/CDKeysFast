$(function () {

    //Carga la configuración de inicio de la tabla
    function initEditionTable() {

        //Oculta la opción de borrar elementos
        $('[data-target="#modal-erase"]').hide();

        //Selecciona todos los elementos
        $('#check-all').on('click', function () {
            $('.delete-check').prop("checked", $('.delete-check:not(:checked)').length);

            $('.delete-check:checked').length ?
                    $('[data-target="#modal-erase"]').fadeIn(400) :
                    $('[data-target="#modal-erase"]').fadeOut(400);
        });

        //Marca o desmarca el selector de todos los elementos
        $('.delete-check').on('change', function () {
            $('#check-all').prop("checked", (!$('.delete-check:not(:checked)').length));

            $('.delete-check:checked').length ?
                    $('[data-target="#modal-erase"]').fadeIn(400) :
                    $('[data-target="#modal-erase"]').fadeOut(400);
        });
    }

    //
    initEditionTable();

    //Cambiar el texto de la ventana modal
    $('[data-target="#modal-erase"]').on('click', function (event) {
        var selected = $('.delete-check:checked').length;
        
        if (selected) {
            $('#modal-erase .modal-body p').html('¿Seguro que desea borrar los elementos seleccionados (' + selected + ')? ');
        } else {
            event.preventDefault();
            return false;
        }
    });

    //Evento que realiza peticiones ajax para borrar todos los elementos seleccionados
    $('#multiple-delete').on('click', function () {

        var requests = [], l = Ladda.create(this);

        page = getURLParameter('page');

        $('.cancel-erase').hide();

        l.start();

        //Se ejecuta una petición ajax para cada uno de los elementos seleccionados
        $('.delete-check:checked').each(function (index, element) {

            //Se ejecuta la petición y se guarda en un array
            requests.push(
                    //Petición para borrar el elemento seleccionado actual
                    $.ajax({
                        type: 'DELETE',
                        url: $('#multiple-delete').data('base-url') + '/' + element.value
                    }));
        });

        //Cuando terminan de ejecutarse todas la peticiones se actualiza la tabla
        $.when.apply($, requests).done(function () {

            l.stop();

            $('.cancel-erase').show();
            $('#modal-erase').modal('hide');

            //Petición para generar una nueva tabla que refleje los cambios anteriores
            $.ajax({
                type: 'GET',
                url: $('#table-container').data('url') + '?page=' + page,
                success: function (data) {

                    //Se cambia la tabla entera y la botonera de paginación
                    $('#table-container').fadeOut(800).html(data).fadeIn(800);

                    //Se genera la configuración de inicio para la tabla
                    initEditionTable();
                }
            });
        });


    });

});