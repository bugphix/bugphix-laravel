<template lang="pug">
.container(id="projects-page")
  .columns
    .column
      h2.subtitle Projects ({{totalProjects}})
        button.button.is-small.is-primary.btn-create-project(
          @click="showModal"
        ) Create

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
          th Projects
          th.column-narrow(align="center") Status
          th.column-narrow(align="center") Issues

      tbody
        tr(
          v-for="(item, key) in getProjectList.data"
          :key="`projects-${key}`"
          :class="{'project-deactivated': !item.is_active}"
        )
          td
            router-link(
              class="error-exception"
              :to="{name: 'project-item',params: { projectId: item.project_id }}"
            ) {{item.project_name}}
          td(align="center") {{item.is_active ? 'Active' : 'Deactivated'}}
          td(align="center") {{formatIssue(item.issues)}}

  BPhixPagination(
    :pagination="getProjectList"
    @paginate="paginate(getProjectList.current_page)"
  )

  CreateProjectModal

</template>

<script>

import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';

import { nFormat } from '@/assets/scripts/utilities';

import BPhixPagination from '@BaseUI/Pagination'
import BPhixSearchForm from '@BaseUI/SearchForm'

// child components
import CreateProjectModal from './children/CreateProjectModal.vue';

export default {
  name: 'Issues',
  components:{
    BPhixPagination,
    BPhixSearchForm,
    CreateProjectModal
  },
  data() {
    return {
      dropDownValue: {
        sort: this.getFilterSort,
      },
      dropDownList: {
        sort: ['latest', 'oldest'],
      }
    }
  },
  methods: {
    ...mapMutations([
      'setSearchFilter',
    ]),
    ...mapActions('projects',[
      'setProjectList',
    ]),
    ...mapMutations('projects',[
      'setShowCreateProjectModal',
    ]),
    paginate(pageId){
      this.setProjectList(pageId);
    },
    showModal(){
      this.setShowCreateProjectModal(true);
    },
    confirmSearch(search){
      this.setSearchFilter(search);
      this.setProjectList(1);
    },
    formatIssue(issue){
      return nFormat(issue);
    }
  },
  computed: {
    ...mapGetters([
      'getSearchKeyword',
      'getFilterSort',
    ]),
    ...mapState('projects', [
      'totalProjects',
    ]),
    ...mapGetters('projects', [
      'getProjectList',
    ]),
  },
  mounted() {
    this.setProjectList(1);
  }
  // watch: {},
};
</script>

<style scoped lang="scss">
.toggle-all{
  width: 20px;
}

.column-narrow{
  width: 150px;
}
.btn-create-project{
  margin-left: 10px;
}
.project-deactivated{
  opacity:0.3;
  &:hover{
    opacity:1;
  }
}
</style>
