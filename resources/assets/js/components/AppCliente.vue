<template>

    <div>
    <div class="fixed-action-btn" v-if="platos.length>0">
            <a class="btn-floating btn-large waves-effect waves-light orange pulse" @click="solicitudcliente()"><i class="ion-ios-paperplane-outline"></i></a>
        </div>
        <button @click="platosmetodo">Platos</button>
    <loading-bar
                :on-error-done="errorDone"
                :on-progress-done="progressDone"
                :progress="progress"
                :direction="direction"
                :error="error" >
        </loading-bar>
        <p>
        <div class="btn-group" role="group" aria-label="Basic example">
          <router-link :to="{ name: 'menu' }" class="btn light light-blue">Menú</router-link>
          <router-link :to="{ name: 'platos' }" class="btn light light-blue">Platos</router-link>
        </div>
        </p>

        <div class="container">
            <router-view></router-view>
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
                            <li v-for="(datos, index) in platos"
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
                            <button class="btn-floating btn-large waves-effect waves-light orange pulse left loat-left" @click="guardarpedido(this.idbebidadplatos)"><i
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
    </div>
</template>
<script>
import Push from 'push.js'
    export default {
    data: () =>({
                progress: 0,
                error: false,
                direction: 'right',
                platos:idbebidadplatos
        }),
    mounted () {
    navigator.serviceWorker.register('/sw1.js');
        Notification.requestPermission(function(result) {
          if (result === 'granted') {
            navigator.serviceWorker.ready.then(function(registration) {
              registration.showNotification('Restaurante.com');
            });
          }
        });

       // Push.Permission.request(Push.Permission.GRANTED, Push.Permission.DENIED);
       var me = this;
               me.progress = 10;
               for (var i = 0; i < 30; i++) {
                   if(i > 20 && i < 29){
                       setTimeout(function () {
                           me.progress += 5;
                       },50*i);
                   }else{
                       setTimeout(function () {
                           me.progress ++;
                       },10*i);
                   }
               }
               setTimeout(function () {
                   me.progress = 100;
               },1500);

   },
   methods: {
   platosmetodo (){
    this.$router.push('/cliente/app/platos');
   },
    listencliente (){
            window.Echo.private(`App.User.${window.Laravel.user.id}`)
                    .notification(notification => {
                      Materialize.toast('Su pedido ya se encuentra listo',4000);
                      Push.create('Pedido terminado',
                      {body:'Su pedido ya se encuentra listo, gracias por utilizar nuestros servicios.',
                      link:'/pedidolisto',
                      icon:'/img/cocina.jpg',
                      vibrate:[5000, 500, 1000, 500]
                      });

                    });
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
                 internet (){
                         // Sólo hacer el fetch si navigator.onLine es true
                         if(navigator.onLine){
                             //alert('Online');
                         } else {
                             Materialize.toast('No hay conexión a internet.',4000);
                         }
                      },
                      progressTo: function (val) {
                                  this.progress = val;
                              },
                              setToError: function (bol) {
                                  this.error = bol;
                              },
                              changeDirection: function (direction) {
                                  if(this.progress >= 0){
                                      this.progress = 100;
                                  }
                                  this.direction = this.direction === 'right' ? 'left' : 'right';
                              },
                              // Callback
                              errorDone(){
                                  this.error = false
                              },
                              progressDone() {
                                  this.progress = 0
                              },
                              solicitudcliente (){
                                      $('.botonlistadeplatosseleccionados').click();
                                  },
                                  eliminarplatolista (index) {
                                          idbebidadplatos.splice(index, 1);
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
                                          agregarcomentario (index) {
                                                var valor=$("#comentario"+index).val();
                                                idbebidadplatos[index].comentario=valor;
                                              },
                                              guardarpedido (dato){
                                                      this.internet();
                                                      if(dato.length>0){
                                                      $(".botonlistacancelar").click();
                                                      mostrarcargando();
                                                      axios.post('/cliente/guardarpedido?operacion=cliente',{ datos:dato })
                                                          .then(({data:{respuesta}}) => {
                                                              Materialize.toast("El pedido se ha registrado con exito.",4000);
                                                              idbebidadplatos=[];
                                                              location.href="/cliente/app/menu";
                                                          }).catch(function (error) {
                                                                Materialize.toast(error,4000);
                                                              });
                                                      }else
                                                          Materialize.toast('No hay platos seleccionados',4000);
                                                      ocultarcargando();
                                                  },
   }
   }
</script>