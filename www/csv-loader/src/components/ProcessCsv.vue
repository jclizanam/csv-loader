<template>
  <div class="process-file">
    <div class="file-selector">
      <span>Import employees from CSV file.</span>
      <v-button :handle-click="selectFile">Select file</v-button>
      <input type="file" ref="uploader" accept=".csv" @change="uploadFile" />
    </div>
  </div>
</template>

<script>
import ButtonUi from '@/components/_ui/Button-ui.vue'

export default {
  data() {
    return {
      processingFile: false,
      hasSelectedFile: false,
      fileName: '',
      fileSize: 0
    }
  },
  components: {
    'v-button': ButtonUi
  },
  methods: {
    selectFile() {
      this.$refs.uploader.click()
    },
    uploadFile() {
      this.hasSelectedFile = true
      this.fileName = this.$refs.uploader.files[0].name
    }
  }
}
</script>

<style lang="scss">
.process-file {
  @include flex(column, center, flex-start, $space2);
  span {
    @include font($black, 2rem, 400);
  }
  input[type='file'] {
    display: none;
  }
  .file-selector {
    @include flex(row, center, flex-start, $space2);
  }
}
</style>
