$(document).ready(function () {
    // Obtener la lista de pagos al cargar la página
    obtenerPagos();

    // Agregar un nuevo pago
    $('#form-agregar').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'acciones.php',
            type: 'POST',
            data: $('#form-agregar').serialize() + '&accion=agregar',
            success: function (response) {
                $('#form-agregar')[0].reset();
                obtenerPagos();
            }
        });
    });

    // Obtener la información de un pago específico para editar
    $(document).on('click', '.btn-editar', function () {
        let id = $(this).data('id');

        $.ajax({
            url: 'acciones.php',
            type: 'POST',
            data: { id: id, accion: 'obtener' },
            success: function (response) {
                let pago = JSON.parse(response);

                $('#editar-id').val(pago.id);
                $('#editar-nombre').val(pago.nombre);
                $('#editar-servicio').val(pago.servicio);
                $('#editar-cuenta').val(pago.cuenta);
                $('#editar-cantidad').val(pago.cantidad);
                $('#editar-estatus').val(pago.estatus);
                //disable editar-cantidad, editar-servicio, editar-nombre, editar-cuenta when estatus is not'Generado'
                if (pago.estatus != 'Generado') {
                    $('#editar-cantidad').prop('readOnly', true);
                    $('#editar-servicio').prop('readOnly', true);
                    $('#editar-nombre').prop('readOnly', true);
                    $('#editar-cuenta').prop('readOnly', true);
                    //add only option pago.servicio to select
                    $('#editar-servicio').empty();
                    $('#editar-servicio').append(`<option value="${pago.servicio}">${pago.servicio}</option>`);
                } else {
                    $('#editar-cantidad').prop('readOnly', false);
                    $('#editar-servicio').prop('readOnly', false);
                    $('#editar-nombre').prop('readOnly', false);
                    $('#editar-cuenta').prop('readOnly', false);
                    //add all options to select
                    $('#editar-servicio').empty();
                    $('#editar-servicio').append(`<option value="Sky">Sky</option>`);
                    $('#editar-servicio').append(`<option value="CFE">CFE</option>`);
                }

                $('#modal-editar').modal('show');
            }
        });
    });

    // Actualizar la información de un pago
    $('#form-editar').submit(function (e) {
        e.preventDefault();

        const id = $('#editar-id').val();
        const nombre = $('#editar-nombre').val();
        const servicio = $('#editar-servicio').val();
        const cuenta = $('#editar-cuenta').val();
        const cantidad = $('#editar-cantidad').val();
        const estatus = $('#editar-estatus').val();

        const formData = new FormData();
        formData.append('id', id);
        formData.append('nombre', nombre);
        formData.append('cuenta', cuenta);
        formData.append('servicio', servicio);
        formData.append('cantidad', cantidad);
        formData.append('estatus', estatus);
        formData.append('accion', 'actualizar');

        const comprobante = $('#comprobante')[0].files[0];
        formData.append('comprobante', comprobante);



        $.ajax({
            url: 'acciones.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#form-editar')[0].reset();
                $('#modal-editar').modal('hide');
                obtenerPagos();
            }
        });
    });

    // Eliminar un pago
    $(document).on('click', '.btn-eliminar', function () {
        if (confirm('¿Estás seguro de que quieres eliminar este pago?')) {
            let id = $(this).data('id');

            $.ajax({
                url: 'acciones.php',
                type: 'POST',
                data: { id: id, accion: 'eliminar' },
                success: function (response) {
                    obtenerPagos();
                }
            });
        }
    });

    // Función para obtener la lista de pagos
    function obtenerPagos() {
        $.ajax({
            url: 'acciones.php',
            type: 'POST',
            data: { accion: 'obtener_todos' },
            success: function (response) {
                let pagos = JSON.parse(response);
                let listaPagos = '';

                pagos.forEach(function (pago) {
                    //convertir a entero para poder sumar
                    var subtotal = parseInt(pago.cantidad);
                    var comision = parseInt(pago.comision);
                    var total = subtotal + comision;

                    listaPagos += `
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">${pago.nombre}</h5>
                                    <p class="card-text"><strong>Servicio:</strong> ${pago.servicio}</p>                                    
                                    <p class="card-text"><strong>Fecha:</strong> ${pago.fecha}</p>
                                    <p class="card-text"><strong>Número de cuenta:</strong> ${pago.cuenta}</p>
                                    <p class="card-text"><strong>SubTotal:</strong> $${pago.cantidad}</p>
                                    <p class="card-text"><strong>Comisión:</strong> $${pago.comision}</p>
                                    <p class="card-text"><strong>Total:</strong> $${total}</p>
                                    <p class="card-text"><strong>Estatus:</strong> ${pago.estatus}</p>
                                    <button class="btn btn-primary btn-editar" data-id="${pago.id}">Editar</button>
                                    <button class="btn btn-danger btn-eliminar" data-id="${pago.id}">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $('#lista-pagos').html(listaPagos);
            }
        });
    }
});
