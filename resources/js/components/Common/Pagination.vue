<template>
  <ul class="pagination justify-content-center mt-3">
    <li class="page-item">
      <a class="page-link" href="javascript:void(0)" tabindex="-1">
        <img alt="" :src="url + '/business_assets/images/arrow-l.png'" />
      </a>
    </li>
    <li class="page-item">
      <a class="page-link active" href="javascript:void(0)">1</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="javascript:void(0)">2</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="javascript:void(0)">3</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="javascript:void(0)">4</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="javascript:void(0)">...</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="javascript:void(0)">
        <img alt="" :src="url + '/business_assets/images/arrow-r.png'" />
      </a>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'Pagination',
  props: {
    url: {
      type: String,
      default: ''
    }
  }
};
</script>

<style scoped></style>
