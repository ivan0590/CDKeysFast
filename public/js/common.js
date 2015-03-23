$(function () {

    //Login oculto al inicio
    $("#login").hide();

    //Menú emergente de login
    $("[data-toggle=login]").popover({
        html: true,
        trigger: 'click',
        content: function () {
            return $('#login').html();
        }
    });

    //Se muestra el menú de login al cargar la página en función de si han habido errores
    if ($(".login-error").length) {
        $("[data-toggle=login]").trigger('click');
    }

    //Ordenación
    if ($("#sorter").length) {
        $("#sorter").on('change', function () {
            window.location.href = this.value;
        });
    }

    //Fecha de nacimiento
    if ($(".date-selector").length) {
        $(".date-selector").datepicker({
            dateFormat: "dd-mm-yy"
        });
    }

    //Ventanas modales
    if ($('#modal-results .modal-body div').length) {
        $('#modal-results').modal('show');
    }

    //Listas duales
    if ($('select[name$="[]"]').length === 3) {

        //Lista dual del texto
        $('select[name="text[]"]').bootstrapDualListbox(
                {
                    nonSelectedListLabel: 'Lenguajes del texto disponibles',
                    selectedListLabel: 'Lenguajes del texto seleccionados',
                    filterPlaceHolder: 'Filtrar',
                    moveOnSelect: false
                }
        );


        //Lista dual del audio
        $('select[name="audio[]"]').bootstrapDualListbox(
                {
                    nonSelectedListLabel: 'Lenguajes del audio disponibles',
                    selectedListLabel: 'Lenguajes del audio seleccionados',
                    filterPlaceHolder: 'Filtrar',
                    moveOnSelect: false
                }
        );

        //Lista dual de los desarrolladoras
        $('select[name="developer[]"]').bootstrapDualListbox(
                {
                    nonSelectedListLabel: 'Desarrolladoras disponibles',
                    selectedListLabel: 'Desarrolladoras seleccionadas',
                    filterPlaceHolder: 'Filtrar',
                    moveOnSelect: false
                }
        );
    }
    //Para rellenar imagenes SVG
    jQuery('img.svg').each(function () {
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function (data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Add replaced image's ID to the new SVG
            if (typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass + ' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');

            // Replace image with new SVG
            $img.replaceWith($svg);

        }, 'xml');

    });
});
