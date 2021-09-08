<template>
  <div :class="'col-' + column + ' ' + extraClass">
    <div class="counter-box" :class="borderColor + '-border'">
      <div class="counter-flexer">
        <div class="counter-col">
          <p class="dark-one font-weight-400">
            {{ title }}
          </p>
          <h2
            class="font-weight-700"
            :class="textColor + '-text'"
            :data-to="total"
          >
            <slot name="currency"></slot> 0
          </h2>
        </div>
        <div class="counter-col" v-if="icon">
          <img
            alt=""
            :src="url + '/business_assets/images/' + icon"
            class="counter-icon"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CounterBox',
  props: {
    url: {
      type: String,
      default: ''
    },
    column: {
      type: String,
      default: '3'
    },
    extraClass: {
      type: String,
      default: ''
    },
    borderColor: {
      type: String,
      default: 'primary'
    },
    title: {
      type: String,
      default: ''
    },
    textColor: {
      type: String,
      default: 'primary'
    },
    total: {
      type: String,
      default: ''
    },
    icon: {
      type: String,
      default: ''
    }
  }
};
</script>

<style scoped></style>
