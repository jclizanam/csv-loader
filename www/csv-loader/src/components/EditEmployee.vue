<template>
  <div class="edit-user" v-if="loaded">
    <div class="wrapper">
      <h3>Employee details</h3>
      <div class="field">
        <label>Company</label>
        <input type="text" name="company" v-model="form.company" />
      </div>
      <div class="field">
        <label>Name</label>
        <input type="text" name="company" v-model="form.name" />
      </div>
      <div class="field">
        <label>Email</label>
        <input type="text" name="company" v-model="form.email" />
      </div>
      <div class="field">
        <label>Salary</label>
        <input type="number" name="company" v-model="form.salary" min="1" />
      </div>
      <div class="buttons">
        <ButtonTemplate @click="loaded = false">Close</ButtonTemplate>
        <ButtonTemplate @click="updateEmployee">Save</ButtonTemplate>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import ButtonTemplate from '@/components/ButtonTemplate.vue'

export default {
  name: 'EditEmployee',
  data() {
    return {
      loaded: false,
      form: {
        id: '',
        company: '',
        name: '',
        email: '',
        salary: ''
      },
      errors: {
        company: false,
        name: false,
        email: false,
        salary: false
      }
    }
  },
  methods: {
    updateEmployee() {
      const formFields = Object.keys(this.errors)
      formFields.map((field) => {
        if (field === 'email' && !this.validEmail(this.form[field])) {
          this.errors[field] = true
        } else if (field === 'salary' && this.form[field] < 1) {
          this.errors[field] = true
        } else if (!this.form[field]) {
          this.errors[field] = true
        }
      })

      const hasError = formFields.filter((field) => this.errors[field]).length > 0

      if (!hasError) {
        const formData = new FormData()
        formData['id'] = this.form.id
        formFields.map((field) => {
          formData[field] = this.form[field]
        })
        this.$store
          .dispatch('SAVE_EMPLOYEE', formData)
          .then((res) => {
            this.loaded = false
          })
          .catch((error) => {
            console.log(error)
          })
      }
    },
    validEmail: function (email) {
      var re =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return re.test(email)
    }
  },
  components: {
    ButtonTemplate
  },
  computed: {
    ...mapState({
      employee: (state) => state.employee
    })
  },
  watch: {
    '$store.state.employee': {
      handler(employee) {
        console.log(employee.id)
        if (employee.id && employee.id.length > 0) {
          this.form.id = employee.id
          this.form.company = employee.company
          this.form.name = employee.name
          this.form.email = employee.email
          this.form.salary = employee.salary
          this.loaded = true
        }
      },
      immediate: true
    }
  }
}
</script>

<style lang="scss" scoped>
.edit-user {
  position: fixed;
  @include size(100%);
  @include flex(column, center, center);
  background-color: rgba(0, 0, 0, 0.6);
  left: 0;
  top: 0;

  .wrapper {
    background-color: $black;
    padding: $space3;
    border-radius: $spaceHalf;
    @include flex(column, center);
    gap: $space2;

    h3 {
      @include size(100%);
      @include font($white, 2rem, 600);
    }

    .field {
      @include size(100%);
      label {
        @include font($white, 1.6rem, 600);
        text-align: left;
        padding-bottom: 10px;
        font-size: $form-font-size;
      }

      input {
        width: 100%;
        border: 1px solid $grey;
        border-radius: 10px;
        padding: 17px 25px;
        font-size: $form-font-size;
      }

      .error-field {
        border: 1px solid $red;
      }

      .error-label {
        color: $red;
      }
    }

    .buttons {
      @include size(100%);
      gap: $space4;
      @include flex(row, center, space-between);
    }
  }
}
</style>
