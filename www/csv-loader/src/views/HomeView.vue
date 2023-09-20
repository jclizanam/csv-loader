<template>
  <HeaderPage title="Employees" subtitle="You can see all your employees from this page" />
  <UploadCsv />
  <EmployeeList />
</template>

<script>
import HeaderPage from '@/components/HeaderPage.vue'
import UploadCsv from '@/components/UploadCsv.vue'
import EmployeeList from '@/components/EmployeeList.vue'
export default {
  name: 'HomeView',
  components: {
    EmployeeList,
    HeaderPage: HeaderPage,
    UploadCsv: UploadCsv
  }
}
</script>
