<template>
<div>
    <ul class="collapsible" data-collapsible="accordion">
        <li v-for="da in datos" :id="da.id">
          <div class="collapsible-header"><i class="material-icons">monetization_on</i><h5>{{ da.mesanombre }} <a href="#!" @click="guardarfactura(da.mesa,da.mesero,da.mesanombre,da.idpedido)" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="material-icons right">save</i></a><span class="badge badge-light red white-text">{{ formatearnumero(da.total) }}</span></h5></div>
          <div class="collapsible-body">
                <div v-for="(da1,index) in da.datos">
                   <p v-if="da1.plato!='' && da1.plato!=null">
                    <i class="material-icons">grade</i>{{ da1.plato }} <span class="badge rigth red white-text">{{ da1.precioplato }}</span>
                   </p>
                    <p v-if="da1.bebida!='' && da1.bebida!=null">
                      <i class="material-icons">grade</i> {{ da1.bebida }} <span class="badge rigth red white-text">{{ da1.preciobebida }}</span>
                    </p>
                </div>
                <hr>
                <span class="badge green white-text">{{ formatearnumero(da.total) }}</span>
          </div>

        </li>
    </ul>
</div>
</template>

<script>
import $ from 'jquery'
import axios from 'axios'

export default {
      data: () => ({
        total: 0,
        page:1,
        resource_url: '/otherhome',
        datos:[]
      }),

      mounted () {
            this.user=window.Laravel.user;
            this.cargarpedidocaja();
            this.listenCaja();
            //$(".timeago").timeago();
      },
      methods: {
        listenCaja () {
            window.Echo.private(`App.User.${window.Laravel.user.id}`)
               .notification(notification => {
                 this.cargarpedidocaja();
            })
        },
        cargarpedidocaja (){
            mostrarcargando();
            axios.post('/otherhome.listarpedidoscaja')
                  .then(({ data: { total, datoscaja }}) => {
                //this.datos=datoscaja;
                var caja=[],pedidosmesa=[];
                $.each(datoscaja,function(index,value){
                    var validar;

                    for(var i=0;i<caja.length;i++){
                        if(caja[i].mesa==value.mesa){
                            validar=i;
                            break;
                        }
                    }
                    if(validar>=0){
                        var total= parseInt(caja[validar].total)+parseInt(value.preciobebida!='' && value.preciobebida!=null?value.preciobebida:0)+parseInt(value.precioplato!='' && value.precioplato!=null?value.precioplato:0);
                        caja[validar].total=total;
                        caja[validar].datos.push(value);
                        caja[validar].idpedido.push({id:value.id,precio:value.preciobebida!='' && value.preciobebida!=null?value.preciobebida:value.precioplato});
                    }else{
                        var cont=caja.length;
                        var total=parseInt(value.preciobebida!='' && value.preciobebida!=null?value.preciobebida:0)+parseInt(value.precioplato!='' && value.precioplato!=null?value.precioplato:0);
                        caja.push({"mesa":value.mesa,"mesanombre":value.mesanombre,"mesero":value.mesero,"total":total,"datos":[],idpedido:[]});
                        caja[cont].datos.push(value);
                        caja[cont].idpedido.push({id:value.id,precio:value.preciobebida!='' && value.preciobebida!=null?value.preciobebida:value.precioplato});
                    }

                });
                ocultarcargando();
                this.datos=caja;
            });
        },
      formatear (nStr){
           nStr += '';
              var x = nStr.split('.');
              var x1 = x[0];
              var x2 = x.length > 1 ? ',' + x[1] : '';
               var rgx = /(\d+)(\d{3})/;
               while (rgx.test(x1)) {
                       x1 = x1.replace(rgx, '$1' + '.' + '$2');
               }
               return x1 + x2;
       },
       formatearnumero (num, simbol){
       this.simbol = simbol ||'';
         return this.formatear(num);
       },
       guardarfactura (mesa,mesero,mesanombre,idpedido){
       mostrarcargando();
        axios.post('/otherhome.guardarfactura',{'mesa':mesa,'mesero':mesero,'mesanombre':mesanombre,'idpedido':idpedido})
            .then(({ data: { respuesta }}) => {
            ocultarcargando();
            this.cargarpedidocaja();
        });
        }
      }
}
</script>