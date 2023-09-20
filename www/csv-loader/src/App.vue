<template>
  <main>
    <component :is="$route.meta.layout || div">
      <router-view />
    </component>
  </main>
</template>
<style lang="scss">
.main {
  background: $blue;
}
</style>
<script setup></script>
