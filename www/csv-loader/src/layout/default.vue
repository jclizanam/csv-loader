<template>
  <div class="page-wrapper">
    <div class="wrapper">
      <RouterView />
    </div>
  </div>
</template>

<script>
export default {
  name: 'defaultLayout'
}
</script>

<style lang="scss" scoped>
.page-wrapper {
  @include flex(column, center, flex-start);
  width: 100%;
  min-height: 100vh;
  padding: $space2;
  background-color: $black;

  .wrapper {
    width: 100%;
    max-width: 1300px;
    @include flex(column, flex-start);
    gap: $space3;
  }
}
</style>
