<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends MY_Model
{
    public $_create = array(

        'firstname' => array(
            'field' => 'firstname',
            'label' => 'Nombre completo',
            'rules' => 'required|trim'
        ),

        'user_email' => array(
            'field' => 'user_email',
            'label' => 'email',
            'rules' => 'trim|required|callback__unique_user_email|valid_email|xss_clean'
        ),

    );
    public $_user_request = array(
        'email' => array(
            'field' => 'email',
            'label' => '<b>Email</b>',
            'rules' => 'trim|callback__email_timer|valid_email|required'
        ),
    );

    public $_change_password = array(

        'new_password' => array(
            'field' => 'new_password',
            'label' => 'Nueva contraseña',
            'rules' => 'trim|required|callback__user_password_check|min_length[6]'
        ),

        'new_password_confirm' => array(
            'field' => 'new_password_confirm',
            'label' => 'Confirmar contraseña',
            'rules' => 'required|trim'
        ),
    );

    function __construct()
    {
        parent::__construct();
    }

    function user_request($data)
    {
        $this->db->where('email', $data['email'])->where('firstname', NULL)->where('password', NULL);
        $user = $this->db->get('users')->row();
        if (!empty($user)) {
            $this->db->where('user_id', $user->user_id)->set($data)->update('users');
            return TRUE;
        }
        $this->load->model('register_m');
        $user_id = $this->register_m->rand_user_code();
        $new_data = array(
            'email' => $data['email'],
            'pages_priv' => $data['pages_priv'],
            'config_priv' => $data['config_priv'],
            'datecreate' =>  date("Y-m-d H:i:s"),
            'owner' => 0,
            'user_id' => $user_id,
            'licencia' => $this->session->licencia,
            'plan_id' => $this->data['user']->plan_id,
        );
        if ($this->db->insert('users', $new_data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function _add_user_notification($email)
    {
        $current_code = $this->_get_current_code($email);
        if (!empty($current_code)) {
            return TRUE;
        }
        $code = $this->_add_code();
        $data = array(
            'type' => 'add_user',
            'email' => $email,
            'code' => $code,
            'datetime' => time(),
            'status' => 2
        );

        $this->db->set($data);
        if (!$this->db->insert('email_notifications')) {
            return FALSE;
        }
        return TRUE;
    }

    function get_all()
    {
        $users = $this->db->where('licencia', $this->session->licencia)
            ->where('owner!=', 1)
            ->get('users')->result();
        return $users;
    }

    function get_user($id)
    {
        $user = $this->db->where('user_id', $id)->get('users')->row();
        if (!empty($user)) {
            return $user;
        }
        return FALSE;
    }

    function guardar($data, $id)
    {
        $this->db->where('user_id', $id)->set($data)->update('users');
        return ($this->db->affected_rows() < 1) ? FALSE : TRUE;
    }

    function change_password($password, $id)
    {
        if (!empty($password)) {
            $this->db->where('user_id', $id)->set('password', hash('sha256', $password . config_item('encryption_key')))->update('users');
            return ($this->db->affected_rows() < 1) ? FALSE : TRUE;
        }
    }

    //PRIVILEGIOS DE USUARIO
    function set_status($user_id, $value)
    {
        $this->db->where('id', $user_id)->set('status', $value)->update('users');
        return ($this->db->affected_rows() < 1) ? FALSE : TRUE;
    }

    function update_pages_priv($id, $priv)
    {
        $this->db->where('user_id', $id)->set('pages_priv', $priv)->update('users');
        return ($this->db->affected_rows() < 1) ? FALSE : TRUE;
    }
    function update_config_priv($id, $priv)
    {
        $this->db->where('user_id', $id)->set('config_priv', $priv)->update('users');
        return ($this->db->affected_rows() < 1) ? FALSE : TRUE;
    }

    function delete_user($id)
    {
        $user = $this->get_user($id);
        $current_code = $this->_get_current_code($user->email);
        $this->db->where('code', $current_code->code)->delete('email_notifications');
        $this->db->where('user_id', $id)->where('owner!=', 1)->delete('users');
        return ($this->db->affected_rows() < 1) ? FALSE : TRUE;
    }
    //CHECK IF THRE IS A EXISTING CODE FOR NEW USER
    public function _get_current_code($email)
    {
        $code = $this->db->where('email', $email)->where('type', 'add_user')->where('status', 2)->get('email_notifications')->row();
        if (empty($code)) {
            return FALSE;
        }
        return $code;
    }
    //UNIQUE CODE FOR EMAIL
    public function _add_code()
    {
        $mail_code =  randLetter() . randLetter() . mt_rand(1000, 99999) . randLetter() . mt_rand(10, 100);
        return $mail_code;
    }

    function _users_limit()
    {
        $plan_id = $this->data['user']->plan_id;
        $limit = 0;
        switch ($plan_id) {
            case 'SLIV_001':
                $limit = 0;
                break;
            case 'SLIV_002':
                $limit = 3;
                break;
            case 'SLIV_003':
                $limit = 10;
                break;
            case 'SLIV_004':
                $limit = 0;
                break;
            case 'SLIV_005':
                $limit = 3;
                break;
            case 'SLIV_006':
                $limit = 10;
                break;
        }
        $total_users = $this->db->where('licencia', $this->session->licencia)->get('users')->num_rows();
        if ($total_users >= $limit) {
            return FALSE;
        }
        return TRUE;
    }
}
