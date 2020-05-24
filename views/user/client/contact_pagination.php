<div class="btn-group pull-right p-2" role="group" aria-label="First group">



<span id="pages_c">

<button type="button" class="btn btn-light " onclick="pagination_contact(this.value,<?php echo $total_c_pages; ?>)"  value="<?php echo $back; ?>">
<b><i class="fas fa-angle-double-left"></i></b></button>

<div class="btn-group mr-2 ml-2" role="group" aria-label="First group">

<?php

  for($x=$page,$y=0; $y < 5;$y++) {
  
if($y < $left_pages){

  $x++;

?>
  
  <button type="button" class="btn btn-light" name="pagebtn" onclick='contactos_table(this.value,0);' value="<?php echo $x; ?>"><?php echo $x; ?></button>

  <?php 
}

  }  

?>

</div>

<button type="button" class="btn btn-light " onclick="pagination_contact(this.value,<?php echo $total_c_pages; ?>)" value="<?php echo $next_pages; ?>">
<b><i class="fas fa-angle-double-right"></i></b></button>

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