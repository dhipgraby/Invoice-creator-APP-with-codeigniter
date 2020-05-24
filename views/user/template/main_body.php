<?php $this->load->view('user/template/head');
    ?>


  <div class="row">

<div id="resultados" style="margin-top:10px;"></div>

<div class="col-sm-2" >

<?php $this->load->view('user/template/menu') ?>

</div>


<div class="container col-sm-10 p-5 vh-100">


<?php $this->load->view($mainview); ?>


</div>


</div>


<?php $this->load->view('user/template/footer');
    ?>