<template>
    <div style="background-image:url('/img/cocina.jpg')">

        <div class="container white">
        <div class="center">
            <strong class="center"><label>Total pedidos:</label>   <span class="btn-floating red pulse">{{ this.total }}</span></strong>
        </div>
        <fieldset>
            <legend>Lista de platos</legend>
            <div v-for="pla in platos" class="col s12 m12 l12">
              <p><span class="col s9 m9 l9">{{ pla.plato }}</span><span class="badge green white-text col s3 m3 l3 left">{{ pla.valor }}</span></p>
            </div>
        </fieldset>
        <br>
            <fieldset class="fieldsetmesas">
                <legend>Lista de mesas</legend>
            <a href="#!" v-for="(da,i) in datos" :id="'amesas'+da.mesaid" class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ da.mesa }}  <small class="text-muted"><timeago :since="da.fecha" :auto-update="60" :format="formatTime"></timeago></small>

                  <span class="right">
                    <input type="checkbox" class="right" @click="seleccionartodos(da.mesaid)" name="seleccionar" :id="'mesa'+da.mesaid"><label :for="'mesa'+da.mesaid"></label>
                  </span>
                  </h5>
                  <hr>
                </div>
                <div id="divmesas">
                <div v-for="(da1,index) in da.datos" :id="'mesa'+da.mesaid">
                    <p v-if="da1.plato!=null && da1.plato!=''" class="mb-1">
                      <img class="circle" :src="da1.imagenplato" width="50" height="50">{{ da1.plato }}
                      <span class="right">
                        <input type="checkbox" class="right seleccionplato" @click="seleccionplato('#plato'+da.mesaid+index)" :value="da.mesaid+'$$'+da.mesa+'$$'+da.mesero+'$$'+da1.plato+'$$'+da1.bebida+'$$'+da1.id+'$$'+da.cliente" name="seleccionar" :id="'plato'+da.mesaid+index"><label :for="'plato'+da.mesaid+index"></label>
                      </span>
                    </p>
                    <p v-if="da1.bebida!=null && da1.bebida!=''" class="mb-1">
                      <img class="circle" :src="da1.imagenbebida" width="50" height="50">{{ da1.bebida }}<span class="right">
                      <input type="checkbox" class="right seleccionplato" @click="seleccionplato('#plato'+da.mesaid+index)" :value="da.mesaid+'$$'+da.mesa+'$$'+da.mesero+'$$'+da1.plato+'$$'+da1.bebida+'$$'+da1.id+'$$'+da.cliente" name="seleccionar" :id="'bebida'+da.mesaid+index"><label :for="'bebida'+da.mesaid+index"></label>
                      </span></p>
                    <small v-if="da1.comentario!=null && da1.comentario!=''" class="badge text-muted red white-text">Comentario: {{ da1.comentario }}</small>
                </div>
                </div>
              </a>
           </fieldset>

        </div>
        <div class="fixed-action-btn">
         <a class="btn-floating btn-large waves-effect waves-light red pulse" @click="guardarpedidococina()"><i class="material-icons">save</i></a>
         </div>
    </div>
</template>

<script>
import $ from 'jquery'
import axios from 'axios'
import VueTimeago from 'vue-timeago'

