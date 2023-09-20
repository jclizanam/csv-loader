<template>
  <button class="button">
    <slot>Button</slot>
  </button>
</template>

<script>
export default {
  name: 'ButtonTemplate'
}
</script>
<style lang="scss">
.button {
  width: 100%;
  @include flex(row, center);
  gap: $space1;
  @include font($black, 1.5rem, 400);
  cursor: pointer;
  background-color: $yellow;
  padding: $space1;
  border-radius: $space1;
}
</style>
