<template>
<div class="row" id="sectionotherhome">
        <div>
            <pulse-loader class="preloader-background" :loading="loading" :color="'#017A95'"></pulse-loader>
        </div>
        <ul v-if="op!='mesas'" id="main_nav" class="col s12 m12 l12 center z-depth-2"
            style="background-color:white;position:absolute;display:none">
            <li class="col s3 m3 l3 font30"><a v-if="op!='mesas'" @click="atras()" class=" waves-effect waves-light left
                "><strong><i class="ion-ios-arrow-left"></i></strong></a></li>
            <li class="col s3 m3 l3 font30"><a v-if="op!='mesas'" @click="cargarbebidas()" class="
                 waves-effect waves-light"><strong><i class="ion-wineglass"></i></strong></a></li>
            <li class="col s3 m3 l3 font30"><a data-toggle="modal" data-target="#listadopedidos" @click="listarpedidos" v-if="op!='mesas'" class=" waves-effect waves-light"><strong><i
                                class="ion-ios-list-outline"></i></strong></a></li>
            <li class="col s3 m3 l3 font30"><a v-if="op!='mesas'" @click="cargarmesas" class="
                 waves-effect waves-light right"><strong><i class="ion-ios-home-outline"></i></strong></a></li>
        </ul>

        <div v-if="idbebidadplatos.length>0" class="fixed-action-btn toolbar">
            <a class="btn-floating btn-large red">
                <i class="material-icons">menu</i>
            </a>
            <ul id="ulgestionar">
                <li class="waves-effect waves-light" v-if="idbebidadplatos.length>0" @click="
                guardarpedido(idbebidadplatos)">
                <a href="#!"><i class="material-icons">save</i></a>
                </li>
                <li class="waves-effect waves-light" v-if="idbebidadplatos.length>0"
                    onclick="javascript:$('.botonlistadeplatosseleccionados').click();">
                    <a href="#!"><i class="material-icons">list</i></a>
                </li>
            </ul>
        </div>
        <div class="col s12 m12 l12" v-if="op=='platos' || op=='menu' || op==='bebidas'">
            <div class="col s12 m6 l6">
                <input v-if="op==='platos' || op==='menu'" type="text" v-on:keyup="buscarplatos(menuid,buscar)"
                       v-model="buscar" id="buscarmenuplatos" name="buscarmenuplatos"
                       placeholder="Digite el plato a buscar..."
                       data-toggle="popover" data-trigger="" data-placement="top" title="Buscar"
                       data-content="Digite el plato a buscar Ej: pizza, arroz oriental, etc...">
                <input v-if="op==='bebidas'" type="text" v-on:keyup="buscarbebidas(menuid,buscar)" v-model="buscar"
                       id="buscarmenuplatos" name="buscarmenuplatos" placeholder="Digite el plato a buscar..."
                       data-toggle="popover" data-trigger="" data-placement="top" title="Buscar"
                       data-content="Digite el plato a buscar Ej: pizza, arroz oriental, etc...">
            </div>
        </div>
        <a v-if="op=='mesas'" v-for="da in datosmesas" href="#!" @click="obteneridmesa(da.id,da.nombre)" class="
        col s12 m6 l3 mesas" :id="'mesa'+da.id">
        <div class="card">
            <div class="card-image">
                <img height="150" width="100" src="/img/mesa.jpg">
            </div>
            <div class="card-content">
                <span class="card-title black-text trucate">{{ da.nombre }}</span>
                <small class="truncate black-text">{{ da.descripcion }}</small>
            </div>
        </div>
        </a>

        <div v-if="op==='menu'" v-for="da in datos" class="col s12 m6 l3" :id="da.id">
            <div class="card">
                <div class="card-image">
                    <a href="#!" @click="cargarplatosmenu(da.id)"> <img height="150" width="100" :src="da.imagen"> </a>

                </div>
                <div class="card-content">
                            <span class="card-title black-text">
                            <span v-bind:class="{ truncate: truncartexto20(da.nombre) }"
                                  :id="'menutexto'+da.id">{{ da.nombre }} </span>
                            <a v-if="da.nombre.length>15" class="leermastitulo" href="#!"
                               :id="'menutextoleermas'+da.id" @click="quitartruncate('menutextoleermas','menutexto',da.id)"><small>leer más</small>
                                </a>
                            </span>
                    <span v-bind:class="{ truncate: truncartexto38(da.descripcion) }"
                          :id="'menutextodescripcion'+da.id">{{ da.descripcion }}</span>
                    <a v-if="da.descripcion.length>38" class="leermastexto" href="#!"
                       :id="'menutextodescripcionleermas'+da.id" @click="
                    quitartruncate('menutextodescripcionleermas','menutextodescripcion',da.id)">
                    <small>leer más</small>
                    </a>
                </div>
            </div>
        </div>
        <div v-if="op=='platos' || op=='bebidas'" v-for="da in datos.data" class="col s12 m6 l3" :id="da.id">
            <div class="card">
                <div class="card-image">
                    <img class="materialboxed" height="150" :data-caption="da.nombre" width="250" :src="da.imagen">
                    <div v-if="validardescuento(da.desc_desde,da.desc_hasta) && da.descuento>0" class="inside">
                        <div class="icon"><h5><strong>-{{ da.descuento }}%</strong></h5>
                            <small class="descuento">desc</small>
                        </div>
                        <div class="contents">
                            hola
                        </div>
                    </div>
                </div>
                <div class="card-content">
                                    <span class="card-title black-text">
                                                                <span v-bind:class="{ truncate: truncartexto20(da.nombre) }"
                                                                      :id="'platotexto'+da.id">{{ da.nombre }} </span>
                                                                <a v-if="da.nombre.length>15" class="leermastitulo"
                                                                   href="#!" :id="'platotextoleermas'+da.id" @click="quitartruncate('platotextoleermas','platotexto',da.id)"><small>leer más</small>
                                        </a>
                                                                </span>
                    <p v-bind:class="{ truncate: truncartexto38(da.descripcion) }"
                       :id="'platotextodescripcion'+da.id">{{ da.descripcion }}</p>
                    <a v-if="da.descripcion.length>38" class="leermastexto" :id="'platotextodescripcionleermas'+da.id"
                       href="#!" @click="quitartruncate('platotextodescripcionleermas','platotextodescripcion',da.id)">
                    <small>leer más</small>
                    </a>

                    <p class="left new badge orange white-text"><strong>${{ da.precio }}</strong>
                        <a v-if="op==='platos'" href="#!" @click="agregarplatosbebidas(da.id,da.nombre,'platos')" class=
                        "center new badge green white-text"><i class="material-icons">add_shopping_cart</i></a>
                        <a v-if="op==='bebidas'" href="#!" @click="agregarplatosbebidas(da.id,da.nombre,'bebidas')"
                        class="center new badge green white-text"><i class="material-icons">add_shopping_cart</i></a>
                    </p>
                </div>
            </div>
        </div>
        <button style="display: none" class="btn light light-green right botonlistadeplatosseleccionados"
                data-toggle="modal"
                data-target="#listadeplatosseleccionados"><span
                    class="glyphicon glyphicon-plus-sign"></span>Agregar plato
        </button>
        <div class="modal fade" id="listadeplatosseleccionados" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header center">
                        <label class="modal-title font30">Lista de platos</label>
                        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5 class="center"><span>{{idbebidadplatos.length>0?idbebidadplatos[0].mesanombre:''}}</span></h5>
                        <ul class="list-group">
                            <li v-for="(datos, index) in idbebidadplatos"
                                class="list-group-item d-flex justify-content-between align-items-center">
                                {{ datos.nombre }} <a href="#!" class="VER" @click="
                                gestionarcomentario('#comentario'+index,index)">agregar comentario</a>
                                <a href="#!" @click="eliminarplatolista(index)"><span class="right red-text"><i
                                            class="material-icons">delete</i></span></a>
                                <textarea v-on:keyup="agregarcomentario(index)" style="display:none"
                                          class="materialize-textarea VER" :id="'comentario'+index">

                                                    </textarea>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button class="btn linght light-blue left" @click="guardarpedido(idbebidadplatos)"><i
                                class="material-icons">save</i>Guardar</button>
                        <button type="button" class="btn btn-secondary light light-green botonlistacancelar"
                                data-dismiss="modal"><span
                                    class="glyphicon glyphicon-eye-close"></span> Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="listadopedidos" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header center">
                        <label class="modal-title font30">Lista de pedidos</label>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <pulse-loader class="preloader-background" :loading="loadingpedidos" :color="'#017A95'"></pulse-loader>
                        <div v-for="(dato,index) in listapedidos">
                            <h5>{{dato.mesanombre}}</h5>
                            <ul class="collection">
                               <li class="collection-item avatar"  v-for="(dato1,index) in dato.datos">
                                    <img :src="dato1.imagen" alt="" class="circle">
                                    <span class="title">{{dato1.plato!='' && dato1.plato!=null ? dato1.plato:dato.bebida}}</span>
                                    <p classs="badge green">{{dato1.comentario}}</p>
                                    <small class="timestamp">
                                       <timeago :since="dato1.fecha" :auto-update="30"></timeago>
                                    </small>
                                    <a href="#!" class="secondary-content badge green white-text"><i class="ion-social-usd-outline"></i>{{dato1.precio}}</a>
                               </li>
                            </ul>
                        </div>

                    </div>
                    <div class="modal-footer center">
                        <button type="button" class="btn btn-secondary light light-green botonlistacancelar"
                                data-dismiss="modal"><span
                                    class="ion-ios-close-outline"></span>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import $ from 'jquery'
