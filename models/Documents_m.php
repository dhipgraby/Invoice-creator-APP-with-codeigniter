<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Documents_m extends MY_Model
{

    protected $_table_name = 'facturas';
    protected $_table_col = 'faucet';
    protected $_order_by = '';
    protected $_timestamps = TRUE;
    public $create_new = array(

        'documento' => array(
            'field' => 'documento',
            'label' => 'documento',
            'rules' => 'trim|required|callback__valid_doc'
        ),

        'fecha' => array(
            'field' => 'fecha',
            'label' => 'fecha',
            'rules' => 'required'
        ),

        'id_cliente' => array(
            'field' => 'id_cliente',
            'label' => 'id_cliente',
            'rules' => 'callback__valid_client'
        ),

        'n_original' => array(
            'field' => 'n_original',
            'label' => 'Número original de factura',
            'rules' => 'required|greater_than[0]|integer|numeric'
        ),

        'id_vendedor' => array(
            'field' => 'id_vendedor',
            'label' => 'id vendedor',
            'rules' => 'required'
        )
    );

    function __construct()
    {
        parent::__construct();
    }

    //CREANDO DOCUMENTO INICIAL
    function create_new($data)
    {
        if (!empty($data)) {

            $this->db2->set($data);
            if ($this->db2->insert('facturas')) {

                return TRUE;
            }
        }
        return FALSE;
    }

    //ACTUALIZAR DOCUMENTO
    function guardar($id, $data)
    {

        $this->db2->where('id_factura', $id)
            ->set($data)
            ->update('facturas');

        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    function editar_detalle($data, $id, $id_producto)
    {

        $detalle = $this->db2->where('id_producto', $id_producto)
            ->where('numero_factura', $id)
            ->get('detalle_factura')->row();

        if (!empty($data) && count($detalle)) {

            $this->db2->where('id_detalle', $detalle->id_detalle)
                ->set($data)
                ->update('detalle_factura');
            return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
        }
        return FALSE;
    }

    function get_docs($type, $filter = null, $page = null)
    {
        if ($type == null) {
            return FALSE;
        }
        $perpage = 10;
        $year = date('Y');
        $year_limit = date('Y', strtotime('+1 years'));

        if ($filter != null) {
            $year = $filter['fecha'];
            $year_limit = intval($year + 1);
        }

        if ($page == null || $page < 1) {
            $page = 1;
        }
        $start_from = ($page - 1) * $perpage;
 
        //FILTRADO POR FECHA Y TIPO
        $where = 'facturas.id_cliente=clientes.id_cliente
                      and facturas.documento="' . $type . '" and
                      year(facturas.fecha_factura) >= "' . $year . '" and
                      year(facturas.fecha_factura) < "' . $year_limit . '" ';
        //FILTRADO POR ESTADO DE DOCUMENTO
        if (!empty($filter)) {
            if ($filter['estado'] != 0) {
                $where .= ' and facturas.estado_factura =' . $filter['estado'];
            }
            //FILTRADO POR ID DE CLIENTE 
            $where .= " and  (clientes.nombre_cliente like '%" . $filter['filter'] . "%' or facturas.numero_factura like '%" . $filter['filter'] . "%')";
        }
        $total_docs =  $this->db2->where($where)->get('facturas,clientes')->num_rows();
        $docs =  $this->db2->where($where)
            ->limit($perpage, $start_from)
            ->order_by('facturas.id_factura', 'DESC')
            ->get('facturas,clientes')
            ->result_array();
        $docs['count'] = $total_docs;

        return $docs;
    }

    function fiscal_year($doc)
    {
        $años = $this->db2->where('documento', $doc)
            ->group_by('year(fecha_factura)')
            ->order_by('fecha_factura', 'desc')
            ->get('facturas')->result();
        return $años;
    }

    //DASHBOARD STATS  
    function get_stats($type)
    {

        $total_clientes = $this->db2->where('id_cliente!=', 0)->get('clientes')->result();
        if ($type != null) {

            $this->db2->where('documento', $type);
        }
        $docs =  $this->db2->get('facturas')->result();
        $total_facturas = 0;
        $facturas_pagadas = 0;
        $facturas_p = 0;
        $total_presupuestos = 0;
        $presupuestos_pagados = 0;
        $presupuestos_p = 0;
        $total_proformas = 0;
        $proformas_pagadas = 0;
        $proformas_p = 0;

        foreach ($docs as $doc) {
            switch ($doc->documento) {

                case 'factura':
                    $total_facturas++;
                    if ($doc->estado_factura == 2) {
                        $facturas_pagadas++;
                    } else {
                        $facturas_p++;
                    }
                    break;
                case 'presupuesto':
                    $total_presupuestos++;
                    if ($doc->estado_factura == 2) {
                        $presupuestos_pagados++;
                    } else {
                        $presupuestos_p++;
                    }
                    break;
                case 'proforma':
                    $total_proformas++;
                    if ($doc->estado_factura == 2) {
                        $proformas_pagadas++;
                    } else {
                        $proformas_p++;
                    }
                    break;
            }
        }
        $docs['total_clientes'] = count($total_clientes);
        $docs['total_facturas'] = $total_facturas;
        $docs['facturas_pagadas'] = $facturas_pagadas;
        $docs['facturas_p'] = $facturas_p;
        $docs['total_presupuestos'] = $total_presupuestos;
        $docs['presupuestos_pagados'] = $presupuestos_pagados;
        $docs['presupuestos_p'] = $presupuestos_p;
        $docs['total_proformas'] = $total_proformas;
        $docs['proformas_pagadas'] = $proformas_pagadas;
        $docs['proformas_p'] = $proformas_p;

        return $docs;
    }



    //DETAILS OF A DOC
    function get_details($id)
    {

        $campos = "clientes.id_cliente,
    clientes.nombre_cliente,
    clientes.telefono_cliente,
    clientes.email_cliente,
    clientes.cif,
    clientes.direccion_cliente,
    clientes.cp_cliente,
    clientes.poblacion_cliente,
    clientes.provincia_cliente,
    facturas.id_vendedor,
    facturas.id_payment,
    facturas.iva,
    facturas.proyecto,
    facturas.direccion_proyecto,
    facturas.fecha_factura,
    facturas.vencimiento,
    facturas.condiciones,
    facturas.total_venta,
    facturas.estado_factura,
    facturas.numero_factura,
    facturas.proyecto,
    facturas.documento,    
    facturas.notas";

        $stats =  $this->db2->select($campos)
            ->where("facturas.id_cliente=clientes.id_cliente and id_factura='" . $id . "'")
            ->get('facturas,clientes')->row();
        return $stats;
    }

    function get_detalle_factura($id, $id_producto = null)
    {

        $where = 'facturas.id_factura=detalle_factura.numero_factura
    and  facturas.id_factura=' . $id . ' and products.id_producto=detalle_factura.id_producto';

        if ($id_producto != null) {
            $where .= ' and products.id_producto=' . $id_producto . ' and detalle_factura.id_producto=' . $id_producto . ' ';
        }

        $detalles = $this->db2->where($where)
            ->order_by('detalle_factura.id_detalle', 'asc')
            ->get('products, facturas, detalle_factura')->result_array();
        if (!empty($detalles)) {

            for ($x = 0; $x < count($detalles); $x++) {

                $c_detalle = $this->db2->where('from_id', $detalles[$x]['id_detalle'])
                    ->where('numero_factura !=', $detalles[$x]['numero_factura'])
                    ->get('detalle_factura')->result();

                if (!empty($c_detalle)) {
                    $detalles[$x]['abonado'] = TRUE;
                }
            }
        }

        return $detalles;
    }

    function get_detalles_array($array)
    {
        if (!empty($array)) {
            $this->db2->where_in('id_detalle', $array);
            $detalles = $this->db2->get('detalle_factura')->result();
            return $detalles;
        }
    }

    function get_partidas($id)
    {

        $partidas = $this->db2->where('numero_factura', $id)
            ->order_by('orden', 'asc')
            ->get('partidas')->result();
        return $partidas;
    }
    //PARTIDAS DE GET_DETALLES_ARRAY
    function get_partidas_array($detalles)
    {
        if (!empty($detalles)) {
            foreach ($detalles as $detalle) {
                $this->db2->or_where('id_partida', $detalle->id_partida);
            }
            $partidas = $this->db2->get('partidas')->result();
            return $partidas;
        }
    }

    function get_productos_array($detalles)
    {
        if (!empty($detalles)) {
            foreach ($detalles as $detalle) {
                $this->db2->or_where('id_producto', $detalle->id_producto);
            }
            $productos = $this->db2->get('products')->result();
            return $productos;
        }
    }


    function get_users()
    {

        $users = $this->db->order_by('firstname', 'DESC')
            ->get('users')->result_array();
        return $users;
    }

    function get_clients($like)
    {

        if (!empty($like)) {
            $this->db2->like('nombre_cliente', $like);
        }
        $clients = $this->db2->limit(20)
            ->get('clientes')->result_array();
        $return_arr = array();
        foreach ($clients as $client) {

            $id_cliente = $client['id_cliente'];
            $row_array['value'] = $client['nombre_cliente'];
            $row_array['id_cliente'] = $id_cliente;
            $row_array['nombre_cliente'] = $client['nombre_cliente'];
            $row_array['telefono_cliente'] = $client['telefono_cliente'];
            $row_array['email_cliente'] = $client['email_cliente'];
            $row_array['direccion_cliente'] = $client['direccion_cliente'];
            $row_array['cp_cliente'] = $client['cp_cliente'];
            $row_array['cif'] = $client['cif'];
            $row_array['poblacion_cliente'] = $client['poblacion_cliente'];
            $row_array['provincia_cliente'] = $client['provincia_cliente'];
            array_push($return_arr, $row_array);
        }
        return $return_arr;
    }

    //NUMERO DOC
    function last_id($doc)
    {

        $year = date('Y');
        $year_limit = date('Y', strtotime('+1 years'));
        $where = ' year(facturas.fecha_factura) >= "' . $year . '"  and year(facturas.fecha_factura) < "' . $year_limit . '" ';
        $last_id = $this->db2->where('documento', $doc)
            ->where($where)
            ->select_max('numero_factura')
            ->get('facturas')->row();
        return $last_id->numero_factura;
    }

    //ID DOC
    function max_id()
    {

        $last_id = $this->db2->select_max('id_factura')
            ->get('facturas')->row();
        return $last_id->id_factura;
    }

    //BORRA UN DOCUMENTO INCLUYENDO SUS PARTIDAS DETALLES Y PRODUCTOS
    function borrar_doc($id)
    {
        $detalles = $this->db2->where('numero_factura', $id)->get('detalle_factura')->result();
        foreach ($detalles as $key) {
            $this->db2->where('id_producto', $key->id_producto)->delete('products');
        }
        $this->db2->where('old_id', $id)->set('old_id', null)->update('facturas');
        $this->db2->where('numero_factura', $id)->delete('detalle_factura');
        $this->db2->where('numero_factura', $id)->delete('partidas');
        $this->db2->where('id_factura', $id)->delete('facturas');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }
    //VACIA UN DOCUMENTO INCLUYENDO SUS PARTIDAS DETALLES Y PRODUCTOS
    function vaciar_doc($id)
    {
        $detalles = $this->db2->where('numero_factura', $id)->get('detalle_factura')->result();
        foreach ($detalles as $key) {
            $this->db2->where('id_producto', $key->id_producto)->delete('products');
        }
        $this->db2->where('numero_factura', $id)->delete('detalle_factura');
        $this->db2->where('numero_factura', $id)->delete('partidas');
        $data = array(
            'id_cliente' => 0,
            'id_payment' => 0,
            'condiciones' => 1,
            'total_venta' => 0,
            'estado_factura' => 1,
            'proyecto' => NULL,
            'direccion_proyecto' => NULL,
            'notas' => NULL,
            'iva' => 1
        );

        $this->db2->where('id_factura', $id)->set($data)->update('facturas');
        return ($this->db2->affected_rows() < 1) ? FALSE : TRUE;
    }

    function copiar($current_doc, $detalles)
    {

        $id_factura = $current_doc->id_factura;
        $new_doc = ($current_doc->documento == 'presupuesto') ? 'factura' : 'abono';
        $stats = $this->get_details($id_factura);
        $numero_factura = $this->last_id($new_doc) + 1;
        $total_factura = $this->total_calc($detalles, $stats->iva);
        $next_id  =  $this->max_id() + 1;
        $data_factura = array(

            'documento' => $new_doc,
            'numero_factura' => $numero_factura,
            'estado_factura' => $stats->estado_factura,
            'id_cliente' => $stats->id_cliente,
            'id_factura' => $next_id,
            'id_vendedor' => $stats->id_vendedor,
            'total_venta' => $total_factura,
            'id_payment' => $stats->id_payment,
            'direccion_proyecto' => $stats->direccion_proyecto,
            'proyecto' => $stats->proyecto,
            'condiciones' => $stats->condiciones,
            'notas' => $stats->notas,
            'old_id' => $id_factura,
            'n_original' => $stats->numero_factura,
            'iva' => $stats->iva,
            'fecha_factura' => date("Y-m-d H:i:s"),
            'vencimiento' => $stats->vencimiento,

        );       

        if ($this->create_new($data_factura) == TRUE) {

            $partidas = $this->get_partidas_array($detalles);
            $productos = $this->get_productos_array($detalles);
            //2 ASIGNANADO PARTIDAS 
            $this->copiar_partidas($partidas, $next_id);
            //3 ASIGNANADO DETALLES Y PRODUCTOS $this->copiar_detalles($detalles, $next_id);
            $this->copiar_productos($productos, $detalles, $next_id);

            return TRUE;
        } else {
            return FALSE;
        }
    }

    function total_calc($detalles, $iva)
    {
        $sumador_total = 0;

        if (count($detalles)) {

            foreach ($detalles as $detalle) {
                $cantidad = $detalle->cantidad;
                $precio_venta = $detalle->precio_venta;
                $precio_total = $precio_venta * $cantidad;
                $sumador_total += $precio_total; //Sumador
            }
        }

        $impuesto = 21;
        if ($iva == 0) {
            $impuesto = 0;
        }
        $subtotal = $sumador_total;
        $total_iva = ($subtotal * $impuesto) / 100;
        $total_factura = $subtotal + $total_iva;
        return $total_factura;
    }

    function copiar_productos($productos, $detalles, $id)
    {
        $this->load->model('productos_m');
        foreach ($detalles as $detalle) {
            foreach ($productos as $product) {

                if ($product->id_producto == $detalle->id_producto) {
                    $partida_id = 0;
                    if ($detalle->id_partida != 0) {
                        $partida_id = $this->db2->where('old_id', $detalle->id_partida)
                            ->where('id_partida !=', $detalle->id_partida)
                            ->where('numero_factura', $id)
                            ->get('partidas')->row()->id_partida;
                    }
                    $data = array(
                        'date_added' => date("Y-m-d H:i:s"),
                        'nombre_producto' => $product->nombre_producto,
                        'tipo' => $product->tipo,
                        'precio_producto' => $detalle->precio_venta,
                    );
                    $this->productos_m->nuevo_producto($data, $id, $partida_id, $detalle->cantidad, $detalle->id_detalle);
                }
            }
        }
    }

    function copiar_partidas($partidas, $id)
    {

        $this->load->model('partidas_m');
        if (count($partidas)) {
            foreach ($partidas as $part) {
                $data = array(
                    'datecreate' => date("Y-m-d H:i:s"),
                    'nombre_partida' => $part->nombre_partida,
                    'numero_factura' => $id,
                    'old_id' => $part->id_partida,
                );
                if (count($partidas) != count($this->get_partidas($id))) {
                    $this->partidas_m->nueva_partida($data);
                } else {
                    return TRUE;
                    break;
                }
            }
        } else {
            return TRUE;
        }
    }

    function copiar_detalles($detalles, $id)
    {

        foreach ($detalles as $detalle) {

            $partida_id = 0;
            if ($detalle->id_partida != 0) {
                $partida_id = $this->db2->where('old_id', $detalle->id_partida)
                    ->where('id_partida !=', $detalle->id_partida)
                    ->where('numero_factura', $id)
                    ->get('partidas')->row()->id_partida;
            }
            $data = array(
                'numero_factura' => $id,
                'id_producto' => $detalle->id_producto,
                'cantidad' => $detalle->cantidad,
                'precio_venta' => $detalle->precio_venta,
                'id_partida' => $partida_id,
            );
            $this->db2->set($data)->insert('detalle_factura');
        }
    }


    //REGLA PARA DETERMINAR SI UN PRODUCTO YA HA SIDO COPIADO.
    function _valid_product($detalles, $id)
    {
        $products = array();
        foreach ($detalles as $detalle) {

            $c_detalle = $this->db2->where('from_id', $detalle->id_detalle)
                ->where('numero_factura !=', $id)
                ->get('detalle_factura')->result();

            if (empty($c_detalle)) {
                array_push($products, $detalle->id_producto);
            }
        }
        return $products;
    }
}
