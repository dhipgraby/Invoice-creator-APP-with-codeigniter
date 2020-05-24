


<div class="btn-group pull-right" id="btn-group" role="group" aria-label="First group">



<span id="pages">

<button type="button" class="btn btn-light " onclick="doc_pagination(this.value,<?php echo $total_pages; ?>,'<?php echo $doc_type; ?>')"  value="<?php echo $back; ?>">
<b><i class="fas fa-angle-double-left"></i></b></button>

<div class="btn-group mr-2 ml-2" role="group" aria-label="First group">

<?php

  for($x=$page,$y=0; $y < 5;$y++) {
  
if($y < $left_pages){

  $x++;

?>
  
  <button type="button" class="btn btn-light" name="pagebtn" onclick='load_doc(this.value,0,"<?php echo $doc_type; ?>");' value="<?php echo $x; ?>"><?php echo $x; ?></button>

  <?php 
}

  }  

?>

</div>

<button type="button" class="btn btn-light " onclick="doc_pagination(this.value,<?php echo $total_pages; ?>,'<?php echo $doc_type; ?>')" value="<?php echo $next_pages; ?>">
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