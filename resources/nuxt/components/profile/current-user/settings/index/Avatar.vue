<template>
  <div>
    <v-layout align-center justify-center column>
        <template v-if="progress">
          <div style="width: 100%;" class="text-xs-center">
            {{ progress }} / 100%<br>
            {{ progress === 100 ? 'Обработка на сервере...' : 'Загрузка на сервер...' }}
            <v-progress-linear v-model="progress" />
          </div>
        </template>
        <template v-else>
          <template v-if="$auth.user.avatar || avatarPreviewUrl">
            <v-scale-transition appear>
              <v-layout align-center justify-center>

                  <user-avatar size-name="lg" :url="avatarPreviewUrl" class="mx-3" />
                  <user-avatar size-name="md" :url="avatarPreviewUrl" class="mx-3" />
                  <user-avatar size-name="sm" :url="avatarPreviewUrl" class="mx-3" />
                  <user-avatar size-name="circle" :url="avatarPreviewUrl" class="mx-3" />

              </v-layout>
            </v-scale-transition>
          </template>
          <div v-else class="text-xs-center">
            <!-- <v-icon large>person</v-icon> -->
            <v-alert :value="true" type="info">
              У Вас нет аватарки.
            </v-alert>
            <!-- <span class="grey--text">У Вас нет аватарки</span> -->
          </div>
        </template>
    <!-- </v-layout> -->


    <!-- <v-layout v-if="avatarPreviewUrl" justify-center> -->
      <!-- <user-avatar :url="this.avatarPreviewUrl" size-name="large" class="px-3" /> -->
      <!-- <div style="overflow: hidden; max-width: 100%;">
        <img v-if="avatarPreview" ref="avatarPreview">
      </div> -->
    <!-- </v-layout> -->


    <!-- <v-layout justify-center> -->
    <v-scale-transition>
      <div v-if="avatarEditorSrc" class="mt-5" >
        <img ref="avatarEditor" :src="avatarEditorSrc" style="max-width: 100%;">
      </div>
    </v-scale-transition>
    <!-- </v-layout> -->


    <!-- <v-layout justify-center> -->
      <!-- <label for="avatar" style="cursor: pointer;">
        <v-btn @click="$refs.avatar.click()" color="primary mt-2 mb-4">
          <v-icon left>add_a_photo</v-icon>
          Выбрать
        </v-btn>
      </label> -->
      <!-- multiple -->
      <vue-images-manager
        upload-url="/api/profile/current/set-avatar"
        @change="onChange"
        @done="onUploadDone"
        @catch="onUploadCatch"
        @progress="onUploadProgress"
        :uploadAfterChange="false"
        :manualUpload="manualUploadInfo"
        :reset.sync="reset"
        hide-preview
      >
        <v-btn v-show="!progress" color="primary" round large>
          <v-icon left>add_a_photo</v-icon>
          {{ avatarEditorSrc ? 'Выбрать другое' : 'Выбрать' }}
        </v-btn>
        <span slot="buttons">
          <v-btn v-show="avatarEditorSrc && !progress" @click="startManualUpload" color="success" round large>
            <v-icon left>save</v-icon>
            Сохранить
          </v-btn>
          <v-btn v-show="avatarEditorSrc && !progress" @click="croperDestroy" color="error" round large>
            <v-icon left>close</v-icon>
            Отмена
          </v-btn>
        </span>


        <div slot="progress" v-show="progress" class="text-xs-center">
          <!-- {{ progress }} / 100%
          <v-progress-linear v-model="progress" /> -->
        </div>
      </vue-images-manager>

      <!-- @change="onFileChange" -->
      <!-- v-validate="'image'" -->
      <!-- <input
        type="file"
        accept=".jpg, .jpeg, .png"
        ref="avatar"
        hidden
      > -->
    </v-layout>
  </div>
</template>

<script>
  import Cropper from 'cropperjs'
  import 'cropperjs/dist/cropper.css'
  import { msg } from '~/tools/helpers'
  import UserAvatar from '~/components/user/UserAvatar'
  // import 'vue-images-manager'
  // import AppImgLoader from '~/components/AppImgLoader'
  // import AppImgLoader from 'vue-images-manager'
  // require('vue-images-manager')
  // require('/cropperjs/cropper.css')
  // app-img-loader , vueImagesManager
  export default {
    components: { UserAvatar },
    data: () => ({
      progress: null,
      avatarFormData: null,
      cropperInstance: null,
      avatarEditorSrc: null,
      avatarPreviewUrl: null,
      previewSetTimeoutId: null,
      manualUploadInfo: null,
      reset: null
    }),
    methods: {
      onChange (data) {
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
                    width: process.env.avatarSizes.lg,
                    height: process.env.avatarSizes.lg
                  }).toBlob(blob => {
                    URL.revokeObjectURL(this.avatarPreviewUrl) // очищает с памяти прошлый url
                    this.avatarPreviewUrl = URL.createObjectURL(blob)
                    // this.$refs.avatarPreview.setAttribute('src', this.urlPreviewInstance)
                  })
                }, 20)
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
      onUploadDone (user) {
        this.croperDestroy()
        this.goToNickname()
        this.$auth.setUser(user)
      },
      croperDestroy () {
        this.cropperInstance = this.progress = this.avatarEditorSrc = this.avatarPreviewUrl = null
        this.reset = true
        document.querySelector('.cropper-container').remove()
        this.goToNickname()
      },
      onUploadCatch (response) {
        msg.error(response.data.message)
      },
      onUploadProgress (info) {
        this.progress = info.percent
      },
      goToNickname () {
        this.$nextTick(() => {
          this.$vuetify.goTo('#profile-settings__nickname')
        })
      }
    }
    // mounted () {
    //   // new Image();
    //   this.$refs.avatar.addEventListener('DOMAttrModified', (e) => {
    //     if (e.attrName === 'src') {
    //       this.avatarBrowserLoaded = true
    //       console.log(123)
    //     }
    //   })
    // }
  }
</script>
