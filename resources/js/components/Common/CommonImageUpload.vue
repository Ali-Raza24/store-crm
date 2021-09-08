<script>
export default {
  name: 'ImageUpload', // vue component name
  data() {
    return {
      error: '',
      files: [],
      dropped: 0,
      Imgs: []
    }
  },
  props: {
    max: Number,
    uploadMsg: String,
    maxError: String,
    fileError: String,
    id: {
      type: String
    },
    multiple: {
      type: Boolean,
      default: false
    },
    showLabel: {
      type: Boolean,
      default: false
    },
    name: {
      type: String,
      default: 'images[]'
    },
    image_placeholder: {
      type: String,
      default: ''
    },
    styleImg: {
      type: String,
      default: ''
    },
    allowAddMore: {
      type: Boolean,
      default: false
    },
    placeholderWidth: {
      type: String,
      default: 'true'
    },
    placeholderHeight: {
      type: String,
      default: '100%'
    },
    uploadBtn: {
      type: Boolean,
      default: false
    },
    roundImage: {
      type: Boolean,
      default: false
    },
    deleteClass: {
      type: String,
      default: 'delete'
    }
  },
  methods: {
    dragOver() {
      this.dropped = 2
    },
    dragLeave() {},
    drop(e) {
      let status = true

      e.dataTransfer.files.forEach((file) => {
        if (file.type.startsWith('image') === false) status = false
      })
      if (status == true) {
        if (
          this.$props.max &&
          e.dataTransfer.files.length + this.files.length > this.$props.max
        ) {
          this.error = this.$props.maxError
            ? this.$props.maxError
            : `Maximum files is` + this.$props.max
        } else {
          this.files.push(...e.dataTransfer.files)
          this.previewImgs()
        }
      } else {
        this.error = this.$props.fileError
          ? this.$props.fileError
          : `Unsupported file type`
      }
      this.dropped = 0
    },
    append() {
      this.$refs.uploadInput.click()
    },
    readAsDataURL(file) {
      return new Promise(function(resolve, reject) {
        let fr = new FileReader()
        fr.onload = function(e) {
          resolve(fr.result)
        }
        fr.onerror = function() {
          reject(fr)
        }
        fr.readAsDataURL(file)
      })
    },
    deleteImg(index) {
      this.Imgs.splice(index, 1)
      this.files.splice(index, 1)
      this.$emit('change', this.files)
      this.$refs.uploadInput.value = null
    },
    previewImgs(event) {
      if (
        this.$props.max &&
        event &&
        event.currentTarget.files.length + this.files.length > this.$props.max
      ) {
        this.error = this.$props.maxError
          ? this.$props.maxError
          : `Maximum files is` + this.$props.max
        return
      }
      if (this.dropped == 0) this.files.push(...event.currentTarget.files)
      this.error = ''
      this.$emit('change', this.files)
      let readers = []

      if (!this.files.length) return

      for (let i = 0; i < this.files.length; i++) {
        readers.push(this.readAsDataURL(this.files[i]))
      }

      Promise.all(readers).then((values) => {
        this.Imgs = values
      })
    }
  },
  computed: {
    imageStyle() {
      let style = ''
      if (this.placeholderWidth === 'true') {
        style += ' img-width-100 '
      }
      if (this.roundImage === true) {
        style += ' radius '
      }
      return style
    }
  }
}
</script>

