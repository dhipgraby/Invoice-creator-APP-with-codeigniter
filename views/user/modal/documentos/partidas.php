<script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
          <ul id="sortable">

<?php if(count($partidas)){

$x = 0;

foreach($partidas as $partida){
$x++;
?>

<?php
$order_partida = $partida->order;

if($order_partida == NULL){ $order_partida = $x; }

echo '<li style="cursor:pointer" name="partida_o" id="trackid_'.$partida->id_partida.'" class="ui-state-default"> '.$partida->nombre_partida.'</li>'; ?>

<?php } } ?>
</ul>