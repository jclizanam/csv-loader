<template>
  <div class="process-file">
    <ButtonTemplate @click="selectFile"><PlusIcon /> Import users</ButtonTemplate>
    <input type="file" ref="uploader" accept=".csv" @change="uploadFile" />
  </div>
</template>

<script>
import ButtonTemplate from '@/components/ButtonTemplate.vue'
import PlusIcon from '@/components/Icons/PlusIcon.vue'

export default {
  data() {
    return {
      processingFile: false,
      hasSelectedFile: false,
      fileName: '',
      fileSize: 0,
      loading: false
    }
  },
  components: {
    ButtonTemplate,
    PlusIcon: PlusIcon
  },
  methods: {
    selectFile() {
      this.$refs.uploader.click()
    },
    uploadFile() {
      this.hasSelectedFile = true
      this.fileName = this.$refs.uploader.files[0].name
      const formData = new FormData()
      formData.append('employees-csv', this.$refs.uploader.files[0])
      this.$store
        .dispatch('UPLOAD_CSV', formData)
        .then((res) => {
          console.log(res)
        })
        .catch((error) => {
          console.log(error)
        })
    },
    getUsers() {
      this.$store.dispatch('GET_EMPLOYEES')
    }
  }
}
</script>

<style lang="scss">
.process-file {
  @include size(100%);
  @include flex(row, flex-end);
  input[type='file'] {
    display: none;
  }
}
</style>
