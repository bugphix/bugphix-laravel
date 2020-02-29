<template lang="pug">
.section-spacing.issues-exception-details
  h3.subtitle.is-5 Exception:

  p.issue-file-link(
    :title="fileError"
  ) {{fileError}}

  br

  .buttons.has-addons
    button.button.is-small(
      :class="isFullLog ? '' : 'is-primary is-selected'"
      @click="isFullLog = false"
    ) Excerpt

    button.button.is-small(
      :class="!isFullLog ? '' : 'is-primary is-selected'"
      @click="isFullLog = true"
    ) Full log

  template(
    v-if="!isFullLog"
  )
    .box
      article.media
        .media-left
          span.icon.is-large
            i.mdi.mdi-36px.mdi-information-outline

        .media-content
          .content
            p {{errorMessage}}

    ol.stacktrace-prettify(
      :start="startLine"
    )
      li(
        v-for="(line, index) in stackTraceArray"
        :class="(startLine + index) === errorLine ? 'is-target-line' : ''"
        :key="index"
      )
        .code-line {{line}}



  template(v-else)
    p.exception-full-log {{fullLog}}
</template>

<script>

export default {
  name: 'Exception',
  props: {
    errorMessage: { type: String, default: '' },
    fileError: { type: String, default: '' },
    errorLine: { type: Number, default: 1 },
    startLine: { type: Number, default: 1 },
    stackTraceArray: { type: Array, default: () => [] },
    fullLog: { type: String, default: '' },
  },
  data() {
  return {
    isFullLog: false,
  };
  },
  // beforeMount(){},
  // mounted(){},
  // methods: {},
  // computed: {},
  // watch: {},
};
</script>

<style lang="scss" scoped>

.exception-full-log{
  font-size: 0.875em;
  line-height: 1.875em;
  white-space: pre-line;
  font-family: 'Consolas', 'Helvatica', 'sans-serif';
}

.stacktrace-prettify{
  font-size: 0.875em;
  margin: 20px 0;
  list-style-type: decimal-leading-zero;
  font-family: 'Consolas', 'Helvatica', 'sans-serif';
  padding-left: 40px;

  li{
    color: #909090;
    white-space: pre-wrap;
    padding-left: 5px;
    list-style-position: outside;

    .code-line{
      display: inline;
      margin-left: 15px;
    }

    &.is-target-line{
      background-color: #2979ff;
      padding: 10px 7px;
      .code-line{
        color: #fff;
      }
    }
  }
}

.issue-file-link{
  word-break: break-word;
}
</style>
