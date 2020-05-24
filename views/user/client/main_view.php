<?php $this->load->view('user/modal/documentos/pdf_modal') ?>

<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
	<h1><i class="fas fa-user-tag" aria-hidden="true"></i> Clientes</h1>
</div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			<?php
				if($pages_access[2] == 2){ 
			echo new_button('<i class="fas fa-folder-plus"></i> Nuevo cliente','new',' bg-primary float-right','onclick=go_to("clientes/nuevo")');
		              } ?>
		</div>
	
</div>

<br>




<div class="card p-4">

<h4 class="blue"><i class="fas fa-search"></i> Buscar cliente</h4>

                    <div class="form-group row ta-r">
							<label for="filter" class="col-md-2 control-label mt-2"><i class="fas fa-user-tag"></i> Cliente </label>
							<div class="col-md-6 ta-c m-2">
								<input type="text" class="form-control" id="filter" placeholder="Nombre del cliente">
								<input type="text" class="form-control hidden" id="filter2">
							
							</div>			
							
							<div class="col-md-4 ta-l m-2">
								<button type="button" class="btn btn-primary btn-sm" id="search" onclick='buscar(0,1,"#filter");'>
								<i class="fas fa-search" aria-hidden="true"></i> Buscar</button>
						
                             </div>	
					   </div>
					   
					   
</div>

<div class="alert-box" id="results">  </div>

<div class="card">
	<div class="row p-2">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			<h4 class="p-4" style="font-size:15px;font-weight:500">Nº de Clientes: <?php echo $total_clientes; ?></h4>
		</div>
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 float-right " id="pagination">
		</div>
	</div>
	
	<div class=" pl-4 pr-4 pb-3" id="result_table"> 
		<?php $this->load->view('user/client/main_table') ?>
	</div>
</div>
