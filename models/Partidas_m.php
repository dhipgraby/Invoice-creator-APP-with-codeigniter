<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partidas_m extends MY_Model
{

    public $partidas = array(

        'partida' => array(
            'field' => 'partida',
            'label' => 'partida',
            'rules' => 'required'
        ),

        'numero_factura' => array(
            'field' => 'numero_factura',
            'label' => 'numero_factura',
            'rules' => 'required'
        ),

    );
    function __construct()
    {
        parent::__construct();
    }

    function get_partidas($id)
    {

        $partidas = $this->db2->where('numero_factura', $id)
            ->order_by('orden', 'asc')
            ->get('partidas')->result();
        return $partidas;
    }

    function nueva_partida($data)
    {

        if (!empty($data)) {
            $max_orden = $this->max_orden($data['numero_factura']) + 1;
            $data['orden'] = $max_orden;
            $this->db2->set($data);
            if ($this->db2->insert('partidas')) {

                return TRUE;
            }
        }
        return FALSE;
    }

    function editar_partida($id, $nombre)
    {

        $this->db2->where('id_partida', $id)
            ->set('nombre_partida', $nombre)
            ->update('partidas');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    //ORDENAR PARTIDAS .
    public function save_order($data)
    {
        $x = 0;
        foreach ($data as $d) {
            $x++;
            $this->db2->where('id_partida', $d)->set('orden', $x)->update('partidas');
        }
        return TRUE;
    }
    //maximo orden de partidas de un documento
    function max_orden($id)
    {
        $partidas = $this->db2->where('numero_factura', $id)
            ->select_max('orden')
            ->get('partidas')->row();
        $max_orden = $partidas->orden;
        return $max_orden;
    }

    function borrar_partida($id)
    {
        
        $productos_de_partida = $this->db2->where('id_partida',$id)->get('detalle_factura')->result();
        foreach($productos_de_partida as $key){
            $this->db2->where('id_producto',$key->id_producto)->delete('products');
        }
        $this->db2->where('id_partida', $id)->delete('detalle_factura');
        $this->db2->where('id_partida', $id)->delete('partidas');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }
}
