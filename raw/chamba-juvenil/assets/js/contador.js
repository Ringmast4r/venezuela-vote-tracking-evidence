

var reporte_json_si = JSON.parse(grafico);
var arr_map= [];
var votos = JSON.parse(voto);
var registros = votos;
var empleado  =0;
var empleado1  =0;
var UnoPorDie  =0;
var total_E_v  =0;
var total_E_p  =0;
var UnoPorDies_n  =0;

function obtenerNumeroUsuarios() {
    let id = 1;
    return $.ajax({
        dataType: "json",
        data: { id },
        url: base_url + "Registro_voto/total_votos",
        type: "post"
    });
}

function actualizarContador() {

	
   
	
    obtener_coordenadas_empresa(1)
    var contadorElemento = document.getElementById('total_votos');
    var votosi = document.getElementById('voto_si');
    var voto_no = document.getElementById('voto_no');
    var UnoPor = document.getElementById('UnoPorDies');
    var UnoPorDies_no = document.getElementById('UnoPorDies_no');
    var total_E_Si = document.getElementById('total_E_si');
    var total_E_No = document.getElementById('total_E_no');
    obtenerNumeroUsuarios().done(function (response) {
        if (response.response == true) {


			votos_si(response.total_de_votos_estado);



            registros = response.resultado;
            empleado = response.total_empleado_si;
            empleado1 = response.total_empleado_no;
            UnoPorDie = response.UnoPorDies;
            total_E_v = response.total_E_si;
			total_E_p  = response.total_E_no;
			UnoPorDies_n  = response.UnoPorDies_no;



           
            votosi.innerText = empleado ;
            voto_no.innerText = empleado1 ;
			UnoPor.innerText =  UnoPorDie
			total_E_Si.innerText =  total_E_v
			total_E_No.innerText = total_E_p
			UnoPorDies_no.innerText = response.UnoPorDies_no
           
            contadorElemento.innerText = registros;
    

            contadorElemento.classList.add('animado');
            votosi.classList.add('animado');
            voto_no.classList.add('animado');
			total_E_No.classList.add('animado');
			total_E_Si.classList.add('animado');
			UnoPor.classList.add('animado');
			
           
            setTimeout(function() {
                contadorElemento.classList.remove('animado');
                 votosi.classList.remove('animado');
                 voto_no.classList.remove('animado');
				 UnoPor.classList.remove('animado');
				 total_E_No.classList.remove('animado');
				total_E_Si.classList.remove('animado')
            }, 300); // La duración de la animación en ms
        }
    }).fail(function (xhr, err) {
        console.log(err);
    });
}

function actualizarContadorIntervalo() {
    setInterval(actualizarContador, 20000); 
}

actualizarContador();
actualizarContadorIntervalo();

var input_latitud = 0;
var input_longitud = 0;
var coordinates = 0;

var latitud = "8.2321";
var longitud = "-66.406";

agregarMapa(latitud, longitud, 6);


function obtener_coordenadas_empresa(accion) {
	var cod_estado = $("#cod_estado").val();
	var cod_municipio = $("#cod_municipio").val();
	var cod_parroquia = $("#cod_parroquia").val();
	// var id_rol =  $("#id_estructura").val()



	$.ajax({
		dataType: "json",
		data: { cod_estado, cod_municipio, cod_parroquia },

		url: base_url + "Registro_voto/mapa",
		type: "post",
		beforeSend: function () {
			//$("#cod_municipio").selectpicker('refresh');
		},
		success: function (respuesta) {

			if (respuesta.response == true) {
				
            let data =respuesta.res;
           
			arr_map=[];
				var latitud_e = $(" option:selected", $('#cod_estado')).attr("data-latitud");
				var longitud_e = $("option:selected", $('#cod_estado')).attr("data-longitud");
            data.forEach(element => {

			
                let puntero ={
                    'type': 'Feature',
                    'properties': {
					'marker-color': '#8B4293',
					'iconSize': [50, 50],
					'title': '',
                    'message':`
			
					
					<div class="message-container">
						<div class="image-container image1"></div>
						<div class="description-container">
						  <!-- contenido de la descripción aquí -->
						</div>
						  <div class="description-container">
							<strong>Estructura:</strong><br>
							<strong>Total integrantes:</strong> <br>
							<strong>Estado:</strong> <br>
							<strong>Municipio:</strong> <br>
							<strong>Parroquia:</strong> <br>
							
						  </div>
						</div>
						<a class="btn btn-primary w-100" href="/admin/ver/estructura-brigada/">Consultar registros</a>
				
					`
					
                    },
                    'geometry': {
                    'type': 'Point',
                    'coordinates': [element.longitud, element.latitud]
                    }
                    }
        
					latitud_e =element.latitud;
					 longitud_e=element.longitud;
                arr_map.push(puntero);
              
                
            });
				

				if($('#cod_estado').val()=='todos'){
					agregarMapa(latitud, longitud, 4.5);
				}else{

					agregarMapa(latitud_e, longitud_e, 4.5);
				}
			

				
		if(accion==2)
		location.href=base_url+'admin/reportes/excel_estructura?cod_estado='+cod_estado+'&cod_municipio='+cod_municipio+'&cod_parroquia='+cod_parroquia+'&id_rol='+id_rol



			} else {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: respuesta.mensaje,
				});
				arr_map=[];
				agregarMapa(latitud, longitud, 7);
			}
		},
		error: function (xhr, err) {
			console.log(err);
			alert("ocurrio un error intente de nuevo");
		},
	});
}


