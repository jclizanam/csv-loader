<template>
  <HeaderPage title="Employees" subtitle="You can see all your employees from this page" />
  <UploadCsv />
  <CompaniesAvg />
  <EmployeeList />
</template>

<script>
import HeaderPage from '@/components/HeaderPage.vue'
import UploadCsv from '@/components/UploadCsv.vue'
import EmployeeList from '@/components/EmployeeList.vue'
import CompaniesAvg from '@/components/CompaniesAVG.vue'
export default {
  name: 'HomeView',
  components: {
    CompaniesAvg,
    EmployeeList,
    HeaderPage: HeaderPage,
    UploadCsv: UploadCsv
  }
}
</script>
