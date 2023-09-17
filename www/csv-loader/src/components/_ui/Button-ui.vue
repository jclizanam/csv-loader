<template>
  <button class="button" @click="handleClick">
    <slot>Button</slot>
  </button>
</template>

<script>
export default {
  props: {
    handleClick: {
      type: Function,
      required: true
    }
  }
}
</script>
<style lang="scss">
.button {
  @include flex(column, center);
  @include font($white, 1.5rem, 600);
  cursor: pointer;
  background-color: $blue;
  padding: $space1;
  border-radius: $spaceHalf;
}
</style>
