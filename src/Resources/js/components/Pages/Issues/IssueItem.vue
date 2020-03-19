<template lang="pug">
.container(id="issues-page-item")

  template(v-if="!hasItems") Loading...

  template(v-else)
    .issue-action-buttons
      .buttons.has-addons.action-buttons
        template(v-if="issueItem.issue_status !== 'unresolved'")
          button.button(
            :class="{'is-loading' : buttonIsLoading}"
            @click="updateStatus('unresolved')"
            title="Unresolve issue"
          )
            span.icon
              i.mdi.mdi-alert-outline
            span Mark as unresolved
        template(v-else)

          button.button.is-primary(
            :class="{'is-loading' : buttonIsLoading}"
            :disabled="buttonIsLoading"
            @click="updateStatus('resolved')"
            title="Resolve issue"
          )
            span.icon
              i.mdi.mdi-check
            span Mark as resolved

          button.button.is-warning(
            :class="{'is-loading' : buttonIsLoading}"
            :disabled="buttonIsLoading"
            @click="updateStatus('ignored')"
            title="Ignore issue"
          )
            span.icon
              i.mdi.mdi-close
            span Ignore issue

        button.button.is-danger(
            :class="{'is-loading' : buttonIsLoading}"
            :disabled="buttonIsLoading"
            @click="deleteIssue()"
            title="Delete issue permanently"
          )
            span.icon
              i.mdi.mdi-delete
            span Delete

    h2.title.is-4 {{issueItem.issue_error_exception}}

    a.issue-url-request(
      v-if="hasClient"
      :href="clientDetails.client_url"
      target="_blank"
    ) {{requestMethod}}

    template(v-if="issueItem")

      .card.card-margin
        .card-content
          .columns.is-desktop.issues-meta
            template(v-for="(items, title) in sidebarDetails")
              .column
                IssuesMeta(
                  :title="title"
                  :items="items"
                )


      .card.card-margin.issues-client-tags(v-if="hasClient")
        .card-content
          h3.subtitle.is-5 Client details:
            .client-widgets
              .widget(
                v-for="(widget, key) in clientWidgetsData"
                :key="`widget-${key}`"
              )
                ClientWidgets(
                  :content="widget.content"
                  :icon="widget.icon"
                )

      .card.card-margin
        .card-content

          Exception(
            :errorMessage="issueItem.issue_error_message"
            :fileError="fileError"
            :errorLine="stackTrace.stack_trace_error_line"
            :stackTraceArray="stackTrace.stack_trace_data"
            :fullLog="stackTrace.stack_trace_full_log"
            :startLine="stackTrace.stack_trace_start_line"
          )

          .section-spacing.issues-exception-details(v-if="hasClient")
            h3.subtitle.is-5 Headers

            .table-container
              table.table.is-bordered.is-striped.is-fullwidth
                tbody
                  tr(
                    v-for="(value, index) in clientDetails.client_header"
                    :key="`header-${index}`"
                  )
                    td {{index}}
                    td {{value}}

      .buttons.has-addons(
        v-if="prevEventId || nextEventId"
      )
        button.button(
          :disabled="!prevEventId"
          @click="navigateEvent(prevEventId)"
        )
          span.icon
            i.mdi.mdi-chevron-left
          span Older event

        button.button(
          :disabled="!nextEventId"
          @click="navigateEvent(nextEventId)"
        )
          span Latest event
          span.icon
            i.mdi.mdi-chevron-right
</template>

<script>

import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';
import { isObjectEmpty, renderEventHtml } from '@/assets/scripts/utilities';
import IssueApi from '@/services/IssueApi';
import issueClientWidgetMixin from '@/mixins/issue-client-widget-mixins';

// child components
import IssuesMeta from './children/IssuesMeta.vue';
import Exception from './children/Exception.vue';
import ClientWidgets from './children/ClientWidgets.vue';

