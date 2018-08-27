<template>
<div class="row">
    <pulse-loader class="preloader-background" :loading="loading" :color="'#017A95'"></pulse-loader>
    <div class="col s12 m6 l6">
        <h5 center>Tus notificaciones <span class="btn btn-floating green">{{total}}</span></h5>
    </div>
     <div class="col s12 m6 l6">
        <h5><a hre="#!" @click="eliminarnotificacionestodas" class="badge right red white-text">Eliminar todas las notififaciones</a></h5>
     </div>
     <div class="col s12 m12 l12">
    <ul class="collection">
        <li class="collection-item avatar" v-for="(da,index) in notificaciones">
          <img src="/img/WAITER50.png" alt="Tus notificaciones de waiter" class="circle">
          <a href="#!" class="title"><strong>{{da.data.titulo}}</strong></a>
          <p>
            {{da.data.mensaje}}<br>
            <small class="timestamp">
              <timeago :since="da.created_at" :auto-update="30"></timeago>
            </small>
          </p>

          <a href="#!" class="secondary-content" @click="eliminarnotificacion(index,da.id)"><i class="ion-ios-close-outline red-text font30"></i></a>
        </li>
    </ul>
    </div>
</div>
</template>
<script>
    import axios from 'axios'

    export default{
        data: () =>({
            notificaciones:[],
            total:0,
            loading:false,
        }),
        mounted () {
            this.cargarnotificaciones();
        },
         methods: {
            cargarnotificaciones (){
                this.loading=true;
                axios.post('/notifications/postall')
                    .then(({data:{datos,total}}) =>{
                        this.notificaciones=datos;
                        this.total=total;
                        this.loading=false;
                    }).catch(function (error){
                        Materialize.toast('Error::..'+error,4000);
                        this.loading=false;
                    });
            },
            eliminarnotificacion (index,id){
                this.loading=true;
                this.total--
                this.notificaciones.splice(index, 1);
                axios.patch('/notifications/delete',{'id':id})
                    .then(({data}) =>{
                        this.loading=false;
                }).catch(function (error){
                    Materialize.toast('Error::..'+error,4000);
                    this.loading=false;
                });
            },
            eliminarnotificacionestodas(){

                axios.post('/notifications/deleteall')
                    .then(({data}) =>{
                         Materialize.toast("Se han eliminado todas las notificaciones.",2000);
                         this.total=0;
                         this.notificaciones=[];
                }).catch(function (error){
                   Materialize.toast('Error::..'+error,4000);
                });
            }
         }
    }
</script>
<style>
    .font30{
        font-size:30px;
    }
</style>