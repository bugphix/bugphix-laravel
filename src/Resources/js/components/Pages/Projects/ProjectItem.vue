<template lang="pug">
.container(id="projects-page-item")
  template(v-if="!hasItems") Loading...

  template(v-else)
    .project-toggle-active
      .switch-wrapper
        span Activate project
        label.switch
          input(
            type="checkbox"
            :checked="isActive"
            v-model="formData.is_active"
          )
          span.slider.round

    h2.title.is-4 Project information

    .card.card-margin
      .card-content
        .field
          label.label Project name
          .control
            input.input(
              type="text"
              v-model="formData.project_name"
            )

        //- .field Platform
        //-   .control
        //-     input.input(
        //-       type="text"
        //-       v-model="formData.project_platform"
        //-     )

        .field
          label.label API Token
          .control
            input.input(
              type="text"
              v-model="formData.project_token"
            )

        .buttons.save-button
          button.button.is-primary(
            @click="saveProject"
          )
            span.icon
              i.mdi.mdi-floppy
            span Save

    .card.card-margin
      .card-content
        ProjectMeta(
          v-if="projectId"
          :projectItem="projectItem"
        )

</template>

<script>

import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';
import { isObjectEmpty, renderEventHtml } from '@/assets/scripts/utilities';
import ProjectApi from '@/services/ProjectApi';

// child components
import ProjectMeta from './children/ProjectMeta.vue';

export default {
  name: 'ProjectsItem',
  components: {
    ProjectMeta,
  },
  data() {
    return {
      projectId: '',
      projectToken: '',
      formSending: '',
      // apiGateWay: '',
      formData: {
        project_name: '',
        project_platform: '',
        is_active: false,
      },
    }
  },
  methods: {
    ...mapActions([
      'setActiveProject',
    ]),
    ...mapActions('projects',[
      'setProjectItem',
    ]),
    saveProject(){
      ProjectApi.update(this.projectId, this.formData)
        .then((response) => {
          if(response.data.success){
            this.formSending = false;
            this.$notify({
              text: response.data.message
            });

            if(this.projectId === this.getActiveProjectId) this.setActiveProject(this.projectId);
          }
        })
        .catch((error) => {
          setTimeout(()=>{
            this.saveProject();
          }, 2000)
        })
    }
  },
  computed: {
    ...mapGetters([
      'getActiveProjectId',
    ]),
    ...mapState('projects', [
      'projectItem',
    ]),
    hasItems() {
      return typeof this.projectItem.project_id !== 'undefined';
    },
    isActive(){
      return this.projectItem.is_active;
    },
    apiGateWay(){
      return `${window.Bugphix.dsn}/${this.projectId}/${this.projectItem.project_token}`;
    },
    projectStatus() {
      return this.isActive ? 'Active' : 'Deactivated'
    },
    sidebarDetails(){
      const sidebarDetails = {};
      sidebarDetails.Details = {
        'Current status': this.projectStatus,
        'Project ID': `${this.projectId}`,
        'DSN' : this.apiGateWay,
        'Issues': '1,500 issues recorded',
        'Events': '105k events recorded',
        'Updated': this.renderEventHtml(this.projectItem.updated_at),
        'Created': this.renderEventHtml(this.projectItem.created_at),
      };
      return sidebarDetails;
    }
  },
  mounted() {
    const {projectId} = this.$route.params;
    this.setProjectItem(projectId);
  },
  watch:{
    projectItem() {
      this.formData = this.projectItem;
      this.projectId = this.projectItem.project_id;
      this.projectToken = this.projectItem.project_token;
      console.log(this.projectItem)
    }
  },
}
</script>

<style lang="scss">
#projects-page-item{
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
  .project-toggle-active{
    float: right;
  }
  .save-button{
    margin-top: 20px;
  }
}
</style>
