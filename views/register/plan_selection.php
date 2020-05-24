<style>
    .switch-button label:before {
    content: none;
}
.switch-button input[type=checkbox]:checked+span label:before{
    content: none;
}
</style>
<div id="plan_div" class="trans-normal fadeinright">
    <?php if(isset($canceled)){ echo $canceled; } ?>
    <?php $this->load->view('register/planes') ?>
</div>

<div id="payment_div" class="col-sm-8 trans-normal fadeinright">
    <div align="left">
        <h4 id="backToplan" class="blue pointer grow"><i class="fas fa-chevron-left"></i> Selección de planes</h4>
    </div>
    <h1 class="mt-5 blue"><i class="far fa-check-circle"></i></h1>
    <h2><span class="blue" id="current_plan"></span></h2>
     <h3 class="light-c">Información de pago</h3>
    <div><?php echo alert_msg('Al continuar, sera redirigido a una plataforma de pago segura para finalizar su subscripción','info'); ?></div>
    <br>
    <button id="" name="select-plan" class="btn btn- purchase purchase-blue grow">
        <h4 class="c-white m-0">Continuar <i class="fas fa-chevron-right"></i> 
    </button>
</div>


<script>
    var preselected_plan = '<?php if(isset($preselected_plan)){  echo $preselected_plan;  } else { echo 'null'; } ?>';
    $(document).ready(function() {
        if(preselected_plan == 'null'){
            setTimeout(function() {
            $('#plan_div').removeClass('fadeinright');
        }, 1000);
        } else {
          setTimeout(function() {
            $('[name="select-plan"]').attr('id',preselected_plan);
            var plan_id = $('#'+preselected_plan);
            var dataname = $(plan_id).data('name');        
            $('#current_plan').html(dataname);
            $('#plan_div').addClass('hidden fadeoutleft');
            $('#plan_div').removeClass('fadeinright');
            $('#payment_div').removeClass('hidden');
            setTimeout(function() {
                $('#payment_div').removeClass('fadeinright');
            }, 100);
        }, 1000);  
        }
        
    });
    $('[name="get-plan"]').click(function() {
        var plan_id = this.id;
        var dataname = $(this).data('name');        
        $('#current_plan').html(dataname);
        $('[name="select-plan"]').attr('id',plan_id);
        $('#plan_div').addClass('fadeoutleft');
        setTimeout(function() {
            $('#plan_div').addClass('hidden');
            $('#payment_div').removeClass('hidden');
            setTimeout(function() {
                $('#payment_div').removeClass('fadeinright');
            }, 100);
        }, 1100);
    });

    $('#backToplan').click(function() {
        $('#payment_div').addClass('fadeinright');

        setTimeout(function() {
            $('#plan_div').removeClass('hidden');
            setTimeout(function() {
                $('#plan_div').removeClass('fadeoutleft');
            }, 100);
            $('#payment_div').addClass('hidden');
        }, 1000);
    });
</script>