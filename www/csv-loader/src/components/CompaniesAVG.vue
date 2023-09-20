<template>
  <div class="salaries">
    <div class="salary" v-for="company in companies" :key="company.name">
      <span class="name">{{ company.company }}</span>
      <span class="amount">${{ company.average_salary }}</span>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: 'CompaniesAvg',
  mounted() {
    this.$store.dispatch('GET_COMPANIES_AVG')
  },
  computed: {
    ...mapState({
      companies: (state) => state.companies
    })
  }
}
</script>

<style lang="scss">
.salaries {
  display: grid;
  grid-template-columns: 1fr 1fr;
  @include breakpoint(medium) {
    grid-template-columns: repeat(auto-fit, minmax(8rem, 1fr));
  }

  width: 100%;
  gap: $space2;
  .salary {
    @include flex(column, center);
    border: 1px solid $yellow;
    padding: $space3;
    border-radius: $spaceHalf;

    .name {
      @include font($white, 2rem, 700);
      text-align: center;
    }

    .amount {
      @include font($yellow, 2.5rem, 700);
    }
  }
}
</style>
