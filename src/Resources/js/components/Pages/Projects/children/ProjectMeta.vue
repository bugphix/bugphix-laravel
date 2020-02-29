<template lang="pug">
div.table-container(
  v-if="hasItems"
)
  h3.subtitle.is-5 Project details

  table.table.is-fullwidth.is-striped
    tbody
      tr
        td Current status
        td {{projectStatus}}
      tr
        td DSN
        td.project-dsn
          input(
            type="hidden"
            id="copy-clipboard-dsn"
            :value="projectDSN"
          )
          span.link(
            :title="projectDSN"
          ) {{projectDSN}}
          button.button.is-small.is-primary(
            @click="copyDsn"
          ) Copy
      tr
        td Issues
        td {{projectIssues}}
      tr
        td Events
        td {{projectEvents}}
      tr
        td Updated
        td(v-html="projectUpdated")
      tr
        td Created
        td(v-html="projectCreated")
</template>

<script>

import { isObjectEmpty, renderEventHtml, nFormat } from '@/assets/scripts/utilities';

export default {
  name: 'ProjectMeta',
  props: {
    projectItem: { type: Object, default: () => {} },
  },
  // data() {
  //     return {};
  // },
  // beforeMount(){},
  // mounted(){},
  methods: {
    copyDsn(){

      let copyClipboardDsn = document.querySelector('#copy-clipboard-dsn')
        copyClipboardDsn.setAttribute('type', 'text')
        copyClipboardDsn.select();

      let isCopied = false;

        try {
          isCopied = document.execCommand('copy');
        } catch (err) {
          isCopied = false;
        }

        if(isCopied){
          this.$notify({
            text: 'DSN copied!'
          });
        }
        else{
          this.$notify({
            type: 'error',
            text: 'Sorry unable to copy, please to manually highlight and copy the link'
          });
        }

        /* unselect the range */
        copyClipboardDsn.setAttribute('type', 'hidden')
        window.getSelection().removeAllRanges()

    },
  },
  computed: {
    hasItems(){
      return ! isObjectEmpty(this.projectItem);
    },
    projectStatus(){
      return this.projectItem.is_active ? 'Active' : 'Deactivated';
    },
    projectDSN(){
      return `${window.Bugphix.dsn_slug}/${this.projectItem.project_id}/${this.projectItem.project_token}`;
    },
    projectIssues(){
      return nFormat(this.projectItem.issues) + ' issues recorded';
    },
    projectEvents(){
      return nFormat(this.projectItem.events) + ' events recorded';
    },
    projectUpdated(){
      return renderEventHtml(this.projectItem.updated_at);
    },
    projectCreated(){
      return renderEventHtml(this.projectItem.created_at);
    }

  },
  // watch: {},
};
</script>

<style lang="scss" scoped>
.project-dsn{
  display: flex;
  align-items: center;

  .button{
    margin-left: 20px;
  }
}
</style>
