<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<style>

    h6 ,label{
        font-weight: 800;
        font-family: ' monospace';
 

    }

#total_votos , #voto_si ,#voto_no ,#total_E_si ,#total_E_no{
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

#total_votos.animado , #voto_si.animado ,#voto_no.animado ,#total_E_si.animado ,#total_E_no.animado {
    color: red;
    opacity: 0.8;
}
    .card {
        position: relative;
        overflow: hidden;
        /* Agregamos la propiedad overflow: hidden; */
    }

    .card2 {
        width: 100%;
        height: 300px;
        background-color: #f2f2f2;
        border-radius: 5px;
        padding: 10px;
    }

    #grafico {
        width: 100%;
        height: 100%;
    }


    @keyframes borderAnimation {
        0% {
            left: -100%;
            width: 100%;
        }

        50% {
            left: 100%;
            width: 100%;
        }

        100% {
            left: 100%;
            width: 0;
        }
    }

    .border-animation {
        position: absolute;
        bottom: 0;
        height: 3px;
        animation-duration: 6s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }



    .card {

        --ring-min-size: 20px;
        --ring-max-size: 150px;
        --ring-width: 3px;
        --main-bg-color: #814fd1;
        --gradient-bg-color-1: rgb(222, 203, 226);
        --gradient-bg-color-2: rgb(79, 131, 209);
        --ring-color: #6f00ff;
        --shadow-color: 12px 2px 24px rgb(172 21 175 / 18%);
        --hover-shadow-color: rgba(79, 99, 209, 0.64);
        --main-fg-color: #313133;
        --hover-fg-color: rgb(38, 11, 53);
        min-width: var(--min-width);
        min-height: var(--min-height);
        text-transform: uppercase;
        color: var(--main-fg-color);

        box-shadow: 12px 2px 24px var(--shadow-color);
        transition: all 0.3s ease-in-out 0s;
        cursor: pointer;
        outline: none;
        position: relative;

    }



    .card:hover,
    .card:focus {
        transform: translateY(-5px);
    }


    .card:hover::before,
    .card:focus::before {
        opacity: 1;
    }

    /* ring */
    .card::after {
        content: '';
        width: var(--ring-min-size);
        height: var(--ring-min-size);
        position: absolute;
        z-index: -1;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: ring 1.5s infinite;
    }



    @keyframes ring {
        0% {
            width: var(--ring-min-size);
            height: var(--ring-min-size);
            opacity: 0.5;
        }

        100% {
            width: var(--ring-max-size);
            height: var(--ring-max-size);
            opacity: 0;
        }
    }
</style>


<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<div class="container-fluid  ">
<div style="text-wrap: nowrap; background-image: url('https://static.vecteezy.com/system/resources/previews/017/642/033/non_2x/economy-and-finance-background-concept-financial-business-statistics-stock-market-candlesticks-and-bar-chart-vector.jpg'); background-repeat: no-repeat; padding:10px;" class="row  align-items-center text-lowercase mt-5 ">

<!-- <div class="col-12 col-md-12 mb-3 mt-4 ">

    <form method="post" action="<?php  echo base_url() ?>admin/estadistica_votos">
        <div class="row align-items-center">
            <div class="col-md-3">
             
                <div class="form-group">
                    <div class="form-line">
                        <select required class="form-control show-tick" id="cod_estado" name="cod_estado">
                            <option value="">Seleccione un Estado</option>
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
            <div class="col-md-3">
              
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
            <div class="col-md-3">
               
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

            <div class="col-12 col-md-3 "> <button  class="btn btn-primary">Consultal</button></div>
        </div>

       
    </form>

</div> -->




<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
    <div class="card ">
        <div class="card-body">
            <div class="d-flex ">
                <div class="mt-2">
                    <h6 class="">Total  1*10</h6>
                    <h2 id="UnoPorDies" class="mb-0 number-font">0</h2>

                </div>
                <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                        <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
    <div class="card ">
        <div class="card-body">
            <div class="d-flex ">
                <div class="mt-2">
                    <h6 class="">1*10 por votar </h6>
                    <h2 id="UnoPorDies_no" class="mb-0 number-font">0</h2>

                </div>
                <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                        <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>






<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
    <div class="card ">
        <div class="card-body">
            <div class="d-flex ">
                <div class="mt-2">
                    <h6 class=""> Servidores publico TOTAL DE VOTOS</h6>
                    <h2 id="voto_si" class="mb-0 number-font"><?php  echo $empleado_si ?></h2>

                </div>
                <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                        <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
    <div class="card ">
        <div class="card-body">
            <div class="d-flex ">
                <div class="mt-2">
                    <h6 class=""> Servidores publico por (VOTAR)</h6>
                    <h2 id="voto_no" class="mb-0 number-font"><?php  echo $empleado_no ?></h2>

                </div>
                <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                        <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>





<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
    <div class="card ">
        <div class="card-body">
            <div class="d-flex ">
                <div class="mt-2">
                    <h6 class="">TOTAL DE VOTOs Estructura  </h6>
                    <h2 id="total_E_si" class="mb-0 number-font">0</h2>

                </div>
                <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                        <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>





<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
    <div class="card ">
        <div class="card-body">
            <div class="d-flex ">
                <div class="mt-2">
                    <h6 class=""> Estructura por votar </h6>
                    <h2 id="total_E_no" class="mb-0 number-font"><?php  echo $estructura_no ?></h2>

                </div>
                <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                        <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="col-12 col-md-3">
    <div class="card ">
        <div class="card-body ">
            <div class="d-flex ">
                <div class="mt-2">
                    <h6 class=""> Total de votos</h6>
                    <h2 id="total_votos" class="mb-0 number-font"><?php echo $voto_si ?></h2>

                </div>
               
            </div>

        </div>
    </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
    <div class="card ">
        <div class="card-body">
        <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;"> <iframe style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden" frameborder="0" type="text/html" src="https://www.dailymotion.com/embed/video/x8rtkvs?autoplay=1" width="100%" height="100%" allowfullscreen title="Dailymotion Video Player" allow="autoplay; web-share"> </iframe> </div>


        </div>
    </div>
</div>



</div>


<div style="text-wrap: nowrap; background-image: url('https://static.vecteezy.com/system/resources/previews/017/642/033/non_2x/economy-and-finance-background-concept-financial-business-statistics-stock-market-candlesticks-and-bar-chart-vector.jpg'); background-repeat: no-repeat; padding: 5px;" class="row justify-content-center align-items-center mt-4 ">
<div class="col-md-6">
   <div class="card">
        <div class="card-header">
            <h3></h3>
        </div>
        <div class="card-body">
        <div class="row align-items-center">
            
            <div class="d-flex mx-auto text-center justify-content-center mb-4">
                <div class="d-flex text-center justify-content-center me-3"><span class="dot-label bg-primary my-auto"></span>Votos  por estado</div>

            </div>
            <div class="chartjs-wrapper-bripas">
                <canvas  style="height: 400px;"  id="chartBar1" class="chart-dropshadow"></canvas>
            </div>
        </div>
    </div>
</div>
</div>



<div class="col-12 col-md-6">

                    <div class="card">
                       
                        <div class="card-body">
                        <div style="height: 438px;" id="map"></div>
                        </div>
                    </div>

</div>

</div>

</div>
