<template lang="pug">
BPhixCardModal(
  :show="showCreateProjectModal"
  title="Create new project"
  :closeButton="false"
  @confirm="createproject"
  @cancel="cancel"
)

  .field
    label.label Project name
    .control
      input.input(
        type="text"
        placeholder="Enter project name"
        v-model="projectName"
        :disabled="formSending"
      )

  //- .field
  //-   label.label Project platform
  //-   .control
  //-     .select
  //-       select
  //-         option Laravel
  //-         option VueJS

</template>

<script>

import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';
import BPhixCardModal from '@BaseUI/CardModal'
import ProjectApi from '@/services/ProjectApi';

export default {
  name: 'CreateProjectModal',
  props: {
    show: {type: Boolean, default: false},
  },
  data (){
    return {
      projectName: '',
      formSending: false,
    }
  },
  components:{
    BPhixCardModal
  },
  methods:{
    ...mapMutations('projects',[
      'setShowCreateProjectModal',
    ]),
    ...mapActions('projects',[
      'createProject',
      'setProjectList',
    ]),
    createproject(){

      this.formSending = true;
      const formData = {
        project_name : this.projectName,
        project_platform: 'laravel',
      };

      ProjectApi.create(formData)
        .then((response) => {
          if(response.data.success){
            this.setProjectList(1);
            this.setShowCreateProjectModal(false);
            this.formSending = false;
            this.projectName = '';
            const {project_id, project_name} = response.data.results;
            this.$notify({
              text: `${project_id} – ${project_name} created`
            });
          }
        })
        .catch((error) => {
          this.$notify({
            text: 'Sorry something went wrong, please try again.'
          });
        })
    },
    cancel(){
      this.setShowCreateProjectModal(false);
    }
  },
  computed: {
    ...mapState('projects',[
      'showCreateProjectModal',
    ]),
  },
  // watch: {},
};
</script>
