<div align="center">
    <h2>Seleccione su plan de subscripción</h2>
    <p>Planes que se ajustan a tus necesidades</p>
</div>
<br>
<div align="center">
    <h3> <span id="text_mensual" class="blue mb-0 mr-3"> Pago mensual</span>
        <label for="switch" class="pointer">
            <div for="switch" onclick="switch_plan()" class="switch-button switch-button-yesno ta-l">
                <input type="checkbox" id="switch">
                <span><label for="switch"></label></span>
            </div>
        </label>
        <span id="text_anual" class="light-c mb-0 ml-3">Pago anual</span></h3>
</div>


<div class="row">
    <div class="col-sm-4"><?php $this->load->view('register/plan_basic') ?></div>
    <div class="col-sm-4"><?php $this->load->view('register/plan_ultimate') ?></div>
    <div class="col-sm-4"><?php $this->load->view('register/plan_premium') ?></div>
</div>

<script>
    function switch_plan() {
        var toggle = $('#switch')
        if (toggle.is(':checked')) {
            $("[data-btn=first_btn]").prop('disabled', true);
            $("[data-btn=second_btn]").prop('disabled', false);
            $('[name="year_plan"]').removeClass('hidden');
            $('[name="month_plan"]').addClass('hidden');
            $('#text_mensual').removeClass('blue').addClass('light-c');
            $('#text_anual').removeClass('light-c').addClass('blue');

        } else {
            $("[data-btn=first_btn]").prop('disabled', false);
            $("[data-btn=second_btn]").prop('disabled', true);
            $('[name="year_plan"]').addClass('hidden');
            $('[name="month_plan"]').removeClass('hidden');
            $('#text_mensual').removeClass('light-c').addClass('blue');
            $('#text_anual').removeClass('blue').addClass('light-c');
        }
    }
</script>