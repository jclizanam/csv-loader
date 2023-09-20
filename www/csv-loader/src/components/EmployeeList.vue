<template>
  <div class="employees">
    <div class="wrapper" v-if="employees && employees.length > 0">
      <h2>Employees</h2>
      <div>
        <div class="header grid-table">
          <span>UID </span>
          <span>Company</span>
          <span>Employee </span>
          <span class="salary">Salary </span>
          <span>Edit</span>
        </div>

        <div class="employee grid-table" v-for="employee in employees" :key="employee.id">
          <span>{{ employee.id }}</span>
          <span>{{ employee.company }}</span>
          <span>
            {{ employee.name }}
            <a :href="`mailto:${employee.email}`">{{ employee.email }}</a>
          </span>

          <span class="salary">${{ employee.salary }}</span>
          <ButtonTemplate @click="editEmployee(employee)">Edit</ButtonTemplate>
        </div>
      </div>
    </div>
    <div v-else class="no-employees">
      <p>No employees at this moment.</p>
    </div>
  </div>
  <EditEmployee />
</template>

<script>
import { mapState } from 'vuex'
import ButtonTemplate from '@/components/ButtonTemplate.vue'
import EditEmployee from '@/components/EditEmployee.vue'

export default {
  components: {
    ButtonTemplate,
    EditEmployee
  },
  data() {
    return {
      editEmployeeProps: {
        id: Number,
        company: String,
        name: String,
        email: String,
        salary: Number
      }
    }
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
    editEmployee(employee) {
      this.$store.dispatch('EDIT_EMPLOYEE', employee)
    }
  }
}
</script>
<style lang="scss">
.employees {
  width: 100%;
  @include flex(column, flex-start);

  .wrapper {
    display: flex;
    flex-direction: column;
    gap: $space2;
    @include size(100%);
    h2 {
      @include font($white, 2.4rem, 400);
    }

    .grid-table {
      grid-template-columns: 3rem repeat(3, minmax(8rem, 1fr)) 10rem;

      @include breakpoint(large) {
        grid-template-columns: 8rem repeat(3, minmax(8rem, 1fr)) 10rem;
        gap: $space1;
      }
    }

    .header {
      display: grid;
      background-color: $blue;
      border: 1px solid $blue;
      padding: 1.5rem 3rem;
      @include font($white, 1.6rem, 400);
      text-align: left;
    }

    .employee {
      display: grid;
      padding: 1.5rem 3rem;
      background-color: $offBlack;
      border-bottom: 1px solid $grey;
      align-items: center;

      span {
        @include font($white, 1.6rem, 400);
        @include flex(column, flex-start);

        a {
          @include font($yellow, 1.4rem, 600);
          text-overflow: ellipsis;
          overflow: hidden;
          white-space: nowrap;
          width: 100%;
        }
      }
    }
  }

  .no-employees {
    p {
      @include font($white, 2rem, 400);
    }
  }
}
</style>
