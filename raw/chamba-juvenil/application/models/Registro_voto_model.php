<?php

    class Registro_voto_model extends CI_Model {

        function __construct() {
            parent::__construct();
            $this->load->database();

          
        }



        public function get_registro_votos($estado = 0){
            $this->db->select('tbl_registro_del_voto.* , estado.nombre as estado ,municipio.nombre as m ,parroquia.nombre as p ,tbl_roles.nombre as rol');
           $this->db->where('voto',"si");
           $this->db->join('tbl_estado estado', 'estado.codigoestado = tbl_registro_del_voto.codigoestado');
           $this->db->join('tbl_municipio municipio', 'municipio.codigomunicipio = tbl_registro_del_voto.codigomunicipio');
           $this->db->join('tbl_parroquia parroquia', 'parroquia.codigoparroquia = tbl_registro_del_voto.codigoparroquia' , 'left');
           $this->db->join('tbl_roles', 'tbl_roles.id_rol = tbl_registro_del_voto.tipo_estructura');
           $this->db->group_by('estado.nombre ,tbl_registro_del_voto ,tbl_registro_del_voto.id ,municipio.nombre ,parroquia.nombre ,tbl_roles,tbl_roles.nombre');
        
           if($estado !=0)  $this->db->where("estado.codigoestado", $estado);

           $this->db->order_by("tbl_registro_del_voto.id", "desc");

           $query = $this->db->get("tbl_registro_del_voto");
           
           if ($query->num_rows()) $valor = $query->result();
           else $valor = [];
   

           return $valor;

        }
        public function total_de_votos_get($estado = 0){

            $this->db->select('count(id) as total,
             estado.nombre AS estado 
            ');

            $this->db->where('voto',"si");

            $this->db->join('tbl_estado estado', 'estado.codigoestado = tbl_registro_del_voto.codigoestado' , 'left');
            $this->db->group_by('estado.nombre');
            


            if($estado !=0)  $this->db->where("estado.codigoestado", $estado);
           


            $query = $this->db->get("tbl_registro_del_voto");
            
 
            if ($query->num_rows()) $valor = $query->result();
            else $valor = [];
    

            return $valor;

        }

        public function existe_cedula($cedula){
            $this->db->limit(1);
            $this->db->from('public.tbl_registro_del_voto');
            $this->db->where('cedula',$cedula);
         
            $resultado = $this->db->get();
    
            if ($resultado->row()) {
                return TRUE;
            }else{
                return FALSE;
            }

        }
        public function existe_cedula_estrucutura($cedula){
            $this->db->limit(1);
            $this->db->from('public.tbl_estructura_preorizado');
            $this->db->where('cedula',$cedula);
         
            $resultado = $this->db->get();
    
            if ($resultado->row()) {
                return TRUE;
            }else{
                return FALSE;
            }

        }


       public function post_registro_voto($data){

        $this->db->insert('tbl_registro_del_voto',$data);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
            

            return  true;
		}

       }
       public function registro_estrucutura($data){

        $this->db->insert('tbl_estructura_preorizado',$data);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
            
            return  true;
		}

       }

       public function delete_registro_votos($data){

       }

       public function update_registro_votos($data){

       }



public function Existe_cl($cedula){

    // tbl_municipio.nombre AS municipio, 
    // tbl_parroquia.nombre AS parroquia,Cedula,		
    // tbl_parroquia.latitud, tbl_parroquia.longitud 

        $this->db->select('tbl_servidores_publico.*,
         tbl_roles.nombre as roles
       				
        ');
        $this->db->limit(1);
        $this->db->where('cedula',$cedula);
    
        // $this->db->join('tbl_estado', 'tbl_estado.codigoestado = tbl_servidores_publico.codigoestado');
         $this->db->join('tbl_roles', 'tbl_roles.id_rol = tbl_servidores_publico.tipo_estructura');
        // $this->db->join('tbl_municipio', 'tbl_municipio.codigomunicipio = tbl_estructura_anterior.Municipio');
        //$this->db->join('tbl_parroquia', 'tbl_parroquia.codigoparroquia = tbl_estructura_anterior.Parroquia');


        $query = $this->db->get('tbl_servidores_publico');

        if ($query->num_rows()) $valor = $query->row();
        else $valor = false;
        return $valor;
    }




public function Existe_cl_estructura($cedula){
        $this->db->select('tbl_estructura_preorizado.*,
         tbl_roles.nombre as roles');
        $this->db->limit(1);
        $this->db->where('cedula',$cedula);
        $this->db->join('tbl_roles', 'tbl_roles.id_rol = tbl_estructura_preorizado.tipo_estructura');
        $query = $this->db->get('tbl_estructura_preorizado');

        if ($query->num_rows()) $valor = $query->row();
        else $valor = false;
        return $valor;
    }


    public function empleado_por_votar_get(){

        $this->db->select('count(id) as total ,
            SUM(CASE WHEN tbl_servidores_publico.voto = \'si\' THEN 1 ELSE 0 END) as si, 
              SUM(CASE WHEN tbl_servidores_publico.voto = \'no\' THEN 1 ELSE 0 END) as no, ');

      


            $query = $this->db->get("tbl_servidores_publico");
            if ($query->num_rows()) $valor = $query->result();
            else $valor = [];
            return $valor;

    }

    public function total_UnoPorDie(){

        $this->db->select('count(id) as total , SUM(CASE WHEN tbl_estructura_preorizado.voto = \'si\' THEN 1 ELSE 0 END) as si, 
              SUM(CASE WHEN tbl_estructura_preorizado.voto = \'no\' THEN 1 ELSE 0 END) as no,');

             $this->db->where('tipo_estructura','18');
            $query = $this->db->get("tbl_estructura_preorizado");
            if ($query->num_rows()) $valor = $query->row();
            else $valor = [];
            return $valor;

    }

    public function estructura_por_votar_get(){
        $this->db->select('count(id) as total,SUM(CASE WHEN tbl_estructura_preorizado.voto = \'si\' THEN 1 ELSE 0 END) as si, 
              SUM(CASE WHEN tbl_estructura_preorizado.voto = \'no\' THEN 1 ELSE 0 END) as no, ');

              $this->db->where_in('tipo_estructura',[19 , 3,20 ,2]);

  
            $query = $this->db->get("tbl_estructura_preorizado");
            if ($query->num_rows()) $valor = $query->result();
            else $valor = [];
            return $valor;

    }

    public function update_empleado($datos ,$cedula){
        $this->db->where('cedula',$cedula);
        $this->db->update('tbl_servidores_publico', $datos);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function insert_empleado($datos ){
        $this->db->insert('tbl_servidores_publico', $datos);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function update_estructura($datos ,$cedula){
        $this->db->where('cedula',$cedula);
        $this->db->update('tbl_estructura_preorizado', $datos);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function insert_estructura($datos ,$cedula){
        $this->db->insert('tbl_estructura_preorizado', $datos);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function total_votos(){
        $this->db->select('count(id) as total ');
        $this->db->where('voto',"si");


        $query = $this->db->get("tbl_registro_del_voto");
        if ($query->num_rows()) $valor = $query->row();
        else $valor = [];
        return $valor;
       
    }


      

    }