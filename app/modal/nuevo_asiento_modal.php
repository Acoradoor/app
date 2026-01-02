<!-- Modal para Nuevo Asiento -->
<div class="modal fade" id="modalNuevoAsiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Nuevo Asiento Contable</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoAsiento">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaAsiento">Fecha</label>
                                <input type="date" class="form-control" id="fechaAsiento" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="conceptoAsiento">Concepto</label>
                                <input type="text" class="form-control" id="conceptoAsiento" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cuentaDebe">Cuenta Débito</label>
                                <select class="form-control" id="cuentaDebe" required>
                                    <option value="">Seleccione una cuenta</option>
                                    <!-- Opciones cargadas dinámicamente -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cuentaHaber">Cuenta Crédito</label>
                                <select class="form-control" id="cuentaHaber" required>
                                    <option value="">Seleccione una cuenta</option>
                                    <!-- Opciones cargadas dinámicamente -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="importeAsiento">Importe (€)</label>
                                <input type="number" step="0.01" class="form-control" id="importeAsiento" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="referenciaAsiento">Referencia</label>
                                <input type="text" class="form-control" id="referenciaAsiento">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcionAsiento">Descripción</label>
                                <textarea class="form-control" id="descripcionAsiento" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarAsiento">Guardar Asiento</button>
            </div>
        </div>
    </div>
</div>