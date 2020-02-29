<template lang="pug">
.container(id="user-page-item")
  template(v-if="!hasItems") Loading...

  template(v-else)
    h2.title.is-4 User information

    .card.card-margin
      .card-content
        .table-container
          table.table.is-bordered.is-striped.is-fullwidth
            tbody
              tr
                td Unique
                td {{userItem.user_unique}}
              tr
                td Info
                td {{userItem.user_info}}

    .card.card-margin
      .card-content
        h3.subtitle.is-5 User Meta
        .table-container
          table.table.is-bordered.is-striped.is-fullwidth
            tbody
              tr(
                v-for="(value, index) in userItem.user_meta"
                :key="`user-details-${index}`"
              )
                td {{index}}
                td {{value}}

</template>

<script>
import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';
import { isObjectEmpty, renderEventHtml } from '@/assets/scripts/utilities';

export default {
  name: 'UserItem',
  methods: {
    ...mapActions('users',[
      'setUserItem',
    ]),
  },
  computed: {
    ...mapState('users', [
      'userItem',
    ]),
    hasItems() {
      return typeof this.userItem.user_unique !== 'undefined';
    },
    hasUserMeta() {
      return typeof this.userItem.user_meta !== 'undefined' && ! isObjectEmpty(this.userItem.user_meta);
    },
  },
  mounted() {
    const {userId} = this.$route.params;
    this.setUserItem(userId);
  },
  watch:{},
};
</script>

<style lang="scss">
</style>
