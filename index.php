<!DOCTYPE html>
<html>

<head>
    <title>CRUD de pagos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h1 class="text-center">Pagos de servicios</h1>
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <!-- Formulario para agregar un nuevo pago -->
                <form id="form-agregar" class="card">
                    <div class="card-header">
                        Agregar nuevo pago
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Cliente</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="servicio">Servicio</label>
                            <select id="servicio" name="servicio" class="form-control" required>
                                <option value="Sky">Sky</option>
                                <option value="CFE">CFE</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cuenta">Número de cuenta</label>
                            <input type="text" id="cuenta" name="cuenta" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad a pagar</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="estatus">Estatus</label>
                            <select id="estatus" name="estatus" class="form-control" required>
                                <option value="Generado">Generado</option>
                                <option value="En proceso">En proceso</option>
                                <option value="Pagado">Pagado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">Agregar pago</button>
                    </div>
                </form>

                <!-- Lista de pagos -->
                <div id="lista-pagos" class="row mt-4">
                </div>

                <!-- Modal para editar un pago -->
                <div class="modal fade" id="modal-editar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form-editar">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar pago</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="editar-id" name="id" required>
                                    <div class="form-group">
                                        <label for="editar-nombre">Cliente</label>
                                        <input type="text" id="editar-nombre" name="nombre" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editar-servicio">Servicio</label>
                                        <select id="editar-servicio" name="servicio" class="form-control" required>
                                            <option value="Sky">Sky</option>
                                            <option value="CFE">CFE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editar-cuenta">Número de cuenta</label>
                                        <input type="text" id="editar-cuenta" name="cuenta" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editar-cantidad">Cantidad a pagar</label>
                                        <input type="number" id="editar-cantidad" name="cantidad" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editar-estatus">Estatus</label>
                                        <select id="editar-estatus" name="estatus" class="form-control" required>
                                            <option value="Generado">Generado</option>
                                            <option value="En proceso">En proceso</option>
                                            <option value="Pagado">Pagado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                    </div>

                                    <!-- Imagen comprobante -->
                                    <div class="form-group">
                                        <label for="editar-comprobante">Comprobante</label>
                                        <input type="file" id="comprobante" name="comprobante" class="form-control"
                                            required>
                                        <!-- Mensaje de error -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script src="script.js"></script>


</body>

</html>