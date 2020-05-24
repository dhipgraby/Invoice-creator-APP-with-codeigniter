<div class="btn-group m-3 pull-right" id="btn-group" role="group" aria-label="First group">



<span id="pages">

<?php

echo new_button('<b><i class="fas fa-angle-double-left"></i></b>','','light','type="button" onclick="pagination(this.value,'.$total_pages.')" value="'.($back).'"');

echo '<div class="btn-group mr-2 ml-2" role="group" aria-label="First group">';

  for($x=$page,$y=0; $y < 5;$y++) {
  
if($y < $left_pages){

  $x++;

?>
  
  <button type="button" class="btn btn-light" name="pagebtn" onclick='buscar(this.value,0,"#filter2","#estado2");' value="<?php echo $x; ?>"><?php echo $x; ?></button>

  <?php 
}

  }  

  echo '</div>';

echo new_button('<b><i class="fas fa-angle-double-right"></i></b>','','light','type="button" onclick="pagination(this.value,'.$total_pages.')" value="'.$next_pages.'"');



?>

</span>



</div>

<script>

  
$("[name='pagebtn']").click(function() {

	var $box = $(this);
  if ($box.hasClass("active") == false) {
  
    var group =$("[name='pagebtn']");
    
    group.removeClass("active");
	$box.addClass("active");
  } 
});</script>