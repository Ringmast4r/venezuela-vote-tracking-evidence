<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Registro_voto extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Registro_voto_model');
        $this->load->model('Estructuras_model');
        $this->load->model('Usuarios_admin_model');
        $this->load->model('Musuarios');
        $this->load->library('form_validation');
        date_default_timezone_set('America/Caracas');
    }


    public function index()
    {

        $breadcrumb = (object) [
            "menu" => "Admin",
            "menu_seleccion" => "Inicio"

        ];

        $roles_estructura =  $this->Roles_model->obtener_roles('estructura');


        $output = [
            "menu_lateral" => "admin",

            "title"             => "Registro de votos",
            "vista_principal"   => "admin/registro_voto",
            "estados"          => $this->Musuarios->getEstados(),
            "responsabilidad_estructuras"   =>  $this->Estructuras_model->responsabilidad_estructuras(),
            "roles" => $roles_estructura,
            // "ficheros_js" => [recurso("registro_votos_js")],

            "ficheros_js" => [recurso("RegistroCredenciales_js"), recurso("mapa_mabox_js")],

            "ficheros_css" => [recurso("mapa_mabox_css")],


        ];

        $this->load->view("main", $output);
    }

    public function registro()
    {

        $breadcrumb = (object) [
            "menu" => "Admin",
            "menu_seleccion" => "Inicio"

        ];

        $roles_estructura =  $this->Roles_model->obtener_roles('estructura');



        $output = [
            "menu_lateral" => "admin",
            "vista_principal"   => "admin/registro",
            "breadcrumb"      =>   $breadcrumb,

            "estados"          => $this->Musuarios->getEstados(),
            "responsabilidad_estructuras"   =>  $this->Estructuras_model->responsabilidad_estructuras(),
            "roles" => $roles_estructura,
            // "ficheros_js" => [recurso("registro_votos_js")],
            "ficheros_js" => [recurso("RegistroCredenciales_js")],

        ];

        $this->load->view("main", $output);
    }




    public function  post_registro_votos()
    {

        $id_usuario = $this->Registro_voto_model->existe_cedula($_REQUEST['cedula']);





        if ($id_usuario) {
            echo  json_encode(['response' => false, 'mensaje' => 'la cedula ya esta registrada']);
            exit();
        } else {

            $data = array(
                'nombre' => $_REQUEST['nombre'],
                'cedula' => $_REQUEST['cedula'],
                'telefono' => $_REQUEST['telefono'],
                'tipo_estructura' => $_REQUEST['id_estructura'],
                'codigoestado' => $_REQUEST['cod_estado'],
                'codigomunicipio' => $_REQUEST['cod_municipio'],
                'codigoparroquia' => $_REQUEST['cod_parroquia'],
                'voto' => $_REQUEST['voto'],
                'centro_de_votacion' => $_REQUEST['centro_votacion'],
                'latitud' => $_REQUEST['latitud'],
                'longitud' => $_REQUEST['longitud'],

            );



            $result = $this->Registro_voto_model->post_registro_voto($data);


            if ( $result && $_REQUEST['id_estructura'] == "17") {
                $data = array(
                    'voto' => $_REQUEST['voto'],
                );
                $this->Registro_voto_model->update_empleado($data, $_REQUEST['cedula']);

                echo  json_encode(['response' => true, 'mensaje' => 'Registro exitosa mente ']);
                exit();
            } else if ($result && $_REQUEST['id_estructura'] != "17") {


              
                $data = array(
                    'voto' => $_REQUEST['voto'],
                    'codigoestado' => $_REQUEST['cod_estado'],
                    'codigomunicipio' => $_REQUEST['cod_municipio'],
                    'codigoparroquia' => $_REQUEST['cod_parroquia'],
                );
                $this->Registro_voto_model->update_estructura($data, $_REQUEST['cedula']);

                echo  json_encode(['response' => true, 'mensaje' => 'Registro exitosa mente ']);
                exit();
            }


           
        }
    }



    public function listar_registros_votos()
    {

        $resultado = $this->Registro_voto_model->get_registro_votos();






        $breadcrumb = (object) [
            "menu" => "Admin",
            "menu_seleccion" => "Inicio"


        ];


        $output = [
            "datatable" => true,
            "menu_lateral" => "admin",
            "breadcrumb"      =>   $breadcrumb,
            "title"             => "Registro de votos",
            "resultado" => $resultado,
            "vista_principal"   => "admin/listar_registros_votos",



            "ficheros_js" => [recurso("listar_registros_js")],


        ];

        $this->load->view("main", $output);
    }



    public  function estadistica_votos()
    {



        $estado = 0;

        if (isset($_POST['cod_estado'])) $estado = $_POST['cod_estado'];



        $total_de_votos = $this->Registro_voto_model->total_de_votos_get($estado);
        $empleado_por_votos  = $this->Registro_voto_model->empleado_por_votar_get();
        $estructura_por_votos  = $this->Registro_voto_model->estructura_por_votar_get();



        $cabecera_voto_si = array();

        $voto_si = 0;

        foreach ($total_de_votos as $key => $value) {
            $voto_si = $value->total;
        }


        if (!empty($total_de_votos)) {
            foreach ($total_de_votos as  $row) {
                $cabecera_voto_si['campo'][] = $row->estado;
                $cabecera_voto_si['valor'][] = $row->total;
            }
        }

        $total_de_votos_si = $cabecera_voto_si;




        $breadcrumb = (object) [
            "menu" => "Admin",
            "menu_seleccion" => "Inicio"


        ];


        $output = [
            "menu_lateral" => "admin",
            // "breadcrumb"      =>   $breadcrumb,
            "title"             => "estadistica de votos",
            "vista_principal"   => "admin/estadistica_votos",
            "voto_si" =>   $voto_si,
            "empleado_no" =>   $empleado_por_votos[0]->no,
            "empleado_si" =>   $empleado_por_votos[0]->si,
            "estructura_si" =>   $estructura_por_votos[0]->si,
            "estructura_no" =>   $estructura_por_votos[0]->no,
            "estados"          => $this->Musuarios->getEstados(),



            "constantes_js" => [
                "grafico" => json_encode($total_de_votos_si),
                "voto" => json_encode($voto_si),
            ],

            "ficheros_css" => [recurso("mapa_mabox_css")],

            "ficheros_js" => [recurso("votos_js"), recurso("contador_js")],


        ];

        $this->load->view("main", $output);
    }


    public function buscar_cl()
    {
        $this->form_validation->set_rules('cedula', 'cedula', 'trim|required|strip_tags');
        $this->form_validation->set_error_delimiters('*', '');
        //reglas de validación
        $this->form_validation->set_message('required', 'El campo %s es requerido');

        //reglas de validación 
        if (!$this->form_validation->run()) {
            $mensaje_error = validation_errors();

            echo  json_encode(["resultado" => false, "mensaje" => $mensaje_error]);
            exit;
        }

        $cedula =  $this->input->post('cedula');

        // tbl_estructura_preorizado

        $resultado =   $this->Registro_voto_model->Existe_cl($cedula);






        if (empty($resultado))  $resultado =   $this->Registro_voto_model->Existe_cl_estructura($cedula);


        if ($resultado)
            echo  json_encode(["resultado" => true, "mensaje" =>  $resultado]);
        else
            echo  json_encode(["resultado" => false, "mensaje" => 'Cedula no encontrada']);
    }
    public function estructura_preorizado()
    {

        $id_usuario = $this->Registro_voto_model->existe_cedula_estrucutura($_REQUEST['cedula']);

        if ($id_usuario) {
            echo  json_encode(['response' => false, 'mensaje' => 'la cedula ya esta registrada']);
            exit();
        } else {

            if (
                $_REQUEST['id_estructura'] == "17"
            ) {
                $data = array(
                    'nombre_apellido' => $_REQUEST['nombre'],
                    'cedula' => $_REQUEST['cedula'],
                    'telefono' => $_REQUEST['telefono'],
                    'tipo_estructura' => $_REQUEST['id_estructura'],
                    'codigoestado' => $_REQUEST['cod_estado'],
                    'codigomunicipio' => $_REQUEST['cod_municipio'],
                    'codigoparroquia' => $_REQUEST['cod_parroquia'],
                    'voto' => "no",
                    'centro_votacion' => $_REQUEST['centro_votacion'],
                    'id' => $_REQUEST['cedula'],

                );
                $this->Registro_voto_model->insert_empleado($data, $_REQUEST['cedula']);
                echo  json_encode(['response' => true, 'mensaje' => 'Registro exitosa mente ']);
                exit();
            } else if ($_REQUEST['id_estructura'] != "17") {
                $data = array(
                    'nombre_apellido' => $_REQUEST['nombre'],
                    'cedula' => $_REQUEST['cedula'],
                    'telefono' => $_REQUEST['telefono'],
                    'tipo_estructura' => $_REQUEST['id_estructura'],
                    'codigoestado' => $_REQUEST['cod_estado'],
                    'codigomunicipio' => $_REQUEST['cod_municipio'],
                    'codigoparroquia' => $_REQUEST['cod_parroquia'],
                    'voto' => "no",
                    'centro_votacion' => $_REQUEST['centro_votacion'],
                    'id' => $_REQUEST['cedula'],
                );
                $this->Registro_voto_model->insert_estructura($data, $_REQUEST['cedula']);

                echo  json_encode(['response' => true, 'mensaje' => 'Registro exitosa mente ']);
                exit();
            }
        }
    }


    public function total_votos()
    {
        $totalVotos_si = 0;
        $totalVotos_no = 0;
        $total_E_si = 0;
        $total_E_no = 0;
        $total_UnoPorDies = 0;

        $total = $this->Registro_voto_model->total_votos();
        $total_empleado = $this->Registro_voto_model->empleado_por_votar_get();
        $total_UnoPorDies = $this->Registro_voto_model->total_UnoPorDie();
        $voto_estrutura = $this->Registro_voto_model->estructura_por_votar_get();


       

        $total_de_votos = $this->Registro_voto_model->total_de_votos_get();



        $cabecera_voto_si = array();



        if (!empty($total_de_votos)) {
            foreach ($total_de_votos as  $row) {
                $cabecera_voto_si['campo'][] = $row->estado;
                $cabecera_voto_si['valor'][] = $row->total;
            }
        }

        $total_de_votos_si = $cabecera_voto_si;


        foreach ($total_empleado as $key => $value) {
            $totalVotos_si = $value->si;
            $totalVotos_no = $value->no;
        }

        foreach ($voto_estrutura as $key => $value) {
            $total_E_si = $value->si;
            $total_E_no = $value->no;
        }

        if($total_UnoPorDies->si == null) $total_UnoPorDies->si = 800;
        if($total_UnoPorDies->no== null) $total_UnoPorDies->no = 0;




        echo json_encode([
            "response" => true,
            "resultado" => $total->total + 273 + 800,
            "total_empleado_si" => $totalVotos_si,
            "total_empleado_no" => $totalVotos_no,
            "total_E_si" => $total_E_si,
            "total_E_no" => $total_E_no,
            "UnoPorDies" => $total_UnoPorDies->si,
            "UnoPorDies_no" => $total_UnoPorDies->no,
            "total_de_votos_estado" => $total_de_votos_si
        ]);
        exit;
    }


    public function mapa()
    {


        $total = $this->Registro_voto_model->get_registro_votos();

        echo json_encode(["response" => true, "res" => $total]);
        exit;

        // echo json_encode($total);
        // exit;

    }
}
