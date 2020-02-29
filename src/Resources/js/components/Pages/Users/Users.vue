<template lang="pug">
.container(id="users-page")
  .columns
    .column
      h2.subtitle Users ({{totalUsers}})

    .column
      BPhixSearchForm(
        :sort="getFilterSort"
        :keyword="getSearchKeyword"
        @confirm="confirmSearch"
      )

  .table-container
    table.table.is-bordered.is-striped.is-hoverable.is-fullwidth
      thead
        tr
          th Unique
          th User info

      tbody
        template(v-if="!hasUsers && !pageLoadComplete")
          tr
            td(colspan="2")
              p No user

        template(v-else)
          tr(
            v-for="(item, key) in getUserList.data"
            :key="`users-${key}`"
          )
            td
              router-link(:to="{name: 'user-item',params: { userId: item.id}}") {{item.user_unique}}
            td {{ item.user_info }}

  BPhixPagination(
    :pagination="getUserList"
    @paginate="paginate(getUserList.current_page)"
  )

</template>

<script>

import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';

import BPhixPagination from '@BaseUI/Pagination'
import BPhixSearchForm from '@BaseUI/SearchForm'

export default {
  name: 'Issues',
  components:{
    BPhixPagination,
    BPhixSearchForm,
  },
  data (){
    return {
      pageLoadComplete: true,
    }
  },
  methods: {
    ...mapActions('users',[
      'setUserList',
    ]),
    ...mapMutations([
      'setSearchFilter',
    ]),
    paginate(pageId){
      this.setUserList(pageId);
    },
    confirmSearch(search){
      this.setSearchFilter(search);
      this.setUserList(1);
    }
  },
  computed: {
    ...mapGetters([
      'getSearchKeyword',
      'getFilterSort',
    ]),
    ...mapState('users', [
      'totalUsers',
    ]),
    ...mapGetters('users', [
      'getUserList',
    ]),
    hasUsers(){
      return typeof this.getUserList.data !== 'undefined' && this.getUserList.data.length;
    },
  },
  mounted() {
    this.setUserList(1);
  },
  watch: {
    getUserList(){
      // console.log('hasUsers', this.hasUsers);
      this.pageLoadComplete =false;
    }
  },
};
</script>

<style scoped lang="scss"></style>
