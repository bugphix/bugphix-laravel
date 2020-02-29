<template lang="pug">
div.table-container(
  v-if="hasItems"
)
  h3.subtitle.is-5(v-if="title") {{title}}

  table.table.is-fullwidth.is-striped.is-bordered
    tbody
      tr(
        v-for="(value, index) in items"
        :key="index"
      )
        td {{index}}:
        td(
          v-html="value"
        )
</template>

<script>

import { isObjectEmpty } from '@/assets/scripts/utilities';

export default {
  name: 'IssuesMeta',
  props: {
    title: { type: String, default: '' },
    items: { type: Object, default: () => {} },
  },
  // data() {
  //     return {};
  // },
  // beforeMount(){},
  // mounted(){},
  // methods: {},
  computed: {
    hasItems(){
      return ! isObjectEmpty(this.items);
    }
  },
  // watch: {},
};
</script>

<style lang="scss" scoped></style>
