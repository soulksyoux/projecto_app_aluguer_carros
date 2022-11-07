<template>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th v-for="titulo, key in titulos" :key=key>{{titulo}}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in dados" :key=item.id>
        <td v-for="valor,chave in item" :key=chave>
            <img v-if="chave=='imagem'" :src="'/storage/' + valor" alt="" width="40" height="40">
            <span v-else>{{ valor }}</span>
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
  props: ["dados", "titulos"],
};
</script>
