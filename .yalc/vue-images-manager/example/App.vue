<template>
  <div id="app">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <v-app>
      <v-content>
        <v-layout fill-height justify-center align-center>
          <v-card>
            <v-card-text style="width: 600px;">

              <v-layout v-if="avatarPreviewUrl" justify-center align-center>
                  <img :src="avatarPreviewUrl" style="max-width: 150px;" class="mx-1">
                  <img :src="avatarPreviewUrl" style="max-width: 100px;" class="mx-1">
                  <img :src="avatarPreviewUrl" style="max-width: 50px;" class="mx-1">
              </v-layout>

              <div v-if="avatarEditorSrc" class="mt-5 text-xs-center" style="max-width: 100%; max-height: 500px; margin: 0 auto;">
                <img ref="avatarEditor" :src="avatarEditorSrc" style="max-width: 100%;">
              </div>

              <img-loader
                upload-url="/api/profile/current/set-avatar"
                @change="onChange"
                @error="onError"
                @done="onUploadDone"
                @catch="onUploadCatch"
                @progress="onUploadProgress"
                :upload-after-change="false"
                :manual-upload="manualUploadInfo"
                :reset.sync="reset"
                hide-preview
              >
                <!-- <v-layout justify-center align-center> -->
                <v-btn v-show="!progress" color="primary" round>
                  <v-icon left>add_a_photo</v-icon>
                  {{ avatarEditorSrc ? 'Выбрать другое' : 'Выбрать' }}
                </v-btn>
                <!-- </v-layout> -->
                <span slot="buttons">
                  <v-btn v-show="avatarEditorSrc && !progress" @click="startManualUpload" color="success" round>
                    <v-icon left>save</v-icon>
                    Сохранить
                  </v-btn>
                  <v-btn v-show="avatarEditorSrc && !progress" @click="croperDestroy" color="error" round>
                    <v-icon left>close</v-icon>
                    Отмена
                  </v-btn>
                </span>

                <!-- <div slot="progress" v-show="progress" class="text-xs-center"> -->
                  <!-- {{ progress }} / 100%
                  <v-progress-linear v-model="progress" /> -->
                <!-- </div> -->
              </img-loader>
            </v-card-text>
          </v-card>
        </v-layout>

        <v-snackbar
          v-model="snackbarError"
          color="error"
          class="subheading"
          top
        >
          {{ snackbarErrorText }}
        </v-snackbar>
      </v-content>
    </v-app>
  </div>
</template>

<script>
import Cropper from 'cropperjs'
// import imgLoader from '../src/component'
// import * as vueImagesManager from '../dist/vueImagesManager.umd.js'
// import * as imgLoader from '../dist/vue-images-manager.umd.js'
// import * as vueImagesManager from '../dist/vue-images-manager.umd.js'
// import imgLoader from 'vue-images-manager'
// import Vue from 'vue'
// import Vuetify from 'vuetify'
import 'cropperjs/dist/cropper.css'
// import 'vuetify/dist/vuetify.min.css'
// import 'vuetify/dist/vuetify.js'
// require('../dist/vue-images-manager.umd.js')
// const imgLoader = require('../dist/vue-images-manager.common.js')
// import '../dist/vueImagesManager.umd.js'
// import '../dist/vueImagesManager.umd.js'
require('../dist/vueImagesManager.umd.js')

window.console.log(vueImagesManager)

// Vue.use(Vuetify)

export default {
  components: { imgLoader: vueImagesManager },
  data: () => ({
    progress: null,
    avatarFormData: null,
    cropperInstance: null,
    avatarEditorSrc: null,
    avatarPreviewUrl: null,
    previewSetTimeoutId: null,
    manualUploadInfo: null,
    reset: null,

    snackbarError: false,
    snackbarErrorText: null
  }),
  methods: {
    onChange (data) {
      window.console.log(data)
      this.avatarFormData = data.formData

      if (this.cropperInstance) {
        this.cropperInstance.replace(data.preview)
      } else {
        this.avatarEditorSrc = data.preview
        this.$nextTick(() => {
          const image = this.$refs.avatarEditor
          this.cropperInstance = new Cropper(image, {
            aspectRatio: 1, // 4 / 3,
            viewMode: 1,
            background: false,
            // autoCropArea: 1, // default: 0.8
            // dragMode: 'move',
            // preview: this.$refs.avatarPreview,
            zoomable: false,
            zoomOnTouch: false,
            zoomOnWheel: false,
            crop: event => {
              if (this.previewSetTimeoutId) {
                clearTimeout(this.previewSetTimeoutId)
              }
              this.previewSetTimeoutId = setTimeout(() => {
                this.cropperInstance.getCroppedCanvas({
                  // используется размер аватарки из конфига
                  width: 320, // process.env.avatarSizes.lg
                  height: 320
                }).toBlob(blob => {
                  URL.revokeObjectURL(this.avatarPreviewUrl) // очищает с памяти прошлый url
                  this.avatarPreviewUrl = URL.createObjectURL(blob)
                  // this.$refs.avatarPreview.setAttribute('src', this.urlPreviewInstance)
                })
              }, 10)
            }
          })
        })
      }
    },
    startManualUpload () {
      const cropData = JSON.stringify(this.cropperInstance.getData(true))

      this.avatarFormData.append('cropInfo', cropData)
      this.manualUploadInfo = {
        formData: this.avatarFormData
      }

      // let formData = new FormData()
      // this.cropperInstance.getCroppedCanvas({
      //   width: 726,
      //   height: 544
      // }).toBlob(blob => {
      //   formData.append('file', blob)
      //   formData.append('cropInfo', this.cropperInstance.getData(true))
      //
      //   this.manualUploadInfo = {
      //     formData
      //   }
      // })
    },
    onError (data) {
      this.snackbarError = true
      this.snackbarErrorText = data.msg
      // console.error(data)
    },
    onUploadDone (user) {
      this.croperDestroy()
    },
    croperDestroy () {
      this.cropperInstance = this.progress = this.avatarEditorSrc = this.avatarPreviewUrl = null
      this.reset = true
      document.querySelector('.cropper-container').remove()
    },
    onUploadCatch (response) {
      window.console.error(response.data.message)
    },
    onUploadProgress (info) {
      this.progress = info.percent
    }
  }
}
</script>

<style lang="css">
</style>
