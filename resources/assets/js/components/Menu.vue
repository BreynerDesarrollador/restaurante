<template>
    <div>
        <div v-for="da in datos.data" class="col col-12 col-md-4 col-xs-4" :id="da.id">
                                    <div class="card">
                                        <div class="card-image">
                                           <a href="#!" @click="cargarplatosmenu(da.id)">
                                                <img class="intense" height="150" width="100" :src="'/'+da.imagen">
                                           </a>

                                        </div>
                                        <div class="card-content">
                                        <span class="card-title black-text">
                                        <span v-bind:class="{ truncate: truncar20(da.nombre) }" :id="'menutexto'+da.id">{{ da.nombre }} </span>
                                        <a v-if="da.nombre.length>15" class="leermastitulo" href="#!" :id="'menutextoleermas'+da.id" @click="quitartruncate('menutextoleermas','menutexto',da.id)"><small>leer más</small></a>
                                        </span>
                                            <span v-bind:class="{ truncate: truncar38(da.descripcion) }" :id="'menutextodescripcion'+da.id">{{ da.descripcion }}</span>
                                            <a v-if="da.descripcion.length>38" class="leermastexto" href="#!" :id="'menutextodescripcionleermas'+da.id" @click="quitartruncate('menutextodescripcionleermas','menutextodescripcion',da.id)"><small>leer más</small></a>
                                        </div>
                                    </div>
                                </div>
    </div>
</template>
<script>
import $ from 'jquery'
import axios from 'axios'
import App from './AppCliente'

export default {
  props:['datoscliente','datosmenus1'],
  components: {
        App
      },
    data: () => ({
      total: 0,
      datos:{}
    }),

  mounted () {
    this.cargarmenuclienteapp();
  },
  methods: {
    cargarmenuclienteapp (page) {
          App.methods.internet();
          axios.post('/otherhome.listarmenuplatos?op=menu'+"&page="+page+"&buscar="+this.buscar)
            .then(({ data: { total, da }}) => {
              this.total = total
              this.datos =da;
          });
    },
    truncar20 (nombre){
        return App.methods.truncartexto20(nombre);
    },
    truncar38 (descripcion){
           return App.methods.truncartexto38(descripcion);
        }
  }
}
</script>