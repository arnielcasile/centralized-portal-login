<template>
  <div class="case" :style="{width:width + '%'}">
      <slot></slot>
  </div>
</template>

<script>
export default {
  name: "Case",
  props:{
    width: Number,
  }
};
</script>

<style>
.case {
    width:auto;
    height:auto;
    border:1px solid rgb(212 219 220);
    padding:60px 50px 50px 50px;
}
</style>