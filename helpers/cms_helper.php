<?php

//RETORNA UN ARRAY PARA SER INTERPRETADO POR UNA RESPUETA AJAX
function json_alert($response,$type,$msg,$extra=NULL,$extra_data=NULL){

  $data = array('result' => $response,
                 'msg' => alert_msg($msg,$type));
 if($extra != NULL){
 $data[$extra] = $extra_data;
 }                  
    return json_encode($data);
}

function product_formating($detalle){

$data['id_to_append'] = $detalle['id_partida'];	
$data['abonado'] = $detalle['abonado'];
$data['id_detalle'] = $detalle["id_detalle"];
$data['codigo_producto'] = $detalle['codigo_producto'];
$data['cantidad'] = $detalle['cantidad'];	
$data['id_producto'] = $detalle['id_producto'];
$data['tipo'] = $detalle['tipo'];
$data['precio_venta'] = $detalle['precio_venta'];
$data['precio_venta_f']=number_format($detalle['precio_venta'],2,",",".");//Formateo variables
$data['precio_total'] =$data['precio_venta']*$data['cantidad']; 
$data['precio_total_f'] = number_format($data['precio_total'],2,",",".");//Precio total formateado
$nombre_producto= json_encode(htmlentities($detalle['nombre_producto']),JSON_UNESCAPED_UNICODE);
$nombre_producto =str_replace("\\",'"',$nombre_producto);
$nombre_producto =  str_replace(array('"r"n', '\r'), "<br>",$nombre_producto);
$data['nombre_producto'] =  str_replace('"', '',$nombre_producto);

return $data;

}

function textarea_formating($text){
    $breaks = array("<br />","<br>","<br/>");  
    $text_format = str_replace($breaks, "\r\n", $text);  
    return $text_format;
}

 function randLetter()
{
    $int = rand(0,51);
    $a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $rand_letter = $a_z[$int];
    return  $rand_letter;
}

  function new_button($name,$id,$type,$attr = NULL){

  $btn = '';

  $btn .='<button id="'.$id.'" class="btn btn-'.$type.'" '.$attr.'>'.$name.'</button>';

  return $btn;

  }

function alert_msg($content, $type,$attr=NULL){

$str = '';
$str .= '<div class="alert alert-'.$type.'" '.$attr.' role="alert"><button type="button" class="close ml-2" data-dismiss="alert" aria-label="Close"> <i class="far fa-times-circle"></i> </button>'.$content.' </div>';
return $str;

}

function e($string) {

    return htmlentities($string);
}

function active_span($text,$type){

    $str = '<span class="badge badge-'.$type.' light-b-shadow" style="position:absolute;top: 80%;right: -6%;">'.$text.'</span>';
    return $str;
}

/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable 
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}
if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}