export default {
      data: () => ({
        total: 0,
        page:1,
        resource_url: '/otherhome',
        datos:[],
        user:{},
        idpedidos:[],
        platos:[],
      }),

      mounted () {
            this.user=window.Laravel.user;
            this.cargarpedido();
            this.listenCocina();
            //$(".timeago").timeago();
      },
      methods: {
        cargarpedido (){
            axios.post('/otherhome.listarpedidos')
              .then(({ data: { total, datoscocina }}) => {
                this.total = total
                //this.datos =datoscocina
                var cocina=[],platos=[];
                $.each(datoscocina,function(index,value){
                    var validar;
                    for(var i=0;i<cocina.length;i++){
                        if(cocina[i].mesaid==value.mesaid){
                            validar=i;
                            break;
                        }
                    }
                    if(validar>=0){
                       cocina[validar].datos.push({"id":value.id,"plato":value.plato,"bebida":value.bebida,"fecha":value.fecha,"comentario":value.comentario,"imagenplato":value.imagenplato,"imagenbebida":value.imagenbebida});
                    }else{
                        var ultima=cocina.length;
                        cocina.push({"id":value.id,"mesa":value.mesa,"mesaid":value.mesaid,"mesero":value.mesero,"datos":[],"fecha":value.fecha,'cliente':value.cliente});
                        cocina[ultima].datos.push({"id":value.id,"plato":value.plato,"bebida":value.bebida,"fecha":value.fecha,"comentario":value.comentario,"imagenplato":value.imagenplato,"imagenbebida":value.imagenbebida});
                    }
                    var validar1;
                    if(platos.length>0){
                    for(var i=0;i<platos.length;i++){

                            if(platos[i].plato==value.plato){
                            validar1=i;
                            break;

                       }
                    }
                    if(validar1>=-1){
                     platos[validar1].valor=(platos[validar1].valor+1);
                                           }else{
                                           if(value.plato!='' && value.plato!=null){
                                             platos.push({'plato':value.plato,'valor':1});
                                             }
                                           }
                    }else{
                    if(value.plato!='' && value.plato!=null){
                       platos.push({'plato':value.plato,'valor':1});
                       }
                    }

                });
                this.platos=platos;
                this.datos=cocina;
              });
        },
        validarexisteplato (){
            var validar;
                                for(var i=0;i<this.platos.length;i++){
                                    if(cocina[i].mesa==value.mesa){
                                        validar=i;
                                        break;
                                    }
                                }
                                return validar;
        },
        orderedUsers: function () {
            return _.orderBy(this.datos, 'mesa')
        },
        listenCocina () {
          window.Echo.private(`App.User.${window.Laravel.user.id}`)
          .notification(notification => {
              this.cargarpedido();
         })
         },
         formatTime (time) {
           const d = new Date(time)
           return d.toLocaleString()
         },
         seleccionarpedidococina (index,mesa,nombremesa,mesero){
         var existe;
         var pedido=this.idpedidos;
         $.each(this.idpedidos,function(index,value){
            if(pedido[index].mesaid==mesa){
                existe=index;
                return true;
            }
         });
         if(existe>=0){
            this.idpedidos.splice(index);
         }else{
            /*$.each(this.idpedidos,function(index,value){
                        if(pedido[index].mesa==mesa){
                            existe=index;
                            return true;
                        }
                     });
            if(existe>=0){
              this.idpedidos[existe].datos.push({"nombres":nombre});
            }else{*/
            var datos=[];
            //datos.push({"mesa":mesa});
               this.idpedidos.push({"mesaid":mesa,"mesero":mesero,"mesa":nombremesa});
               datos=[];
            //}
         }
         },
         guardarpedidococina (){
            mostrarcargando();
            var datospedido=[];
            $(".fieldsetmesas").find('.seleccionplato').each(function(index,elemento){
                var etiqueta=$(elemento);
                if(etiqueta.is(":checked")){
                    var datos=etiqueta.val().split('$$');

                    if(datospedido.length>0 ){
                        var existe;
                        $.each(datospedido,function(index1,elemento1){
                            if(elemento1.mesaid==datos[0]){
                                existe=index1;
                                return true;
                            }
                        });
                        if(existe>=0){
                          datospedido[existe].datos.push({'plato':datos[3],'pedido':datos[5],'bebida':datos[4]});
                        }else{
                           datospedido.push({'mesaid':datos[0],'mesanombre':datos[1],'mesero':datos[2],'datos':[],'pedido':datos[5],'cliente':datos[6]});
                            datospedido[datospedido.length-1].datos.push({'plato':datos[3],'pedido':datos[5],'bebida':datos[4]});
                        }
                    }else{
                        datospedido.push({'mesaid':datos[0],'mesanombre':datos[1],'mesero':datos[2],'datos':[],'pedido':datos[5],'cliente':datos[6]});
                        datospedido[0].datos.push({'plato':datos[3],'pedido':datos[5],'bebida':datos[4]});
                    }
                }
            });
            //this.idpedidos.push(datospedido);
            if(datospedido.length>0){
                axios.post('/otherhome.guardarpedido?operacion=cocina',{ datos:datospedido })
                   .then(({data:{cliente1}}) => {
                   Materialize.toast('Registro exitoso.',4000);
                        datospedido=[];
                        $(".fieldsetmesas").find('input[type=checkbox]').each(function(index,elemento){
                         $(elemento).prop('checked', false);
                        });
                        ocultarcargando();
                        this.cargarpedido();
                   });
            }else{
                Materialize.toast("No a seleccionado ningun pedido.",4000);
            }
         },
         seleccionartodos (id){
            $("#amesas"+id).find('input[type=checkbox]').each(function(index,elemento){
                var valor=$("#mesa"+id).prop("checked");
                $(elemento).prop('checked', valor);
            });
         },
         seleccionplato (id){
            if(!$(id).is(':checked')){
                                         $(id).removeAttr('checked',false);
                                     }else{
                                         $(id).prop('checked',true);
                                     }
         }

      }
 }

</script>