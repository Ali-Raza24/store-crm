<template>
  <renderless-laravel-vue-pagination
    :data="data"
    :limit="limit"
    :show-disabled="showDisabled"
    :size="size"
    :align="align"
    v-on:pagination-change-page="onPaginationChangePage"
  >
    <ul
      class="pagination"
      :class="{
        'pagination-sm': size == 'small',
        'pagination-lg': size == 'large',
        'justify-content-center': align == 'center',
        'justify-content-end': align == 'right'
      }"
      v-if="computed.total > computed.perPage"
      slot-scope="{
        data,
        limit,
        showDisabled,
        size,
        align,
        computed,
        prevButtonEvents,
        nextButtonEvents,
        pageButtonEvents
      }"
    >
      <li class="page-item" :class="{ ['disabled']: !computed.prevPageUrl }">
        <a
          class="page-link"
          href="#"
          aria-label="Previous"
          :tabindex="!computed.prevPageUrl && -1"
          v-on="prevButtonEvents"
        >
          <slot name="prev-nav">
            <span aria-hidden="true"
              ><img
                :src="
                  $parent.$data.base_url + '/business_assets/images/arrow-l.png'
                "
                v-if="!computed.prevPageUrl"
                alt=""
              /><img
                style="transform: rotate(180deg)"
                :src="
                  $parent.$data.base_url + '/business_assets/images/arrow-r.png'
                "
                v-else
                alt=""
              />
            </span>
            <span class="sr-only">Previous</span>
          </slot>
        </a>
      </li>

      <li
        class="page-item"
        v-for="(page, key) in computed.pageRange"
        :key="key"
      >
        <a
          class="page-link"
          :class="{ ['active']: page == computed.currentPage }"
          href="#"
          v-on="pageButtonEvents(page)"
        >
          {{ page }}
          <span class="sr-only" v-if="page == computed.currentPage"
            >(current)</span
          >
        </a>
      </li>

      <li class="page-item" :class="{ disabled: !computed.nextPageUrl }">
        <a
          class="page-link"
          href="#"
          aria-label="Next"
          :tabindex="!computed.nextPageUrl && -1"
          v-on="nextButtonEvents"
        >
          <slot name="next-nav">
            <span aria-hidden="true"
              ><img
                :src="
                  $parent.$data.base_url + '/business_assets/images/arrow-r.png'
                "
                v-if="computed.nextPageUrl"
                alt=""
              />
              <img
                style="transform: rotate(180deg)"
                :src="
                  $parent.$data.base_url + '/business_assets/images/arrow-l.png'
                "
                v-else
                alt=""
              />
            </span>
            <span class="sr-only">Next</span>
          </slot>
        </a>
      </li>
    </ul>
  </renderless-laravel-vue-pagination>
</template>

<script>
import RenderlessLaravelVuePagination from './RenderlessLaravelVuePagination.vue'

export default {
  props: {
    data: {
      type: Object,
      default: () => {}
    },
    limit: {
      type: Number,
      default: 0
    },
    showDisabled: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      default: 'default',
      validator: (value) => {
        return ['small', 'default', 'large'].indexOf(value) !== -1
      }
    },
    align: {
      type: String,
      default: 'left',
      validator: (value) => {
        return ['left', 'center', 'right'].indexOf(value) !== -1
      }
    }
  },

  methods: {
    onPaginationChangePage(page) {
      this.$emit('pagination-change-page', page)
    }
  },

  components: {
    RenderlessLaravelVuePagination
  }
}
</script>
