<template lang="pug">
#base-container(
  class="container is-fluid"
)

</template>

<script>
import { mapGetters, mapMutations, mapState, mapActions } from 'vuex';
export default {
  name: '',
  props: {
    string: { type: String, default: '' },
    number: { type: Number, default: 0 },
    array: { type: Array, default: () => [] },
    object: { type: Object, default: () => ({}) },
    boolean: { type: Boolean, default: false },
  },
  data() {
    return {};
  },
  beforeMount(){},
  mounted(){},
  methods: {},
  computed: {},
  watch: {},
};
</script>

<style lang="scss">
</style>