<template>
  <div
    class="container"
    @dragover.prevent="dragOver"
    @dragleave.prevent="dragLeave"
    @drop.prevent="drop($event)"
  >
    <div class="drop" v-show="dropped == 2"></div>
    <!-- Error Message -->
    <div v-show="error" class="error">
      {{ error }}
    </div>
    <!-- To inform user how to upload image -->
    <div v-show="Imgs.length == 0" class="beforeUpload" :style="styleImg">
      <input
        :id="id"
        data-upload="image"
        :name="name"
        type="file"
        style="z-index: 1;"
        accept="image/jpeg, image/png, image/gif"
        ref="uploadInput"
        @change="previewImgs"
        :multiple="multiple"
      />
      <span v-if="image_placeholder">
        <img
          :src="image_placeholder"
          :class="imageStyle"
          :style="'height:' + placeholderHeight"
          alt=""
        />
      </span>
      <svg
        class="icon"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        v-else
      >
        <title>Upload Image</title>
        <g id="Upload_Image" data-name="Upload Image">
          <g id="_Group_" data-name="&lt;Group&gt;">
            <g id="_Group_2" data-name="&lt;Group&gt;">
              <g id="_Group_3" data-name="&lt;Group&gt;">
                <circle
                  id="_Path_"
                  data-name="&lt;Path&gt;"
                  cx="18.5"
                  cy="16.5"
                  r="5"
                  style="
                    fill: none;
                    stroke: #303c42;
                    stroke-linecap: round;
                    stroke-linejoin: round;
                  "
                />
              </g>
              <polyline
                id="_Path_2"
                data-name="&lt;Path&gt;"
                points="16.5 15.5 18.5 13.5 20.5 15.5"
                style="
                  fill: none;
                  stroke: #303c42;
                  stroke-linecap: round;
                  stroke-linejoin: round;
                "
              />
              <line
                id="_Path_3"
                data-name="&lt;Path&gt;"
                x1="18.5"
                y1="13.5"
                x2="18.5"
                y2="19.5"
                style="
                  fill: none;
                  stroke: #303c42;
                  stroke-linecap: round;
                  stroke-linejoin: round;
                "
              />
            </g>
            <g id="_Group_4" data-name="&lt;Group&gt;">
              <polyline
                id="_Path_4"
                data-name="&lt;Path&gt;"
                points="0.6 15.42 6 10.02 8.98 13"
                style="
                  fill: none;
                  stroke: #303c42;
                  stroke-linecap: round;
                  stroke-linejoin: round;
                "
              />
              <polyline
                id="_Path_5"
                data-name="&lt;Path&gt;"
                points="17.16 11.68 12.5 7.02 7.77 11.79"
                style="
                  fill: none;
                  stroke: #303c42;
                  stroke-linecap: round;
                  stroke-linejoin: round;
                "
              />
              <circle
                id="_Path_6"
                data-name="&lt;Path&gt;"
                cx="8"
                cy="6.02"
                r="1.5"
                style="
                  fill: none;
                  stroke: #303c42;
                  stroke-linecap: round;
                  stroke-linejoin: round;
                "
              />
              <path
                id="_Path_7"
                data-name="&lt;Path&gt;"
                d="M19.5,11.6V4A1.5,1.5,0,0,0,18,2.5H2A1.5,1.5,0,0,0,.5,4V15A1.5,1.5,0,0,0,2,16.5H13.5"
                style="
                  fill: none;
                  stroke: #303c42;
                  stroke-linecap: round;
                  stroke-linejoin: round;
                "
              />
            </g>
          </g>
        </g>
      </svg>

      <p class="mainMessage" v-if="showLabel">
        {{ uploadMsg ? uploadMsg : 'Click to upload or drop your images here' }}
      </p>
    </div>
    <div class="imgsPreview" v-show="Imgs.length > 0">
      <div
        class="imageHolder"
        :style="styleImg"
        v-for="(img, i) in Imgs"
        :key="i"
      >
        <img :src="img" :style="styleImg" :class="imageStyle" />
        <button class="upload" v-if="uploadBtn === true">
          <i class="fa fa-upload"></i>
        </button>
        <span :class="deleteClass" style="color: white" @click="deleteImg(--i)">
          <svg
            class="icon"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
            />
          </svg>
        </span>
        <div
          class="plus"
          @click="append"
          v-if="++i == Imgs.length && allowAddMore"
        >
          +
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  width: 100%;
  height: 100%;
  /*background: #f7fafc;*/
  /*border: 0.5px solid #a3a8b1;*/
  /*border-radius: 10px;*/
  position: relative;
  cursor: pointer;
}
.drop {
  width: 100%;
  height: 100%;
  top: 0;
  /*border-radius: 10px;*/
  position: absolute;
  background-color: #f4f6ff;
  left: 0;
  border: 3px dashed #a3a8b1;
}
.error {
  text-align: center;
  color: red;
  font-size: 15px;
}
.beforeUpload {
  position: relative;
  text-align: center;
}
.beforeUpload input {
  width: 100%;
  margin: auto;
  height: 100%;
  opacity: 0;
  position: absolute;
  background: red;
  display: block;
}
.beforeUpload input:hover {
  cursor: pointer;
}
.img-width-100 {
  width: 100%;
}
.beforeUpload .icon {
  width: 150px;
  margin: auto;
  display: block;
}
.imgsPreview .imageHolder {
  width: 100%;
  height: 100%;
  /*background: #fff;*/
  position: relative;
  display: inline-block;
}

.imgsPreview .imageHolder img {
  /*object-fit: cover;*/
  width: 100%;
  height: 100%;
}

/*.imgsPreview .imageHolder img */
.radius {
  border-radius: 100% !important;
}

.imgsPreview .imageHolder .delete {
  position: absolute;
  top: 4px;
  right: 4px;
  width: 29px;
  height: 29px;
  color: #fff;
  background: red;
  border-radius: 50%;
}

.imgsPreview .imageHolder .delete2 {
  position: absolute;
  top: -10px;
  right: -10px;
  width: 20px;
  height: 20px;
  color: #fff;
  background: red;
  border-radius: 50%;
}

.imgsPreview .imageHolder .delete:hover,
.imgsPreview .imageHolder .delete2:hover {
  cursor: pointer;
}
.imgsPreview .imageHolder .delete .icon,
.imgsPreview .imageHolder .delete2 .icon {
  width: 66%;
  height: 66%;
  display: block;
  margin: 4px auto;
}

.imgsPreview .imageHolder .plus {
  color: #2d3748;
  background: #f7fafc;
  border-radius: 50%;
  font-size: 21pt;
  height: 30px;
  width: 30px;
  text-align: center;
  border: 1px dashed;
  line-height: 23px;
  position: absolute;
  right: -42px;
  bottom: 43%;
}
.plus:hover {
  cursor: pointer;
}
.imgsPreview .upload {
  height: 33px;
  width: 33px;
  background: #140a30;
  color: #fff;
  text-align: center;
  line-height: 33px;
  position: absolute;
  bottom: 10px;
  left: -15px;
  display: inline-block;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
  -webkit-transition: all 0.3s ease-in 0.1s;
  -o-transition: all 0.3s ease-in 0.1s;
  -moz-transition: all 0.3s ease-in 0.1s;
  transition: all 0.3s ease-in 0.1s;
  outline: none;
  text-decoration: none;
  border: 1px solid #140a30;
}
.plus:hover {
  cursor: pointer;
}
</style>
