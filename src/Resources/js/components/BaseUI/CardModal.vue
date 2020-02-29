<template lang="pug">
.modal(
  v-if="show"
  :class="show ? 'is-active':''"
)
  .modal-background
  .modal-card
    header.modal-card-head(
      v-if="title"
    )
      p.modal-card-title {{ title }}
      button.delete(
        v-if="closeButton"
        aria-label="close"
        @click="$emit('close')"
      )

    .modal-card-body(ref="modalContent")
      slot(:modalContent="this.$refs.modalContent")

    .modal-card-foot(
      v-if="confirmButton || cancelButton"
    )
      .button.is-primary(
        v-if="confirmButton"
        @click="$emit('confirm')"
      ) {{confirmButtonText}}

      .button(
        v-if="cancelButton"
        @click="$emit('cancel')"
      ) {{cancelButtonText}}

</template>

<script>
export default{
  name: 'BuckleBugCardModal',
  props: {
    closeButton: {type: Boolean, default: true},
    show: {type: Boolean, default: false},
    title: {type: String, default: ''},
    content: {type: String, default: ''},
    confirmButton: {type: Boolean, default: true},
    cancelButton: {type: Boolean, default: true},
    confirmButtonText: {type: String, default: 'Confirm'},
    cancelButtonText: {type: String, default: 'Cancel'},
  },
  computed: {

  },
  methods: {}
}
</script>
