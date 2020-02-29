<template lang="pug">
.box.is-shadowless
  article.media
    .media-left
      span.icon.is-large
        i.mdi.mdi-36px(
          :class="icon"
        )
    .media-content
      .content
        p(
          v-html="content"
        )
</template>

<script>

export default {
  name: 'ClientWidgets',
  props: {
  content: { type: String, default: '' },
  icon: { type: String, default: '' },
  },
  // data() {
  //     return {};
  // },
  // beforeMount(){},
  // mounted(){},
  // methods: {},
  // computed: {},
  // watch: {},
};
</script>
<style lang="scss" scoped>
.box{
  border: 1px solid #ccc;
}
</style>
