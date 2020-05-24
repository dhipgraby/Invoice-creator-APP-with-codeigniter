<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuracion extends Buster_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function option($name)
    {

        $value = $_POST['set_value'];

        if (!in_array($value, array(1, 2))) {
            return FALSE;
        }

        if ($this->config_m->set_option($name, $value) == FALSE) {
            $error = 'Error en las opciones. Recargue la aplicación';
            echo alert_msg($error, 'warning');
        }
        $name = $this->switch_name($name);
        $message = ($value == 1) ? 'Opción de ' . $name . ' habilitada' : 'Opción de ' . $name . ' deshabilitada';
        $type = ($value == 1) ? 'success' : 'info';
        echo alert_msg($message, $type);
    }

    public function payment($name)
    {

        $value = $_POST['set_value'];

        if (!in_array($value, array(1, 2))) {
            return FALSE;
        }

        if ($this->config_m->set_payment_option($name, $value) == FALSE) {
            $error = 'Error en las opciones. Recargue la aplicación';
            echo alert_msg($error, 'warning');
        }

        $message = ($value == 1) ? 'Opción de ' . $name . ' habilitada' : 'Opción de ' . $name . ' deshabilitada';
        $type = ($value == 1) ? 'success' : 'info';
        echo alert_msg($message, $type);
    }
    //Guardando contenido de textos
    function text($name)
    {
        $content = $_POST['content'];
        $table = $this->table_name($name);

        if ($this->config_m->set_text($table, $content) == TRUE) {
            $name = $this->switch_name($name);
            $message = 'Textos de ' . $name . ' actualizados';
            echo alert_msg($message, 'success');
        } else {
            $message = 'No se han realizado cambios';
            echo alert_msg($message, 'info');
        }
    }
    //Guardando contenido de textos
    function products_unit()
    {
        $config_num = $_POST['config_num'];
        
        if ($this->config_m->products_unit($config_num) == TRUE) {            
            $message = 'Unidades de productos actualizadas';
            echo alert_msg($message, 'success');
        } else {
            $message = 'No se han realizado cambios';
            echo alert_msg($message, 'info');
        }
    }
    function load_text($name)
    {

        if (empty($name)) {
            return FALSE;
        }
        $table = $this->table_name($name);
        $text = $this->config_m->doc_config()->$table;

        echo '<textarea style="height:80vh;"  id="text_content">
   ' . $text . '
   </textarea>
   <script>
    $("#text_content").summernote({
        toolbar: [    
            ["style", ["style","bold", "italic","underline","clear"]],
            ["font", ["strikethrough"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol","paragraph"]],
            ["height", ["height"]],
                ],
   height: 600,
   minHeight: null,
   maxHeight: null,
   focus: false, 
});
   </script>';
    }


    function table_name($name)
    {
        $table = '';
        switch ($name) {
            case 'c_contratacion':
                $table = 'text_contratacion';
                break;
            case 'c_venta':
                $table = 'text_ventas';
                break;
            case 'lopd':
                $table = 'text_lopd';
                break;
        }
        return $table;
    }

    function switch_name($name)
    {
        switch ($name) {
            case 'c_contratacion':
                $name = 'Condiciones de contratación';
                break;
            case 'c_venta':
                $name = 'Condiciones de venta';
                break;
            case 'sin_partida':
                $name = 'productos sin partida';
                break;
            case 'partidas':
                $name = 'crear partidas';
                break;
        }
        return $name;
    }
}
