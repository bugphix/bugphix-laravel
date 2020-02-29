<template lang="pug">
#search-box
  .search-filter.buttons

    slot(name="searchBefore")

    .dropdown.is-right(
      :class="{'is-active' : openSortFilter}"
      @click="openSortFilter = !openSortFilter"
    )
      .dropdown-trigger
        button.button(
          aria-haspopup="true"
          aria-controls="dropdown-menu"
        )
          span Sort by: {{sortFilter}}
          span.icon.is-small
            i.mdi.mdi-chevron-down

      .dropdown-menu
        .dropdown-content
          a.dropdown-item(
              v-for="(sort, key) in sortFilterList"
            :key="`filter-sort-${key}`"
            :class="sort === sortFilter ? 'is-active' : ''"
            @click.prevent="updateSortFilter(sort)"
          ) Sort by: {{sort}}

  .field.has-addons.search-box
    .control(
      :class="{'is-loading' : searchIsRunning}"
    )
      input.input.search-field(
        type="search"
        v-model="searchKeyword"
        placeholder="Search"
        @change="returnEmit"
      )
    .control
      button.btn-submit.button.is-primary(
        @click="returnEmit"
      )
        i.mdi.mdi-magnify

</template>

<script>

import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';

export default{
  name: 'SearchForm',
  props: {
    keyword: { type: String, default: '' },
    sort: { type: String, default: 'latest' },
    sortFilterList: { type: Array, default: () => ['latest', 'oldest'] },
    searchIsRunning: { type: Boolean, default: false },
  },
  data() {
    return {
      openSortFilter: false,
      searchKeyword: this.keyword,
      sortFilter: this.sort,
    }
  },
  methods: {
    updateSortFilter( value ){
      this.sortFilter = value;
      this.returnEmit();
    },
    returnEmit() {
      this.$emit('confirm', {
        keyword: this.searchKeyword,
        sort: this.sortFilter,
      })
    }
  }
}
</script>

<style lang="scss" scoped>
#search-box {
  display: flex;
  justify-content: flex-end;

  .search-box{
    margin-left: 5px;

    .search-field{
      width: 300px;
      @media (max-width:1080px){
        width: 180px;
      }
    }
  }

  .search-filter {
    .dropdown {
      margin: 0 5px;
    }
  }
  .dropdown-trigger {
    button > span {
      text-transform: capitalize;
    }
  }
  .dropdown-item{
    text-transform: capitalize;
  }
}</style>
