<template lang="pug">
.container(id="issues-page")
  .columns
    .column
      h2.subtitle.issue-title {{getFilterStatus}} issues ({{totalIssues}})

    .column.is-four-fifths.search-wrapper

      BPhixSearchForm(
        :sort="getFilterSort"
        :keyword="getSearchKeyword"
        ref="searchForm"
        @confirm="confirmSearch"
      )
        template(#searchBefore)
          .action-buttons.buttons(
            v-if="hasSelected"
          )
            button.button.is-primary(
              :class="{'is-loading' : buttonIsLoading}"
              :disabled="buttonIsLoading"
              @click="updateStatus('resolved')"
            )
              span.icon
                i.mdi.mdi-check
              span Resolve {{ selected.length }} issues

            button.button.is-warning(
              :class="{'is-loading' : buttonIsLoading}"
              :disabled="buttonIsLoading"
              @click="updateStatus('ignored')"
            )
              span.icon
                i.mdi.mdi-close
              span Ignore {{ selected.length }} issues

          .dropdown.is-right(
            :class="{'is-active' : openStatusFilter}"
            @click="openStatusFilter = !openStatusFilter"
          )
            .dropdown-trigger
              button.button(
                aria-haspopup="true"
                aria-controls="dropdown-menu"
              )
                span {{getFilterStatus}} issues
                span.icon.is-small
                  i.mdi.mdi-chevron-down

            .dropdown-menu
              .dropdown-content
                a.dropdown-item(
                  v-for="(status, key) in searchFilterOptions.status"
                  :key="`filter-status-${key}`"
                  :class="status === getFilterStatus ? 'is-active' : ''"
                  @click.prevent="updateStatusFilter(status)"
                ) {{status}} issues

  .table-container
    table.table.is-bordered.is-hoverable.is-fullwidth
      thead
        tr
          th.toggle-all
            input(
              type="checkbox"
              v-model="selectAll"
            )
          th Events
          th.event-counters(
            align="center"
          ) Counts
          th.event-counters(
            align="center"
          ) Users

      tbody
        template(v-if="!hasIssues && !pageLoadComplete")
          tr
            td(colspan="4")
              p No issues

        template(v-else)
          tr(
            v-for="(item, key) in issues"
            :key="`issues-${key}`"
          )
            td
              input(
                type="checkbox"
                v-model="selected"
                :value="item.id"
              )

            td.table-body-event
              router-link(
                class="error-exception"
                :to="{name: 'issue-item',params: {projectId: getActiveProjectId, id: item.id}}"
              ) {{item.issue_error_exception}}

              span.error-message(
                :title="item.issue_error_message.full"
              ) {{item.issue_error_message.excerpt}}

              span.error-time(
                v-html="errorTime(item.updated_at)"
              )

            td(align="center") {{item.issue_counts}}
            td(align="center") {{item.issue_users}}

  BPhixPagination(
    :pagination="getIssueList"
    @paginate="paginate(getIssueList.current_page)"
  )

</template>

<script>

import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';
import { renderEventHtml } from '@/assets/scripts/utilities';
import IssueApi from '@/services/IssueApi';

import BPhixPagination from '@BaseUI/Pagination'
import BPhixSearchForm from '@BaseUI/SearchForm'

export default {
  name: 'Issues',
  components:{
    BPhixPagination,
    BPhixSearchForm,
  },
  data(){
    return {
      selected: [],
      openStatusFilter: false,
      buttonIsLoading: false,
      pageLoadComplete: true,
      searchFilterStatus: this.getFilterStatus,
      searchFilterOptions: {
        status: ['unresolved', 'resolved', 'ignored']
      }
    }
  },
  methods: {
    ...mapMutations([
      'setSearchFilter',
    ]),
    ...mapActions('issues',[
      'setIssueList',
    ]),
    paginate(pageId){
      this.selected=[];
      this.setIssueList(pageId);
    },
    errorTime(_time){
      return renderEventHtml(_time);
    },
    updateStatus(status='resolve'){

      if(this.selected.length === 0) return;

      const ids = this.selected.join(',');
      const formData = {
        issue_status: status
      }
      IssueApi.bulkUpdate(ids, formData)
        .then((response) => {
          if(response.data.success){
            this.$notify({
              text: 'Issues updated',
            });
            this.setIssueList(1);
          }
        })
        .catch((error) => {
          this.$notify({
            type: 'error',
            text: 'Oops, something went wrong. Try again later.',
          });
        })
        .then(()=>{
          this.selected = [];
        })
    },
    updateStatusFilter(status){
      // this.confirmSearch();
      this.searchFilterStatus = status;
      this.$refs.searchForm.$el.getElementsByClassName('btn-submit')[0].click()
    },
    confirmSearch(search){
      const newSearch = search;
      newSearch.status = this.searchFilterStatus || this.getFilterStatus;
      this.setSearchFilter(newSearch);
      this.setIssueList(1);
    }
  },
  computed: {
    ...mapGetters([
      'getSearchKeyword',
      'getFilterSort',
      'getFilterByPage',
    ]),
    ...mapState('issues',[
      'totalIssues',
    ]),
    ...mapGetters([
      'getActiveProjectId',
    ]),
    ...mapGetters('issues', [
      'getIssueList',
      'getFilterStatus',
    ]),
    selectAll: {
      get: function () {

        if(this.issues.length === 0) return false;

        return this.issues ? this.selected.length === this.issues.length : false;
      },
      set: function (value) {
        var selected = [];
        if (value) {
          this.issues.forEach(function (user) {
            selected.push(user.id);
          });
        }
        this.selected = selected;
      }
    },
    hasIssues(){
      return typeof this.getIssueList.data !== 'undefined' && this.getIssueList.data.length;
    },
    issues(){
      if(!this.hasIssues) return [];
      return this.getIssueList.data;
    },
    hasSelected(){
      return this.selected.length;
    },
    getFilterStatus() {
      return this.getFilterByPage('issues').status || 'unresolved';
    },
  },
  mounted() {
    this.setIssueList(1);
  },
  watch: {
    getIssueList(){
      this.pageLoadComplete =false;
    }
  },
};
</script>

<style scoped lang="scss">
.issue-title{
  text-transform: capitalize;
}
.toggle-all{
  width: 20px;
}

.event-counters{
  width: 100px;
}

.table-body-event{

  > span{
    display: block;
  }

  .error-message{
    color: #333;
    font-size: 0.75em;
  }
  .error-time{
    color: #333;
    font-size: 0.625em;
  }
}

.action-buttons.buttons {
  margin-bottom: 0;
  margin-right: 5px;
}

</style>