export default {
  name: 'IssuesItem',
  mixins:[
    issueClientWidgetMixin
  ],
  components: {
    IssuesMeta,
    Exception,
    ClientWidgets,
  },
  data(){
    return {
      isFullLog: false,
      buttonIsLoading: false,
    }
  },
  methods: {
    ...mapMutations([
      'setIsPageLoading',
    ]),
    ...mapActions([
      'setActiveProject',
    ]),
    ...mapMutations('issues', {
      _setIssueItem : 'setIssueItem'
    }),
    ...mapActions('issues',[
      'setIssueItem',
      'setEventItem',
    ]),
    deleteIssue(){
      this.buttonIsLoading=true;
      IssueApi.delete(this.issueItem.id)
        .then((response) => {
          if(response.data.success){
            this.$notify({
              text: response.data.message,
            });
            this.setIsPageLoading(true);
            setTimeout(()=>{
              this.setIsPageLoading(false);
              this.$router.push({ name: "issues"});
            }, 1000);
          }
        })
        .catch((error) => {
          this.$notify({
            type: 'error',
            text: 'Oops, something went wrong. Try again later.',
          });
        })
        .then(()=>{
          // commit('setIsPageLoading', false, {root:true})
          this.buttonIsLoading=false;
        })
    },
    updateStatus(status='resolve'){
      this.buttonIsLoading=true;
      const formData = {
        issue_status: status
      }
      const issueItem = JSON.parse(JSON.stringify(this.issueItem));
      issueItem.issue_status = status;
      IssueApi.update(this.issueItem.id, formData)
        .then((response) => {
          if(response.data.success){
            this._setIssueItem(issueItem)
            this.$notify({
              text: `Issue ${status}`,
            });
          }
        })
        .catch((error) => {
          this.$notify({
            type: 'error',
            text: 'Oops, something went wrong. Try again later.',
          });
        })
        .then(()=>{
          // commit('setIsPageLoading', false, {root:true})
          this.buttonIsLoading=false;
        })
    },
    navigateEvent(eventId){
      window.scrollTo(0,0);
      this.setEventItem(eventId);
    }
  },
  computed: {
    ...mapGetters([
      'getActiveProjectId',
    ]),
    ...mapState('issues', [
      'issueItem',
      'currentEvent',
    ]),
    hasItems() {
      return typeof this.issueItem.id !== 'undefined';
    },
    hasWidgets(){
      return this.clientWidgetsData.length;
    },
    clientDetails(){
      return this.currentEvent.client;
    },
    userDetails(){
      return this.currentEvent.user;
    },
    hasClient(){
      return !isObjectEmpty( this.clientDetails ) && this.clientDetails !== '';
    },
    requestMethod(){
      return `${this.clientDetails.client_method}: ${this.clientDetails.client_url}`;
    },
    serverDetails(){
      return this.currentEvent.server;
    },
    stackTrace(){
      return this.currentEvent.stack_trace;
    },
    fileError(){
      const {stack_trace_error_file, stack_trace_error_line} = this.stackTrace;
      return `Line: ${stack_trace_error_line} – ${stack_trace_error_file}`;
    },
    projectDetails(){
      return this.issueItem.issue_project;
    },
    sidebarDetails(){
      const sidebarDetails = {};
      if(this.userDetails){
        sidebarDetails.User = {
          'UNIQUE': this.userDetails.user_unique,
        };
        if(!isObjectEmpty(this.userDetails.user_meta)){
          const userMeta = this.userDetails.user_meta;
          for (var key in userMeta) {
            if (!userMeta.hasOwnProperty(key)) continue;
            sidebarDetails.User[key.toUpperCase()] = userMeta[key]
          }
        }
      }

      sidebarDetails.Event = {
        'ID': `${this.projectDetails.project_id}:${this.currentEvent.id}`,
        'Environment': this.currentEvent.event_environment,
        'Captured' : renderEventHtml(this.currentEvent.created_at),
      };

      sidebarDetails.Issue = {
        'Status': this.issueItem.issue_status,
        'Project': this.projectDetails.project_name,
        'Counts': this.issueItem.issue_counts || 1,
        'Users': this.issueItem.issue_users || 0,
        'Latest event' : renderEventHtml(this.issueItem.updated_at),
        'First record' : renderEventHtml(this.issueItem.created_at),
      };

      if( this.serverDetails ){
        sidebarDetails.Server = {
          'Server Name': this.serverDetails.server_name,
          'Server OS': this.serverDetails.server_os,
          'OS Version': this.serverDetails.server_os_version,
          'Server Runtime': this.serverDetails.server_runtime,
        }
      }
      return sidebarDetails;
    },
    nextEventId(){
      const eventIds = this.issueItem.event_ids,
        currentEventIdx = eventIds.indexOf(this.currentEvent.id);
      if(typeof eventIds[currentEventIdx - 1] !== 'undefined') return eventIds[currentEventIdx - 1];
      return '';
    },
    prevEventId(){
      const eventIds = this.issueItem.event_ids,
        currentEventIdx = eventIds.indexOf(this.currentEvent.id);
      if(typeof eventIds[currentEventIdx + 1] !== 'undefined') return eventIds[currentEventIdx + 1];
      return '';
    }
  },
  mounted() {
    const {projectId, id } = this.$route.params;
    this.setIssueItem(id);
  },
  watch:{
    currentEvent(){
      this.initWidgets();
    }
  },
}
</script>

<style lang="scss">
#issues-page-item{

  .section-spacing{
    padding-top: 20px;
    padding-bottom: 30px;
  }

  .issues-client-tags{
    font-size: 0.875em;
  }
  .timestamp{
    display: flex;
    flex-direction: column;

    .event-time{
      font-size: 0.688em;
    }
  }

  .table{
    td{
      min-width: 150px;
      word-break: break-word;
    }
  }

  .client-widgets {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;

    .widget {
      width: 100%;
      max-width: calc(100% / 2 - 30px);
      margin: 10px;
    }
  }
  .action-buttons{
    float:right;
  }

  .issues-meta{
    flex-wrap: wrap;
    .column{
      min-width: calc(100% / 2);
    }

    @media only screen and (min-width: 1080px) {
      .column{
        max-width: calc(100% / 2);
      }
    }
  }
  .issue-action-buttons{
    float: right;
  }
}
</style>
