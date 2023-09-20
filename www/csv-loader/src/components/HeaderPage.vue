<template>
  <div class="header">
    <h1>{{ title }}</h1>
  </div>
</template>

<script>
export default {
  name: 'PageHeader',
  props: {
    title: String
  }
}
</script>

<style lang="scss">
.header {
  width: 100%;
  @include flex(column, flex-start, flex-start);
  border-bottom: 0.5px solid $grey;
  h1 {
    @include font($grey, 2.4rem, 400);
    padding-bottom: $space1;
  }
}
</style>
