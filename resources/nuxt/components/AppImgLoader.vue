<template>
  <div class="IZ-file-uploader">
    <!-- v-validate="'image'" -->
    <form ref="imgLoaderForm">
      <input
        @change="onFileChange"
        :accept="accept"
        :multiple="multiple"
        type="file"
        ref="imgLoaderInput"
        hidden
      >
    </form>

    <template v-if="dataForUpload">
      <div v-if="percentCompleted" class="IZ-file-uploader__preview">


        <div class="IZ-file-uploader__percent-completed" slot="progress">
          {{ percentCompleted }} / 100%
        </div>


        <div v-if="!hidePreview" class="IZ-file-uploader__preview-gallery">
          <template v-if="dataForUpload.length >= 0">


            <!-- <div v-for="(file, key) in dataForUpload">
              <div class="img">
                <img :src="setPreview(file, key)" :alt="file.name" ref="file" />
              </div>
              <div style="text-align: center;">
                <b>{{ file.name }}</b>
                <i> ({{ formatBytes(file.size) }})</i>
              </div>
            </div> -->

            <div v-for="(file, key) in dataForUpload" :key="key" class="IZ-file-uploader__preview-gallery-item">
              <div class="IZ-file-uploader__preview-gallery-item-thumbail">
                <!-- :ref="`file${key}` -->
                <img :src="setPreview(file, key)" :alt="file.name" ref="file" />
              </div>
              <div class="IZ-file-uploader__preview-gallery-item-info">
                <b>{{ file.name }}</b>
                <i class="IZ-file-uploader__preview-gallery-item-info-size"> ({{ formatBytes(file.size) }})</i>
              </div>
            </div>


          </template>
          <template v-else>


            <!-- <div>
              <div class="img">
                <img :src="setPreview(dataForUpload)" :alt="dataForUpload.name" ref="file">
              </div>
              <div style="text-align: center;">
                <b>{{ dataForUpload.name }}</b>
                <i class="grey--text"> ({{ formatBytes(dataForUpload.size) }})</i>
              </div>
            </div> -->

            <div>
              <div class="IZ-file-uploader__preview-gallery-item-thumbail">
                <img :src="setPreview(dataForUpload)" :alt="dataForUpload.name" ref="file">
              </div>
              <div class="IZ-file-uploader__preview-gallery-item-info">
                <b>{{ dataForUpload.name }}</b>
                <i class="IZ-file-uploader__preview-gallery-item-info-size"> ({{ formatBytes(dataForUpload.size) }})</i>
              </div>
            </div>


          </template>
        </div>
      </div>
    </template>
    <div v-else slot="empty">
      <!-- <div style="text-align: center;">
        Не выбрано
      </div> -->
    </div>

    <!-- class="mb-4" -->
    <div id="slot-label">
      <span @click="inputTriger">
        <slot>
          <div class="IZ-file-uploader__slot-label-default">
            <button type="button" class="btn btn-primary">
              {{ dataForUpload ? 'Выбрать другое' : 'Выбрать' }}
            </button>
            <!-- <v-btn :loading="percentCompleted && percentCompleted != 100" color="primary">
              <v-icon left>add_a_photo</v-icon>
              {{ dataForUpload ? 'Выбрать другое' : 'Выбрать' }}
            </v-btn> -->
          </div>
        </slot>
      </span>
      <slot name="buttons" />
    </div>
  </div>
</template>

<script>
// import { msg } from '~/tools/helpers'

