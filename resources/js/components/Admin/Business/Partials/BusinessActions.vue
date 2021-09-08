<template>
  <div class="selected-item-panel">
    <div class="selected-item">
      <ul class="selected-list">
        <li>
          <div class="item-show">
            <span>
              <img
                :src="url + '/admin_assets/images/close-wgite.png'"
                alt="image"
              />
            </span>
            <p class="mobile-hide">2 Items Selected</p>
          </div>
        </li>
        <li>
          <a href="javascript:void(0)" class="item-btn">
            <span>Delete Business</span>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)" class="item-btn">
            <span>Duplicate Business</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BusinessActions',
  props: {
    url: {
      type: String,
      default: ''
    }
  }
};
</script>

<style scoped></style>
