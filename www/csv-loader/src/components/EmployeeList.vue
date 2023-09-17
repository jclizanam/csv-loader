<template>
  <div class="employees">
    <h2>Employees</h2>
    <div class="list" v-if="employees && employees.length > 0">
      <div class="header grid-table">
        <span>UID </span>
        <span>Company</span>
        <span>Name </span>
        <span>Email </span>
        <span>Salary </span>
        <span>Edit</span>
      </div>
      <div class="employee grid-table" v-for="employee in employees" :key="employee.id">
        <span>{{ employee.id }}</span>
        <span>{{ employee.company_name }}</span>
        <span>{{ employee.name }} </span>
        <span>{{ employee.email }}</span>
        <span>{{ employee.salary }}</span>
        <v-button :handle-click="editEmployee(employee)">Edit</v-button>
      </div>
    </div>
    <div v-else>
      <p>No employees at this moment</p>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import ButtonUi from '@/components/_ui/Button-ui.vue'

export default {
  components: {
    'v-button': ButtonUi
  },
  mounted() {
    this.$store.dispatch('GET_EMPLOYEES')
  },
  computed: {
    ...mapState({
      employees: (state) => state.employees
    })
  },
  methods: {
    editEmployee(employee) {}
  }
}
</script>
<style lang="scss" scoped>
.employees {
  h2 {
    padding-bottom: 30px;
  }

  .list {
    display: grid;
    grid-template-rows: 1fr;

    .grid-table {
      grid-template-columns: 5rem repeat(5, 1fr);
      gap: $space3;
    }

    .header {
      display: grid;
      background-color: $grey;
      border: 1px solid $grey;
      padding: 10px 10px;
      border-top-right-radius: 5px;
      border-top-left-radius: 5px;
      text-align: left;
      font-size: 14px;
      color: $grey-super-light;
    }

    .employee {
      display: grid;
      padding: 15px 7px;
      background-color: $white;
      border-bottom: 1px solid $grey;
      align-items: center;

      span {
        font-size: 14px;
        padding-bottom: 5px;
      }
    }
  }
}
</style>
