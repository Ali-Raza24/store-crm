<template>
  <transition name="fade">
    <div v-if="isVisible" class="popup-modal">
      <div class="body">
        <slot></slot>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'PopupModal',

  data: () => ({
    isVisible: false
  }),

  methods: {
    open() {
      this.isVisible = true;
    },
    close() {
      this.isVisible = false;
    }
  }
};
</script>

<style scoped>
.fade-enter-active {
  transition: opacity 0.3s;
}
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter {
  opacity: 0;
}
.fade-leave-to {
  opacity: 0;
}
.popup-modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1050;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100vh;
  overflow: hidden;
  outline: 0;
  background: rgba(0, 0, 0, 0.5);
}
.body {
  background: #fff;
  border-radius: 5px;
  box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
  max-width: 480px;
  margin-left: auto;
  margin-right: auto;
  padding: 1rem;
}
</style>
