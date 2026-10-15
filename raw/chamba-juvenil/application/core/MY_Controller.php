<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Activity_model');
        date_default_timezone_set('America/Caracas');
    }

    protected function registrar_actividad($actividad)
    {
        $user_id = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');

        if (empty($user_id) && !empty($id_usuario)) {
            $user_id = $id_usuario;
        }

        if (empty($user_id) && empty($id_usuario)) {
            return false;
        }

        $data = array(
            'user_id' => $user_id,
            'activity' => $actividad,
            'timestamp' => date('Y-m-d H:i:s', strtotime('now')),
            'status' => 'Accion',
            'activo' => 0,
            'id_usuario' => $id_usuario,
        );

        return $this->Activity_model->log_activity($data);
    }
}
