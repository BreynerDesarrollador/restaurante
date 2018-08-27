<template>
<div class="row" id="sectionotherhome">
    <div class="col s-12 m12 text-center">
        &nbsp;<a v-if="op!='mesas'" @click="atras()" class="btn-floating waves-effect waves-light green left"><i
                class="ion-ios-arrow-back"></i></a>
        <a v-if="op!='mesas'" @click="cargarbebidas()" class="
        btn-floating waves-effect waves-light orange center center-align"><i class="ion-wineglass"></i></a>
        <!-- <a v-if="idbebidadplatos.length>0" class="btn-floating waves-effect waves-light green right"><i
                    class="material-icons">chevron_right</i></a> -->
    </div>
    <div class="fixed-action-btn" v-if="idbebidadplatos.length>0">
        <a class="btn-floating btn-large waves-effect waves-light orange pulse" @click="solicitudcliente()"><i class="ion-ios-paperplane-outline"></i></a>
    </div>
    <!-- <div v-if="op==='platos' || idbebidadplatos.length>0" class="fixed-action-btn toolbar">
        <a class="btn-floating btn-large red">
            <i class="material-icons">menu</i>
        </a>
        <ul id="ulgestionar">
            <li class="waves-effect waves-light" v-if="idbebidadplatos.length>0" @click="guardarpedido(idbebidadplatos)"
            >
            <a href="#!"><i class="material-icons">save</i></a>
            </li>
            <li class="waves-effect waves-light" v-if="idbebidadplatos.length>0"
                onclick="javascript:$('.botonlistadeplatosseleccionados').click();">
                <a href="#!"><i class="material-icons">list</i></a>
            </li>
        </ul>
    </div> -->
    <div class="col s12 m12 l12" v-if="op=='platos' || op=='menu' || op==='bebidas'">
        <div class="col s12 m12">


                   <div class="input-group mb-2">
                           <label><span class="ion-ios-search-strong"></span>Buscar</label>
                           <input v-if="op==='platos' || op==='menu'" autofocus type="text" v-on:keyup="buscarplatos(menuid,buscar)"
                                              v-model="buscar" class="" id="buscarmenuplatos" name="buscarmenuplatos"
                                              placeholder="Digite el plato a buscar..."
                                              data-toggle="popover" data-trigger="" autofocus data-placement="top" title="Buscar"
                                              data-content="Digite el plato a buscar Ej: pizza, arroz oriental, etc...">
                                       <input v-if="op==='bebidas'" class="" type="text" v-on:keyup="buscarbebidas(menuid,buscar)" v-model="buscar"
                                              id="buscarmenuplatos" name="buscarmenuplatos" placeholder="Digite el plato a buscar..."
                                              data-toggle="popover" data-trigger="" data-placement="top" title="Buscar"
                                              data-content="Digite el plato a buscar Ej: pizza, arroz oriental, etc...">
                         </div>
        </div>
    </div>
    <div v-if="op==='menu'" v-for="da in datos" class="col s12 m6 l3" :id="da.id">
                            <div class="card">
                                <div class="card-image">
                                   <a href="#!" @click="cargarplatosmenu(da.id)">
                                        <img class="intense" height="150" width="100" :src="da.imagen">
                                   </a>

                                </div>
                                <div class="card-content">
                                <span class="card-title black-text">
                                <span v-bind:class="{ truncate: truncartexto20(da.nombre) }" :id="'menutexto'+da.id">{{ da.nombre }} </span>
                                <a v-if="da.nombre.length>15" class="leermastitulo" href="#!" :id="'menutextoleermas'+da.id" @click="quitartruncate('menutextoleermas','menutexto',da.id)"><small>leer más</small></a>
                                </span>
                                    <span v-bind:class="{ truncate: truncartexto38(da.descripcion) }" :id="'menutextodescripcion'+da.id">{{ da.descripcion }}</span>
                                    <a v-if="da.descripcion.length>38" class="leermastexto" href="#!" :id="'menutextodescripcionleermas'+da.id" @click="quitartruncate('menutextodescripcionleermas','menutextodescripcion',da.id)"><small>leer más</small></a>
                                </div>
                            </div>
                        </div>
    <div v-if="op=='platos' || op=='bebidas'" v-for="da in datos.data" class="col s12 m6 l3" :id="da.id">
                                <div class="card">
                                    <div class="card-image">
                                        <img @click="verimagen(da.nombre,da.imagen)" class="materialboxed intense" height="150" :data-caption="da.nombre" width="250" :src="da.imagen">
                                        <div v-if="validardescuento(da.desc_desde,da.desc_hasta) && da.descuento>0" class="inside">
                                            <div class="icon"><h5><strong>-{{ da.descuento }}%</strong></h5><small class="descuento">desc</small></div>
                                            <div class="contents">
    hola
                                            </div>
                                          </div>
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title black-text">
                                                                    <span v-bind:class="{ truncate: truncartexto20(da.nombre) }" :id="'platotexto'+da.id">{{ da.nombre }} </span>
                                                                    <a v-if="da.nombre.length>15" class="leermastitulo" href="#!" :id="'platotextoleermas'+da.id" @click="quitartruncate('platotextoleermas','platotexto',da.id)"><small>leer más</small></a>
                                                                    </span>
                                                                        <p v-bind:class="{ truncate: truncartexto38(da.descripcion) }" :id="'platotextodescripcion'+da.id">{{ da.descripcion }}</p>
                                                                        <a v-if="da.descripcion.length>38" class="leermastexto" :id="'platotextodescripcionleermas'+da.id" href="#!" @click="quitartruncate('platotextodescripcionleermas','platotextodescripcion',da.id)"><small>leer más</small></a>

                                        <p class="left new badge orange white-text"><strong>${{ da.precio }}</strong>
                                        <a v-if="op==='platos'" href="#!" @click="agregarplatosbebidas(da.id,da.nombre,'platos')" class="center new badge green white-text"><span style="font-size:19px" class="ion-ios-cart"></span></a>
                                        <a v-if="op==='bebidas'" href="#!" @click="agregarplatosbebidas(da.id,da.nombre,'bebidas')" class="center new badge green white-text"><span style="font-size:19px" class="ion-ios-cart"></span></a>
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
                    <label class="modal-title">Desea realizar el pedido?,
                    recuerde, una vez realizado el pedido sera enviado de inmediato a cocina,
                    si tiene alguna inquietud consultar con el mesero, gracias por utilizar nuestros servicios.</label>
                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li v-for="(datos, index) in idbebidadplatos"
                            class="list-group-item d-flex justify-content-between align-items-center">
                            {{ datos.nombre }} <a href="#!" class="VER" @click="
                            gestionarcomentario('#comentario'+index,index)">agregar comentario</a>
                            <a href="#!" @click="eliminarplatolista(index)"><span class="right red-text"><i
                                        class="ion-ios-trash-outline"></i></span></a>
                            <textarea v-on:keyup="agregarcomentario(index)" style="display:none"
                                      class="materialize-textarea VER" :id="'comentario'+index">

                                                    </textarea>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                <div class="col s6 m6 l6">
                <button class="btn-floating btn-large waves-effect waves-light orange pulse left loat-left" @click="guardarpedido(idbebidadplatos)"><i
                                            class="ion-ios-paperplane-outline"></i></button>
                </div>
                <div class="col s6 m6 l6">
                          <button type="button" class="btn-floating btn-large waves-effect waves-light red botonlistacancelar"
                                                      data-dismiss="modal"><i class="ion-android-cancel"></i>
                                              </button>
                                </div>


                </div>
            </div>
        </div>
    </div>
    <button style="display: none" class="btn light light-green right botonverimagenes"
                data-toggle="modal"
                data-target="#verimagenesplato"><span
                    class="glyphicon glyphicon-plus-sign"></span>Agregar plato
        </button>
        <div class="modal fade" id="verimagenesplato" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header center">
                    <span><b class="modal-title titulo"></b></span>

                        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="" width="100%" height="100%" class="imagen">
                    </div>
                    <div class="modal-footer center-block center">
                        <button type="button" class="btn btn-secondary light light-green botonlistacancelar center"
                                data-dismiss="modal"><i
                                    class="ion-ios-close-outline"></i>Cerrar
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
    props:['datoscliente','datosmenus1'],
  data: () => ({
    total: 0,
    page:1,
    resource_url: '/otherhome',
    datos:{},
    datosplatos:{},
    op:"menu",
    menuid:0,
    mesa:[],
    buscar:'',
    comentario:'',
    idbebidadplatos:[],
    operacion:'menu'
  }),

  mounted () {
    //asignamos los valores que llegan por url.
    this.op=this.operacion;
    //this.menuid=this.$route.query.menuid!=undefined?this.$route.query.menuid:'';
    mostrarcargando();
    this.cargarmenucliente();
    this.listencliente();

    navigator.serviceWorker.register('sw1.js');
    Notification.requestPermission(function(result) {
      if (result === 'granted') {
        navigator.serviceWorker.ready.then(function(registration) {
          registration.showNotification('Restaurante.com');
        });
      }
    });

    Push.Permission.request(Push.Permission.GRANTED, Push.Permission.DENIED);

  },
  methods: {
    /**
     * Fetch notifications.
     *
     * @param {Number} limit
     */
     verimagen (nombre,imagen){
        var p=$('#verimagenesplato');
        p.find('.titulo').html(nombre);
        p.find('.imagen').attr('src',imagen);
        $('.botonverimagenes').click();
     },
     internet (){
        // Sólo hacer el fetch si navigator.onLine es true
        if(navigator.onLine){
            //alert('Online');
        } else {
            Materialize.toast('No hay conexión a internet.',2000);
        }
     },
     listencliente (){
        this.internet();
        window.Echo.private(`App.User.${window.Laravel.user.id}`)
                .notification(notification => {

                  Materialize.toast('Su pedido ya se encuentra listo',2000);
                  Push.create('Pedido terminado',
                  {body:'Su pedido ya se encuentra listo, gracias por utilizar nuestros servicios.',
                  link:'/pedidolisto',
                  icon:'/img/cocina.jpg',
                  vibrate:[1000, 500, 5000, 500]
                  });
                  /*if (window.navigator && window.navigator.vibrate) {
                      navigator.vibrate([5000, 500, 1000, 500]);
                  } else {
                        Materialize.toast('Tu navegador no soporta el metodo de vibración',2000);
                  }*/

                });
     },
    cargarmenucliente (page) {
    this.internet();
    if(this.op=='menu'){
        this.datos=this.datosmenus1;
    }else{
        if (typeof page === 'undefined') {
          page = 1;
        }
          axios.post('/otherhome.listarmenuplatos?op='+this.op+"&menu="+this.menuid+"&page="+page+"&buscar="+this.buscar)
            .then(({ data: { total, da }}) => {
              ocultarcargando();
              this.total = total
              this.datos =da;
          });
      }
    },
    buscarplatos(id,buscar) {
            //mostrarcargando();
            this.op="platos";this.operacion=this.op;
            this.menuid=id;
            this.buscar=buscar
            this.cargarmenucliente()
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
        this.cargarmenucliente()
    },
    cargarmenuatras (page) {
       this.op='menu'
       this.cargarmenucliente()
    },
    cargarbebidas (){
        this.op="bebidas";this.operacion=this.op;
        this.cargarmenucliente();
    },
    guardarpedido (dato){
        this.internet();
        if(dato.length>0){
        $(".botonlistacancelar").click();
        mostrarcargando();
        axios.post('/cliente/guardarpedido?operacion=cliente',{ datos:dato })
            .then(({data:{respuesta}}) => {
                Materialize.toast("El pedido se ha registrado con exito.",2000);
                this.idbebidadplatos=[];
                this.op="menu";this.operacion=this.op;
                this.menuid=0;
                this.platoid=0;
                this.mesa=[];
                ocultarcargando();
                this.cargarmenucliente();
            }).catch(function (error) {
                  Materialize.toast(error,2000);
                });
        }else
            Materialize.toast('No hay platos seleccionados',2000);
        ocultarcargando();
    },
    agregarplatosbebidas(id,nombre,tipo) {

        if(tipo==='platos')
            this.idbebidadplatos.push({"plato":id,"nombre":nombre,"tipo":tipo,"bebida":0,"mesa":this.datoscliente.mesa,"mesanombre":this.datoscliente.mesanombre,"comentario":''});
        else
            this.idbebidadplatos.push({"plato":0,"nombre":nombre,"tipo":tipo,"bebida":id,"mesa":this.datoscliente.mesa,"mesanombre":this.datoscliente.mesanombre,"comentario":''});
            Materialize.toast("Se agrego correctamente.",2000);

    },
    obteneridmesa (id,nombre){
        this.mesa.push({"mesa":nombre,"mesaid":id});
        this.op='menu';this.operacion=this.op;
        this.cargarmenucliente();
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
        if(this.op=='menu'){
            this.cargarmenucliente();
        }if(this.op=='platos'){
            this.op='menu';
            this.cargarmenucliente();
        }
        if(this.op==='bebidas'){
            this.op='platos';
            this.cargarmenucliente();
        }
    },
    solicitudcliente (){
        $('.botonlistadeplatosseleccionados').click();
    }
  }
}
</script>