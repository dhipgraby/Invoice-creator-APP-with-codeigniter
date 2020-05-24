<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productos_m extends MY_Model
{

    public $productos = array(

        'nombre_producto' => array(
            'field' => 'nombre_producto',
            'label' => 'nombre producto',
            'rules' => 'required'
        ),

        'precio' => array(
            'field' => 'precio_producto',
            'label' => 'precio producto',
            'rules' => 'required|numeric'
        ),

        'cantidad' => array(
            'field' => 'cantidad',
            'label' => 'cantidad',
            'rules' => 'required|numeric'
        ),

    );


    function __construct()
    {
        parent::__construct();
    }


    function nuevo_producto($data, $id = null, $id_partida, $cantidad,$detalle_id = null)
    {

        if (!empty($data)) {
            $codigo = randLetter() . mt_rand(100, 9999) . randLetter();
            $data['codigo_producto'] = $codigo;
            $this->db2->set($data);
            if ($this->db2->insert('products')) {
                if ($id != null || $id != 0) {

                    return $this->vincular_producto($id, $id_partida, $codigo, $cantidad,$detalle_id);
                } else {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    function editar_producto($data, $id_producto)
    {
        $producto = $this->db2->where('id_producto', $id_producto)
            ->get('products')->row();
        if (!empty($data) && count($producto)) {

            $this->db2->where('id_producto', $producto->id_producto)->set($data)->update('products');
            return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
        }
        return FALSE;
    }


    function vincular_producto($id, $id_partida, $codigo, $cantidad,$detalle_id=null)
    {

        if (!empty($id) && !empty($codigo)) {
            $producto = $this->db2->where('codigo_producto', $codigo)
                ->get('products')->row();

            $detalles = array(
                'numero_factura' => $id,
                'id_producto' => $producto->id_producto,
                'cantidad' => $cantidad,
                'precio_venta' => $producto->precio_producto,
                'id_partida' => $id_partida,
            );
           if($detalle_id != null){
               $detalles['from_id'] = $detalle_id;
           }
            $this->db2->set($detalles);
            if ($this->db2->insert('detalle_factura')) {
                return TRUE;
            }
        }
        return FALSE;
    }

    function borrar_producto($id, $id_producto)
    {
        $this->db2->where('id_producto',$id_producto)->delete('products');
        $this->db2->where('id_detalle', $id)->delete('detalle_factura');

        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    //REGLA PARA DETERMINAR SI UN PRODUCTO YA HA SIDO COPIADO.
    function _valid_product($detalles, $id)
    {
        $products = array();
        foreach ($detalles as $detalle) {

            $c_detalle = $this->db2->where('id_producto', $detalle->id_producto)
                ->where('numero_factura !=', $id)
                ->get('detalle_factura')->result();

            if (empty($c_detalle)) {
                array_push($products, $detalle->id_producto);
            }
        }
        return $products;
    }
}