import axios from 'axios'
import Push from 'push.js'

export default {
    props:['datosmenus1','datosmesas1'],
  data: () => ({
    total: 0,
    page:1,
    resource_url: '/otherhome',
    datos:{},
    datosplatos:{},
    datosmesas:{},
    op:"mesas",
    menuid:0,
    mesa:[],
    buscar:'',
    comentario:'',
    idbebidadplatos:[],
    loading:false,
    loadingpedidos:false,
    listapedidos:{}
  }),

  mounted () {
    //asignamos los valores que llegan por url.
    this.op=this.operacion;
    //this.menuid=this.$route.query.menuid!=undefined?this.$route.query.menuid:'';
    mostrarcargando();
    this.cargarmesas();
    this.listenmesero();
    var $win = $(window);
      // definir mediente $pos la altura en píxeles desde el borde superior de la ventana del navegador y el elemento
      var $pos = 53;
      $win.scroll(function () {
      var top=$win.scrollTop();
         if (top >= $pos)
           $('#main_nav').addClass('navbar-fixed');
         else {
           $('#main_nav').removeClass('navbar-fixed');
         }
         if(top==0){
            $('#main_nav').fadeOut('slow');
         }else{
            $('#main_nav').fadeIn('slow');
         }
    });
  },
  methods: {
    /**
     * Fetch notifications.
     *
     * @param {Number} limit
     */

     listenmesero (){
             /*window.Echo.private(`App.User.${window.Laravel.user.id}`)
                     .notification(notification => {
                       Push.create(notification.titulo,
                       {body:notification.mensaje,
                       link:'https://restaurante.willitad.com',
                       icon:'/img/cocina.jpg',
                       vibrate:[1000, 500, 500, 500]
                       });*/
                       /*if (window.navigator && window.navigator.vibrate) {
                           navigator.vibrate([5000, 500, 1000, 500]);
                       } else {
                             Materialize.toast('Tu navegador no soporta el metodo de vibración',1000);
                       }*/

                     //});
          },
    cargarmesas () {
        //mostrarcargando();
      //axios.post('/otherhome.listarmenuplatos?op=mesas')
          //.then(({ data: { total, da }}) => {
          this.datosmesas=this.datosmesas1;
            this.op='mesas';this.operacion=this.op;
            //ocultarcargando();
            //this.total = total
            //this.datosmesas =da
          //})
     },
    cargarmenu (page) {
        this.loading=true;
        if(this.op=='mesas' || this.op=='menu'){
            ocultarcargando();
            this.datos=this.datosmenus1;
            this.loading=false;
        }else{
            if (typeof page === 'undefined') {
              page = 1;
            }
            axios.post('/otherhome.listarmenuplatos?op='+this.op+"&menu="+this.menuid+"&page="+page+"&buscar="+this.buscar)
              .then(({ data: { total, da }}) => {
                  this.total = total
                  this.datos =da;
                  this.loading=false;
              })
        }
    },
    buscarplatos(id,buscar) {
            //mostrarcargando();
            this.op="platos";this.operacion=this.op;
            this.menuid=id;
            this.buscar=buscar
            this.cargarmenu()
    },
    buscarbebidas(id,buscar) {
       //mostrarcargando();
       this.op="bebidas";this.operacion=this.op;
       this.menuid=id;
       this.buscar=buscar
       this.cargarmenu()
    },
    cargarplatosmenu (id){
        this.op="platos";this.operacion=this.op;
        this.menuid=id;
        this.cargarmenu();
    },
    cargarmenuatras (page) {
       this.op='menu'
       this.cargarmenu()
    },
    cargarbebidas (){
        this.op="bebidas";this.operacion=this.op;
        this.cargarmenu();
    },
    guardarpedido (dato){
        if(dato.length>0){
        this.loading=true;
        axios.post('/otherhome.guardarpedido?operacion=mesero',{ datos:dato })
            .then(({data:{respuesta}}) => {
                Materialize.toast("El pedido se ha registrado con exito.",1000);
                this.idbebidadplatos=[];
                this.op="mesa";this.operacion=this.op;
                this.menuid=0;
                this.platoid=0;
                this.mesa=[];
                $(".botonlistacancelar").click();
                this.loading=false;
                this.cargarmesas();
            }).catch(function (error) {
                  Materialize.toast(error,1000);
                  this.loading=false;
                });
        }else
            Materialize.toast('No hay platos seleccionados',1000);
    },
    agregarplatosbebidas(id,nombre,tipo) {
        if(tipo==='platos')
            this.idbebidadplatos.push({"plato":id,"nombre":nombre,"tipo":tipo,"bebida":0,"mesa":this.mesa[0].mesaid,"mesanombre":this.mesa[0].mesa,"comentario":''});
        else
            this.idbebidadplatos.push({"plato":0,"nombre":nombre,"tipo":tipo,"bebida":id,"mesa":this.mesa[0].mesaid,"mesanombre":this.mesa[0].mesa,"comentario":''});
            Materialize.toast("Se agrego correctamente.",1000);
    },
    obteneridmesa (id,nombre){
        this.mesa.push({"mesa":nombre,"mesaid":id});
        this.op='menu';this.operacion=this.op;
        this.cargarmenu();
    },
    eliminarplatolista (index) {
        this.idbebidadplatos.splice(index, 1);
    },
    agregarcomentario (index) {
      var valor=$("#comentario"+index).val();
      this.idbebidadplatos[index].comentario=valor;
    },
    /*mostrarcargando (){
      $('#cargando').fadeIn('slow');
      $('#cuerpocargando').fadeIn('slow');
     },
    ocultarcargando (){
      $('#cargando').fadeOut('slow');
      $('#cuerpocargando').fadeOut('slow');
    },*/
    validardescuento (fechadesde,fechahasta){
    var hoy=new Date();
    hoy.setHours(0,0,0,0);
    var fecha=hoy.getTime();
    var dia=hoy.getDate();
        var mes=hoy.getMonth()+1;
        var ano=hoy.getFullYear();
    var fechades1;
    var fechades=0;
    if(isNaN(fechadesde)){
       fechades1=new Date(Date.parse(fechadesde));
       fechades1.setHours(0,0,0,0);
       fechades=fechades1.getTime();
    }
    var fechahas1;var fechahas=0;
    if(isNaN(fechahasta)){
       fechahas1=new Date(Date.parse(fechahasta));
       fechahas1.setHours(0,0,0,0);
       fechahas=fechahas1.getTime();
    }

       if(fechades>=fecha){
        if(fechahas>=fecha){
                return true
               }
       }
    },
    truncartexto20 (texto){
        return texto.length>15
    },
    truncartexto38 (texto){
            return texto.length>32
        },
    quitartruncate (etiqueta1,etiqueta2,id){
       var principal=$("#"+etiqueta1+id);
       var principal1=$("#"+etiqueta2+id);
       if(principal.hasClass('MO')){
            principal.addClass('OC');
            principal.removeClass('MO');
            principal.html('<small>leer más</small>');
            principal1.addClass('truncate');
       }else{
            principal.removeClass('OC');
            principal.addClass('MO');
            principal.html('<small>leer menos</small>');
            principal1.removeClass('truncate');
       }
    },
    gestionarcomentario (etiqueta,comentario){
        var eti=$(etiqueta);
        if(eti.hasClass('VER')){
            $("#comentario"+comentario).show();
            eti.removeClass('VER');
            eti.addClass('OC');
        }else{
            $("#comentario"+comentario).hide();
            eti.removeClass('OC');
            eti.addClass('VER');
        }
    },
    atras (){
        if(this.op=='mesas'){
            this.cargarmesas();
        }if(this.op=='menu'){
            this.cargarmesas();
        }if(this.op=='platos'){
            this.op='menu';
            this.cargarmenu();
        }
        if(this.op==='bebidas'){
            this.op='platos';
            this.cargarmenu();
        }
    },
    listarpedidos (){
        this.loadingpedidos=true;
        axios.post('/otherhome.listapedidos')
            .then(({data:{datos}}) =>{
                var pedido=[];
                $.each(datos,function(index,value){
                    var posicion;
                    if(pedido.length>0){
                        for(var i=0;i<pedido.length;i++){
                            if(pedido[i].mesaid==value.mesaid){
                                posicion=i;
                                break;
                            }
                        }
                        if(posicion>=0){
                            pedido[posicion].datos.push(value);
                        }else{
                            var cont=pedido.length;
                            pedido.push({mesanombre:value.mesanombre,mesaid:value.mesaid,datos:[]});
                            pedido[cont].datos.push(value);
                        }
                    }else{
                        pedido.push({mesanombre:value.mesanombre,mesaid:value.mesaid,datos:[]});
                        pedido[0].datos.push(value);
                    }
                });
            this.listapedidos=pedido;
            this.loadingpedidos=false;
            }).catch(function (error){
                Materialize.toast("Error::..."+error,1000);
                this.loadingpedidos=false;
            });
    },
  }
}
</script>
<style scope>
    .font30{
        font-size:30px;
    }
    .navbar-fixed{
        position:fixed!important;
        top:0;
        height:40px;
    }
    .ocultar{
        display:none;
    }
    .mostrar{
        display:block;
    }
</style>