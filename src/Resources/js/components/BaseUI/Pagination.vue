<template lang="pug">
nav(
  v-if="pagesNumber.length > 1"
  class="pagination is-small"
  role="navigation"
  aria-label="pagination"
)
  ul.pagination-list
    li
      a(
        class="pagination-previous"
        :disabled="pagination.current_page <= 1"
        @click.prevent="changePage(pagination.current_page - 1)"
      )
        i.mdi.mdi-chevron-left

    li(
      v-for="(page, index) in pagesNumber"
      :key="`pagination-${index}`"
    )
      a.pagination-link(
        :class="{'is-current': page == pagination.current_page}"
        @click.prevent="changePage(page)"
      ) {{ page }}

    li
      a(
        class="pagination-next"
        :disabled="pagination.current_page >= pagination.last_page"
        @click.prevent="changePage(pagination.current_page + 1)"
      )
        i.mdi.mdi-chevron-right
</template>

<script>
export default{
  name: 'BuckleBugPagination',
  props: {
    pagination: {type: [Object, Array], required: true},
    offset: {type: Number, default: 3}
  },
  computed: {
    pagesNumber() {

      if (!this.pagination.to) return [];

      let from = this.pagination.current_page - this.offset;

      if (from < 1)  from = 1;

      let to = from + (this.offset * 2);
      if (to >= this.pagination.last_page) to = this.pagination.last_page;

      let pagesArray = [];
      for (let page = from; page <= to; page++) {
        pagesArray.push(page);
      }

      return pagesArray;
    }
  },
  methods: {
    changePage(page) {

      if( page === this.pagination.current_page || page === 0 || page > this.pagination.last_page ) return;
      this.pagination.current_page = page;
      this.$emit('paginate');
    }
  }
}
</script>
