<template>
    <div class="col s12 m12">
    <fieldset class="row">
                <legend>Tipo de estadistica</legend>
                <div class="container">
                <h5 style="text-align:center;">Estadisticas por Mes/Semana/Días</h5>
                <div class="col s12 m6 l6">
                    <label>Seleccione el filtro año/mes/día</label>
                    <select name="estadisticatipo" id="estadisticatipo" data-minimum-results-for-search="Infinity">
                        <option value="">Seleccione...</option>
                        <option value="ano">Año</option>
                        <option value="mes">Mes</option>
                        <option value="semana">Semana</option>
                        <option value="dia">Día</option>
                    </select>
                </div>
                <div class="col s12 m6 l6">
                    <label>Seleccione una opcion</label>
                    <select name="estadisticatipofiltro" id="estadisticatipofiltro"
                            data-minimum-results-for-search="Infinity">
                        <option value="">Seleccione...</option>
                        <option value="semana">Semana</option>
                        <option value="mes">Mes</option>
                        <option value="ano">Año</option>
                        <!-- <option value="precio">Precio</option> -->
                    </select>
                </div>
                </div>
                <div class="col s12 m12 l12" v-if="contador>0">
                    <div class="col s12 m6 l6" style="heigth:250px">
                        <h5 style="text-align:center;">Diagrama de barras</h5>
                        <chart-line :chart-data="datos.datos" :opciones="datos.opcion"></chart-line>
                    </div>
                    <div class="col s12 m6 l6">
                        <h5 style="text-align:center;">Diagrama de linea</h5>
                        <chart-bar :chart-data="datos.datos" :opciones="datos.opcion"></chart-bar>
                    </div>
                    <div class="col s12 m6 l6">
                        <chart-dou :chart-data="datos.datos" :opciones="datos.opcion"></chart-dou>
                     </div>
                     <div class="col s12 m6 l6">
                        <chart-pie :chart-data="datos.datos" :opciones="datos.opcion"></chart-pie>
                     </div>
                </div>
                <div v-else class="center badgecss">
                    <h5 ><strong class="blue white-text" style="border-radius:4px">No hay datos para mostrar en este momento!</strong></h5>
                </div>
            </fieldset>
            <div class="preloader-background" v-if="cargando">
                <label class="center light blue-text" style="position:fixed;">Buscando...</label><br>
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>
<script>
    import axios from 'axios'
    import {Line} from 'vue-chartjs'
    import chartline from './ChartLine.vue'
    import chartbar from './ChartBar.vue'
    import chartdou from './ChartDoughnut.vue'
    import chartpie from './ChartPie.vue'
    var esta;

    export default {
        components:{chartline,chartbar,chartdou,chartpie},
        data: () =>({
            datos:[{
                datos:{
                    labels: [],
                    datasets:[]
                },
                opcion:{
                    responsive: false, maintainAspectRatio: false
                }
            }],
            contador:0,
            datacollection: {},
            cargando:false,
            meses:[
                    {id:1,text:'ENERO'},
                    {id:2,text:'FEBRERO'},
                    {id:3,text:'MARZO'},
                    {id:4,text:'ABRIL'},
                    {id:5,text:'MAYO'},
                    {id:6,text:'JUNIO'},
                    {id:7,text:'JULIO'},
                    {id:8,text:'AGOSTO'},
                    {id:9,text:'SEPTIEMBRE'},
                    {id:10,text:'OCTUBRE'},
                    {id:11,text:'NOVIEMBRE'},
                    {id:12,text:'DICIEMBRE'}
                ],
            colores:['#2196f3','#f44336','#ffeb3b','#ff9800','#4caf50','#cddc39','#673ab7','#e91e63','#00bcd4','#9e9e9e','#ef9a9a','#ea80fc'],
            seleccionado:'',
        }),
        mounted (){
            //this.cargardatos();
            esta=this;
            $("#estadisticatipo,#estadisticatipofiltro").change(function () {
               var tipo = $("#estadisticatipo").val();
               var opcion = $("#estadisticatipofiltro").val();
               esta.seleccionado=$("#estadisticatipo").select2('data')[0].text;
               if(tipo!='' && tipo=="semana"){
                    //if(opcion!='' && opcion!=null){
                        esta.cargardatos(tipo,opcion);
                    //}else{
                        $("#estadisticatipofiltro").select2("data", esta.meses);
                        $("#estadisticatipofiltro").select2().empty();
                            $("#estadisticatipofiltro").select2({
                              data  : esta.meses,
                              theme: 'bootstrap',
                              placeholder: 'Seleccione...',
                              language: "es",
                              allowClear: false,
                              width: '100%'
                            })
                        //Materialize.toast('Debe seleccionar el mes');
                        //$('#estadisticatipofiltro').select2('open');
                    //}

               }if (tipo!="" && tipo=="mes"){
                    $("#estadisticatipofiltro").select2("data", esta.meses);
                    $("#estadisticatipofiltro").select2().empty();
                    $("#estadisticatipofiltro").select2({
                        data  : esta.meses,
                        theme: 'bootstrap',
                        placeholder: 'Seleccione...',
                        language: "es",
                        allowClear: false,
                        width: '100%'
                        })
                        esta.cargardatos(tipo,opcion);
               }
               else{
                esta.cargardatos(tipo,opcion);
               }

            });
        },
        methods: {
            cargardatos (tipo,opcion){
                this.cargando=true
                let uri = "/consultardatos?tipo=" + tipo + "&opcion=" + opcion;
                let Years = new Array();
                let Labels = new Array();
                let Prices = new Array();
                var color=new Array();
                axios.post(uri).then((response) => {
                      let data = response.data;
                      this.contador=data.length;
                      if(data) {
                      data.forEach(element => {
                            Years.push(element.label);
                            Labels.push(element.label);
                            Prices.push(element.total);
                            color.push(this.colores[Math.floor(Math.random() * esta.colores.length)]);
                      });
                      var dataset=[
                      {
                        label:esta.seleccionado,
                        backgroundColor: color,
                        data: Prices
                      }];

                      this.datos={
                              datos:{
                                labels: Labels,
                                datasets:dataset
                              },
                              opcion:{
                                responsive: false, maintainAspectRatio: false
                              }
                      };
                      this.cargando=false
                      } else {
                          Materialize.toast('No data',4000);
                      }
                });
            },
            fillData () {
                    this.datacollection = {
                      labels: [this.getRandomInt(), this.getRandomInt()],
                      datasets: [
                        {
                          label: 'Data One',
                          backgroundColor: '#f87979',
                          data: [this.getRandomInt(), this.getRandomInt()]
                        }, {
                          label: 'Data One',
                          backgroundColor: '#f87979',
                          data: [this.getRandomInt(), this.getRandomInt()]
                        }
                      ]
                    }
                  },
                  getRandomInt () {
                    return Math.floor(Math.random() * (50 - 5 + 1)) + 5
                  }
        }
    }
</script>