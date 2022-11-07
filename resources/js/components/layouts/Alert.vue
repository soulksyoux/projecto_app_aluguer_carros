<template>

<div :class="estilo" role="alert">
  {{ message }}
</div>

</template>

<script>
export default {
  props: ["type", "message"],
  computed: {
    estilo() {
        return "alert alert-" + this.type;
    }
  }
};
</script>


