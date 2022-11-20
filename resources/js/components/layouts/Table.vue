<template>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th v-for="titulo, key in titulos" :key=key>{{titulo}}</th>
        <th v-if="ver.visivel || editar || eliminar.visivel"></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in dados" :key=item.id>
        <td v-for="valor,chave in item" :key=chave>
            <img v-if="chave=='imagem'" :src="'/storage/' + valor" alt="" width="40" height="40">
            <span v-else>{{ valor }}</span>
        </td>
        <td v-if="ver.visivel || editar || eliminar.visivel">
          <button v-if="ver.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="ver.dataBsToggle" :data-bs-target="ver.dataBsTarget" @click="setStore(item)">Ver</button>
          <button v-if="editar" class="btn btn-outline-primary btn-sm">Editar</button>
          <button v-if="eliminar.visivel" class="btn btn-outline-danger btn-sm" :data-bs-toggle="eliminar.dataBsToggle" :data-bs-target="eliminar.dataBsTarget" @click="setStore(item)">Eliminar</button>
        </td>
      </tr>
       <!--  <td >{{item.id}}</td>
        <td>{{item.nome}}</td>
        <td><img :src="'/storage/'+item.imagem" alt="" width="40" height="40"></td>
      </tr> -->
    </tbody>
  </table>
</template>

<script>
export default {
  props: ["dados", "titulos", "ver", "editar", "eliminar"],
  methods: {
    setStore(item) {
      this.$$store.state.transacao.status = "";
      this.$$store.state.transacao.mensagem = "";
      this.$store.state.item = item;
    }
  }
};
</script>
