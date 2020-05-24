 <div class="modal-header">
 <h4 class="modal-title"><i class="far fa-credit-card"></i> Datos de Pago</h4>
 </div>
 <div class="modal-body" id="payment_info">
 <?php $this->load->view('subscription/info_pago') ?>
 </div>
 <?php $this->load->view('subscription/modal_card') ?>
 <div class="modal-footer justify-content-start">
 <button class="btn btn- bg-blue" data-toggle="modal" data-target="#card_modal"><i class="fas fa-sync-alt"></i> Cambiar metodo de pago</button>
</div>