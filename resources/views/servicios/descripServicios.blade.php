<!-- Modal Descripcion -->
<div class="modal fade bd-example-modal-lg" id="modalDescripcion"tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 700px">
        <div class="modal-content modalServicio">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="myLargeModalLabel" >Detalles de servicios</h5>
                <!--boton para cerrar ventana modal-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top: -32.5px">
                    <div class="col-md-4 col-sm-12">
                        <div class="row justify-content-center">
                            <div class=" card-body pl-2 mt-4">
                                <div class="col-lg-12"> <label class="text" style="margin-bottom: 0px"><b> Nombre del servicio </b></label></div>
                                <div class="col-lg-12"><label type="text" id="nomServicio" name="Servicio" value = ""></label></div>
                                <div class="col-lg-12"><label class="text" style="margin-bottom: 0px"><b>Descripcion</b></label></div>
                                <div class="col-lg-12"><label name="Descripcion" id="descServicio" value = ""> </label></div>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="mt-4 cardTabla" style="padding-bottom: 3px">
                            <center>
                                <label class="text-bold" >Modalidad</label>
                            </center>
                            <!--tabla de modalidades y precios-->
                            <table class="table table-bordered table-hover tablaModalServicio">
                                <thead >
                                <tr>
                                    <th scope="col">Presencial</th>
                                    <th scope="col">Online</th>
                                </tr>
                                </thead>
                                <!--checkbox de modalidades disponibles y precios respectivos-->
                                <tbody>
                                <tr>
                                    <td>
                                        <b>$</b><label id="precPresencial"></label>
                                    </td>
                                    <td>
                                        <b>$</b><label id="precOnline"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b><label id="dispPresencial"></label>
                                    </td>
                                    <td>
                                        <b><label id="dispOnline"></label>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--boton cerrar modal-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary white-text text-4" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
