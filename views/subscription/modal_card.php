<div class="modal fade" id="card_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">

                <h4 class="modal-title"><i class="far fa-credit-card"></i> Cambiar metodo de pago</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false" id="card_info">
                    <label for="card_name">Titular de la tarjeta</label>
                    <input type="text" id="card_name" name="card_name" class="form-control">
                    <br>
                    <label for="card_num">Número de tarjeta</label>
                    <input type="number" id="card_num" name="card_num" class="form-control">
                    <br>
                    <h4>Fecha de expiracón</h4>
                    <div class="row">
                        <div class="col">
                            <label for="card_month">Mes</label>
                            <input type="number" id="card_month" name="card_month" class="form-control">
                        </div>
                        <div class="col">
                            <label for="card_year">Año (2 digitos)</label>
                            <input type="number" id="card_year" name="card_year" class="form-control">
                        </div>
                    </div>
                    <br>
                    <label class="black" for="card_cvc">CVC (código de seguridad)</label>
                    <input type="number" id="card_cvc" name="card_cvc" class="form-control">
                    <br>
                    <button type="submit" id="save_card" class="btn bg-blue">Guardar</button>
                    <br>
                    <div class="mt-3" id="modal_res"></div>
                </form>

            </div>

        </div>
    </div>
</div>