obtener_coordenadas_empresa(1);



$("#cod_estado").change(function () {
	let latitud_e = $("option:selected", $(this)).attr("data-latitud");
	let longitud_e = $("option:selected", $(this)).attr("data-longitud");

	agregarMapa(latitud_e, longitud_e, (zoom = 6));

	input_latitud.value = latitud_e;
	input_longitud.value = latitud_e;
});

$("#cod_parroquia").change(function () {
	// agregarMapa(latitud_e, longitud_e, (zoom = 12));
});

var map; 


function agregarMapa(lat = "8.2321", long = "-66.406", zoom = 7, data = []) {
    if (map) {
        map.off();
        map.remove();
    }

    map = L.map('map').setView([lat, long], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
         attribution: '&copy; <a href="">Gran Misión Chamba Juvenil</a> contributors'
    }).addTo(map);

    arr_map.forEach(function (marker) {
        var el = document.createElement('div');
        el.className = 'chamabista';

	var popupContent = '<b>Gran Misión Chamba Juvenil 📢</b><br>';

    // Verificar si marker.properties está definido antes de acceder a 'title'
    if (marker.properties && marker.properties.title) {
        popupContent += marker.properties.message;
    } else {
        popupContent += 'Title not available';
    }

	let cordenadas_1 = marker.geometry.coordinates[1]
	let cordenadas_2 = marker.geometry.coordinates[0]

   
    var customPopup = L.popup().setContent(popupContent);
	var marker = L.marker([cordenadas_1, cordenadas_2]).addTo(map);
    // Asignar el popup personalizado al marcador
    marker.bindPopup(customPopup);

	 // Configurar un evento de clic en el marcador para abrir el popup
	 marker.on('click', function () {
        marker.openPopup();
    });

    });
}





 function votos_si(reporte_json_si){

   
    var max = Math.max(...reporte_json_si.valor);
    var ctx = document.getElementById("chartBar1").getContext('2d');

        if(reporte_json_si.valor)
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: reporte_json_si.campo,
                datasets: [{
                    label: 'Votos',
                    data:reporte_json_si.valor,
                    borderWidth: 1,
                    backgroundColor: '#132d4b',
                    borderColor: '#2099d8',
                    borderWidth: 1.0,
                    pointBackgroundColor: '#0000',
    
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                legend: {
                    display: true
                },
                plugins: {
                    datalabels: {
                        display: true,
                        color: '#ffffff', // Cambia el color del texto según tu preferencia
                        anchor: 'end',
                        align: 'start',
                        offset: -10,
                        formatter: function(value, context) {
                            return value;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: max,
                            fontColor: "#9ba6b5",
                        },
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)'
                        }
                    }],
                    xAxes: [{
                        barPercentage: 0.4,
                        barValueSpacing: 0,
                        barDatasetSpacing: 0,
                        barRadius: 0,
                        ticks: {
                            display: true,
                            fontColor: "#9ba6b5",
                        },
                        gridLines: {
                            display: true,
                            color: 'rgba(119, 119, 142, 0.2)'
                        }
                    }]
                },
                legend: {
                    labels: {
                        fontColor: "#9ba6b5"
                    },
                },
                tooltips: {
                    enabled: true // Deshabilitar tooltips si solo quieres ver los valores sobre las barras
                }
                
            }
           
        });
    }



    votos_si(reporte_json_si);