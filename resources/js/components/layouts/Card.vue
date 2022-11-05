<template>

  <div class="card">
    <div class="card-header">{{ titulo }}</div>
    <div class="card-body">
        <slot name="card-body-data"></slot>
    </div>
    <div :class="fc">
        <slot name="card-footer-data"></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: ["titulo", "fc"],
};
</script>
