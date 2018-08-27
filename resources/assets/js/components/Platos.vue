<template>

<div class="row" id="sectionotherhome">
    <div v-for="da in datos.data" class="col col-12 col-md-4 col-xs-4" :id="da.id">
                                <div class="card">
                                    <div class="card-image">
                                        <img @click="verimagen(da.nombre,da.imagen)" class="materialboxed intense" height="150" :data-caption="da.nombre" width="250" :src="'/'+da.imagen">
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
                                        <a href="#!" @click="agregarplatosbebidas(da.id,da.nombre,'platos')" class="center new badge green white-text"><span style="font-size:19px" class="ion-ios-cart"></span></a>
                                        <a v-if="op==='bebidas'" href="#!" @click="agregarplatosbebidas(da.id,da.nombre,'bebidas')" class="center new badge green white-text"><span style="font-size:19px" class="ion-ios-cart"></span></a>
                                        </p>
                                    </div>
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
import App from './AppCliente'

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
    idbebidadplatos:[],
    buscar:'',
    comentario:'',
    operacion:'menu'
  }),

  mounted () {
    this.cargarmenucliente();
    this.listencliente();
  },
  methods: {
     verimagen (nombre,imagen){
        var p=$('#verimagenesplato');
        p.find('.titulo').html(nombre);
        p.find('.imagen').attr('src',imagen);
        $('.botonverimagenes').click();
     },
     listencliente (){
        App.methods.internet();
        window.Echo.private(`App.User.${window.Laravel.user.id}`)
                .notification(notification => {

                  Materialize.toast('Su pedido ya se encuentra listo',4000);
                  Push.create('Pedido terminado',
                  {body:'Su pedido ya se encuentra listo, gracias por utilizar nuestros servicios.',
                  link:'/pedidolisto',
                  icon:'/img/cocina.jpg',
                  vibrate:[5000, 500, 1000, 500]
                  });
                  /*if (window.navigator && window.navigator.vibrate) {
                      navigator.vibrate([5000, 500, 1000, 500]);
                  } else {
                        Materialize.toast('Tu navegador no soporta el metodo de vibración',4000);
                  }*/

                });
     },
    cargarmenucliente (page) {
    App.methods.internet();
          axios.post('/otherhome.listarmenuplatos?op=platos'+"&menu="+this.menuid+"&page="+page+"&buscar="+this.buscar)
            .then(({ data: { total, da }}) => {
              this.total = total
              this.datos =da;
          });
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
    agregarplatosbebidas(id,nombre,tipo) {

        if(tipo==='platos')
            idbebidadplatos.push({"plato":id,"nombre":nombre,"tipo":tipo,"bebida":0,"mesa":datoscliente.datos.mesa,"mesanombre":datoscliente.datos.mesanombre,"comentario":''});
        else
            idbebidadplatos.push({"plato":0,"nombre":nombre,"tipo":tipo,"bebida":id,"mesa":datoscliente.datos.mesa,"mesanombre":datoscliente.datos.mesanombre,"comentario":''});
            Materialize.toast("Se agrego correctamente.",2000);

        this.idbebidadplatos=idbebidadplatos;

    },
    obteneridmesa (id,nombre){
        this.mesa.push({"mesa":nombre,"mesaid":id});
        this.op='menu';this.operacion=this.op;
        this.cargarmenucliente();
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

  }
}
</script>