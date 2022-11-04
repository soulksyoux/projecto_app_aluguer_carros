<template>
  <div class="mb-3">
    <label :for="idInput" class="form-label">{{ titulo }}</label>
    <slot></slot>    
  </div>
</template>

<script>
    export default {
        props: ["idInput", "titulo"],
    }
</script>
