<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    <div class="container mt-5" >

        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 text-center">




                <div class="container  mx-auto justify-content-center ">

                    <div class="wrap-login100 p-6">
                        <div id="message" class="message"></div>

                        <span class="login100-form-title">
                            ESTRUCTURA DE REGISTRO DEL VOTO
                        </span>
                        <form action="">
                            <div class="row  

">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">

                                        <div class="wrap-input100 validate-input input-group">
                                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                <i class="mdi mdi-account" aria-hidden="true"></i>
                                            </a>
                                            <input class="input100 border-start-0 ms-0 form-control" data-parsley-error-message="Este campo es requerido" type="text" id="cl" maxlength="30" name="cl" placeholder="Ingrese la Cedula" required autofocus>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <button id="estructura" type="button" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>



                        </form>



                        <form id="qrForm" action="" method="POST" class="login100-form">
                            <div class="row ">

                                <div class="col-lg-6 ">

                                    <div class="form-group">
                                        <!-- <label class="form-label">Cedula</label> -->
                                        <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                <i class="mdi mdi-account" aria-hidden="true"></i>
                                            </a>
                                            <input class="input100 border-start-0 ms-0 form-control" type="text" id="nombre" name="nombre" value="<?php echo set_value('Nombre'); ?>" placeholder="Nombre y Apellido" required autofocus>
                                            <?php echo form_error('nombre'); ?>
                                        </div>

                                    </div>

                                  

                                    <div class="form-group">
                                        <!-- <label class="form-label">Cedula</label> -->
                                        <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                <i class="mdi mdi-account" aria-hidden="true"></i>
                                            </a>
                                            <input class="input100 border-start-0 ms-0 form-control" type="text" id="telefono" maxlength="8" name="telefono" value="<?php echo set_value('telefono'); ?>" placeholder="telefono" required autofocus>
                                            <?php echo form_error('telefono'); ?>
                                        </div>

                                    </div>


                                    
                                    <div class="form-group">

                                        <div class="form-line">
                                            <div class="wrap-input100 validate-input input-group">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="mdi mdi-account" aria-hidden="true"></i>
                                                </a>


                                               
                                                <select required autofocus class="form-control show-tick border-start-0 ms-0" id="id_estructura" name="id_estructura">
                                                <option value="">A que estructura Pertenece</option>
                                                
                                                <?php 
                                                $valid_roles = [3, 10, 17, 18, 17, 19, 20];
                                                foreach ($roles as $key => $rol) : 
                                                    if (in_array($rol->id_rol, $valid_roles)) :
                                                ?>

                                                    <option value="<?php echo $rol->id_rol ?>"><?php echo $rol->nombre ?></option>
                                                    
                                                <?php 
                                                    endif;
                                                endforeach
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>







                                    <!-- <label class="form-label">Correo</label> -->



                                </div>


                                <div class="col-lg-6">


                                    <div class="form-group">
                                        <!-- <label class="form-label">Cedula</label> -->
                                        <div class="wrap-input100 validate-input input-group">
                                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                <i class="mdi mdi-account" aria-hidden="true"></i>
                                            </a>
                                            <input class="input100 border-start-0 ms-0 form-control" type="text" id="cedula" maxlength="8" name="cedula" value="<?php echo set_value('cedula'); ?>" placeholder="Cédula" required autofocus>
                                            <?php echo form_error('cedula'); ?>
                                        </div>

                                    </div>


                                    <div class="form-group">


                                        <div class="form-group">
                                            <div class="wrap-input100 validate-input input-group">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="mdi mdi-account" aria-hidden="true"></i>
                                                </a>
                                                <input required name="centro_votacion" class="form-control" type="text" placeholder="Centro de votacion" id="centro_votacion">

                                            </div>
                                        </div>



                                    </div>




                                    <div class="form-group">

                                        <div class="form-line">
                                            <div class="wrap-input100 validate-input input-group">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="mdi mdi-account" aria-hidden="true"></i>
                                                </a>


                                                <select required autofocus class=" form-control show-tick border-start-0 ms-0" id="voto" name="voto" autofocus>
                                                    <option value="">¿VOTO?</option>
                                                    <option value="si">Si</option>
                                                    <option value="no">No</option>




                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                            </div>
                            <?php if ($this->session->flashdata('mensajeerror')) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger"> <?php echo $this->session->flashdata('mensajeerror'); ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($this->session->flashdata('mensajeexito')) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-success"> <?php echo $this->session->flashdata('mensajeexito'); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row" id="loader_romel" style="display: none;">
                                <div class="col-md-4 col-md-offset-5">
                                    <div class="preloader pl-size-xl">
                                        <div class="spinner-layer">
                                            <div class="circle-clipper left">
                                                <div class="circle"></div>
                                            </div>
                                            <div class="circle-clipper right">
                                                <div class="circle"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Estado</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select required class="form-control show-tick" id="cod_estado" name="cod_estado">
                                                <option value="">Seleccione una opción</option>
                                                <?php
                                                if (isset($estados)) {
                                                    foreach ($estados as $key => $estado) {

                                                        echo "<option value='" . $estado->codigoestado . "' data-latitud=" . $estado->latitud . "  data-longitud=" . $estado->longitud . " >" . $estado->nombre . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Municipio</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select required class="form-control show-tick" id="cod_municipio" name="cod_municipio">
                                                <option value="">Seleccione un Municipio</option>
                                                <?php
                                                if (isset($registroviejo->municipio)) {
                                                    echo "<option selected value='" . $registroviejo->codigomunicipio . "'>" . $registroviejo->municipio . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                        if (isset($registroviejo->estado)) {
                                            echo '<small>Seleccione un estado para cambiar</small>';
                                        }
                                        ?>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Parroquia</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select required class="form-control show-tick" id="cod_parroquia" name="cod_parroquia">
                                                <option value="">Seleccione una Parroquia</option>
                                                <?php
                                                if (isset($registroviejo->parroquia)) {
                                                    echo "<option selected value='" . $registroviejo->codigoparroquia . "' data-latitud=" . $registroviejo->latitud . "  data-longitud=" . $registroviejo->longitud . "  >" . $registroviejo->parroquia . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                        if (isset($registroviejo->estado)) {
                                            echo '<small>Seleccione un estado para cambiar</small>';
                                        }
                                        ?>
                                    </div>

                                </div>




                                <button id="registrar" type="submit" class="login100-form-btn btn-primary">
                                    Registrar
                                </button>

                                <input type="hidden" id="latitud" name="latitud" placeholder="latitud" >

                                <input type="hidden" id="longitud" name="longitud"  placeholder="longitud"  >


                            </div>



                    </div>

                    </form>
                </div>
     

        </div>

    

    </div>

    <div style="position:absolute; bottom: 0px; opacity: 0; " >
                                        <div class="small">Seleccione en el mapa su ubicación exacta</div>
                                        <div id="map"></div>

                                        <pre  id="coordinates" class="coordinates"></pre>
                                        <button style="position: absolute ; left: 20px; top: 100px; width: 30px;" type="button" id="seleccion_ubicacion" class="btn btn-icon ubicacion-c btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tu ubicación"><i class="fe fe-map-pin"></i></button>

         </div>


<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
</script>
<script>
    document.getElementById("estructura").addEventListener("click", function() {
        var $cedula_estructura = $("#cl").val();
        $.ajax({
            dataType: "json",
            data: {
                cedula: $cedula_estructura,
            },


            url: '<?php echo base_url("Registro_voto/buscar_cl"); ?>',
            type: "post",

            success: function(respuesta) {
                var Estructura = respuesta.mensaje;
                var nombre ="";

                
                if(Estructura.nombre_apellido){
                    nombre = Estructura.nombre_apellido;
                }else {
                    nombre = Estructura.nombre + " " + Estructura.apellido;
                    
                }

    
                var cedula = Estructura.cedula;
                var codigostado = Estructura.codigoestado;
                var estado = Estructura.estado;
                var centro_votacion = Estructura.centro_votacion;
                var telefono = Estructura.telefono;
                // var codigomunicipio = Estructura.codigomunicipio;
                // var municipio = Estructura.municipio;
                // var codigoparroquia = Estructura.codigoparroquia;
                // var parroquia = Estructura.parroquia;
                var tipo_estructura = Estructura.tipo_estructura;
                var roles = Estructura.roles;
               



                if (respuesta.resultado == true) {


                    let timerInterval
                    Swal.fire({
                        title: 'Buscado Espere!',
                        html: 'voy a cerrar en <b></b> miles segundo.',
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            $("#nombre").val(nombre);
                            $("#telefono").val(telefono);
                         
                            $("#cedula").val(cedula);

                            if(centro_votacion)  $("#centro_votacion").val(centro_votacion);


        
                           
                           

                            


                        }
                    })


                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: respuesta.mensaje,
                    });
                }
            },
            error: function(xhr, err) {
                console.log(err);
                alert("ocurrio un error intente de nuevo");
            },
        });
    })





    document.getElementById("qrForm").addEventListener("submit", function(e) {
        e.preventDefault();

        var nombre = $('input[name="nombre"]').val();
        var apellido = $('input[name="apellido"]').val();
        var cedula = $('input[name="cedula"]').val();
        var telefono = $('input[name="telefono"]').val();
        var cod_estado = $("#cod_estado").val();
        var cod_municipio = $("#cod_municipio").val();
        var cod_parroquia = $("#cod_parroquia").val();
        var id_estructura = $("#id_estructura").val();
        var voto = $("#voto").val();
        var centro_votacion = $("#centro_votacion").val();
        var longitud = $("#longitud").val();
        var latitud = $("#latitud").val();


        $.ajax({
            dataType: "json",
            type: 'POST',
            url: '<?php echo base_url("post_registro_votos"); ?>',
            data: {
                nombre: nombre,
                cedula: cedula,
                telefono: telefono,
                voto: voto,
                cod_estado: cod_estado,
                cod_municipio: cod_municipio,
                cod_parroquia: cod_parroquia,
                centro_votacion: centro_votacion,
                id_estructura,
                latitud,
                longitud
            },
            success: function(response) {



                if (response.response == true) {

                    Swal.fire({
                        icon: "success",
                        title: "Registro de voto Confirmado",
                        text: "Presione OK para continuar",
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $('#qrForm')[0].reset();
                            document.location.reload()
                        }
                    });

                } else if (response.response == false) {
                    Swal.fire({
                        icon: "error",
                        title: "Esta Persona ya ha sido Registrado",
                        text: "Presione OK para continuar",
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            $('#qrForm')[0].reset();


                        }
                    });
                }



            }
        });

    })
</script>