export default {
  props: {
    accept: {
      type: String,
      'default': '.jpg, .jpeg, .png'
    },
    multiple: {
      type: Boolean,
      'default': false
    },
    dataKey: {
      type: Object,
      'default': () => ({
        single: 'file',
        multiple: 'files[]'
      })
    },
    uploadUrl: {
      type: String,
      required: true
    },
    uploadAfterChange: {
      type: Boolean,
      'default': true
    },
    manualUpload: Object,
    reset: Boolean,
    hidePreview: {
      type: Boolean,
      'default': false
    }
  },
  data: () => ({
    dataForUpload: null,
    percentCompleted: null,
    formData: null
  }),
  methods: {
    async onFileChange (e) {
      let files = e.target.files || e.dataTransfer.files
      this.formData = new FormData()
      const key = this.dataKey[this.multiple ? 'multiple' : 'single']
      // single or multiple
      if (this.multiple) {
        this.dataForUpload = files
        for (let formDataItem of this.dataForUpload) {
          this.formData.append(key, formDataItem)
        }
      } else {
        this.dataForUpload = files[0]
        this.formData.append(key, this.dataForUpload)
      }

      if (this.dataForUpload) {
        const eventData = {
          formData: this.formData,
          dataForUpload: this.dataForUpload
        }

        let previews = []
        if (this.dataForUpload.length) {
          for (let file of this.dataForUpload) {
            const result = await this.getPreview(file)
            previews.push(result)
          }
          eventData.previews = previews
        } else {
          eventData.preview = await this.getPreview(this.dataForUpload)
        }

        this.$emit('change', eventData)
        // console.log(this.dataForUpload)
        // console.log(formData.getAll(key))
        if (this.uploadAfterChange) {
          await this.upload(this.formData)
        }
      }
    },
    async upload (config = {}) {
      try {
        const data = await this.$axios.$post(this.uploadUrl, this.formData, {
          onUploadProgress: ({ loaded, total }) => {
            this.percentCompleted = Math.floor((loaded * 100) / total) // TODO loaded * 100 / total

            this.$emit('progress', {
              loaded,
              total,
              percent: this.percentCompleted
            })
          },
          ...config
        })

        this.$emit('done', data)
      } catch ({ response }) {
        this.$emit('catch', response)
        console.error(response)
      }

      this.resetForm()
    },
    inputTriger () {
      this.$refs.imgLoaderInput.click()
    },
    formatBytes (bytes, dm = 2) {
      if (bytes === 0) {
        return '0 Bytes'
      }
      const k = 1024
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
      const i = Math.floor(Math.log(bytes) / Math.log(k))

      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i]
    },
    async setPreview (file, key) {
      const ref = key ? this.$refs[`file`][key] : this.$refs[`file`]
      if (ref) {
        // default image
        ref.setAttribute('src', 'https://www.kodingkingdom.com/home/wp-content/themes/highstand/assets/images/default.jpg')
        const result = await this.getPreview(file)
        ref.setAttribute('src', result)
      }
    },
    async getPreview (file) {
      const reader = new FileReader()

      reader.readAsDataURL(file)
      const preview = await new Promise(resolve => {
        reader.onload = () => {
          resolve(reader.result)
        }
      })

      // onload

      return preview
      // default image
      // return 'https://www.kodingkingdom.com/home/wp-content/themes/highstand/assets/images/default.jpg'
    },
    resetForm () {
      this.$refs.imgLoaderForm.reset()
      this.dataForUpload = this.formData = this.percentCompleted = null
    }
  },
  watch: {
    async manualUpload () {
      // if (this.manualUpload === null) {
      //   return
      // }
      // console.log(this.manualUpload.formData.getAll('file'))
      this.formData = this.manualUpload.formData
      await this.upload(this.manualUpload.config)
      // this.manualUpload = null
    },
    reset () {
      this.resetForm()
      this.$emit('update:reset', false)
    }
  }
  // computed: {
  //
  // }
}
</script>


<style>
  .IZ-file-uploader {
    padding: 20px 10px 0;
  }

  .IZ-file-uploader__percent-completed {
    text-align: center;
  }

  .IZ-file-uploader__slot-label-default {
    display: flex;
    justify-content: center;
  }

  .IZ-file-uploader__preview-gallery {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }

  .IZ-file-uploader__preview-gallery-item-thumbail {
    display: flex;
    align-items: center;
    justify-content: center;
    /* text-align: center; */
    width: 100px;
    height: 100px;
    /* max-width: 100px; */
    /* max-height: 100px; */
    margin: 40px 20px 0;
  }

  .IZ-file-uploader__preview-gallery-item-thumbail img {
    transition: all .3s ease;
    opacity: 0.5;
    max-height: 100%;
    max-width: 100%;
    border-radius: 5px;
    width: auto;
  }

  .IZ-file-uploader__preview-gallery-item-info {
    text-align: center;
  }

  .IZ-file-uploader__preview-gallery-item-info-size {
    color: grey;
  }
</style>



  <!-- #main {
    padding: 20px 20px;
  }

  #slot-label {
    cursor: pointer;
    display: flex;
    justify-content: center;
  }

  .img-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }

  .img {
    display: flex;
    align-items: center;
    justify-content: center;
    /* text-align: center; */
    width: 100px;
    height: 100px;
    /* max-width: 100px; */
    /* max-height: 100px; */
    margin: 40px 20px 0;
  }
  .img img {
    transition: all .3s ease;
    opacity: 0.5;
    max-height: 100%;
    max-width: 100%;
    border-radius: 5px;
    width: auto;
  } -->
