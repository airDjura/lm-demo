<template>
    <div class="upload-field">
      <!--UPLOAD-->
      <form novalidate v-if="isInitial || isSaving || isDeleting || multiple">
        <div class="dropbox">
          <input v-if="!multiple" type="file" :name="uploadFieldName" :disabled="isSaving || isDeleting"
            @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length"
            accept="image/*" class="input-file">
          <input v-if="multiple" type="file" :name="uploadFieldName" multiple :disabled="isSaving || isDeleting"
            @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length"
            accept="image/*" class="input-file">
          <button class="dropbox-gallery-button" @click="openGallery" v-if="multiple && uploadedFiles.length > 0" type="button"><i class="fa fa-picture-o"></i></button>
          <p class="upload-saving" v-if="isSaving">
            <i class="fa fa-spin fa-cog"></i>
            <strong>{{$t('dropzone.uploading')}}</strong>
          </p>
          <p class="upload-saving" v-if="isDeleting && !multiple">
            <i class="fa fa-spin fa-cog"></i>
            <strong>{{$t('dropzone.deleteing')}}</strong>
          </p>
          <p v-if="isInitial || isSaving || isDeleting || multiple">
            <i class="fa fa-cloud-upload"></i>
            <strong>{{$t('dropzone.dropFiles')}}</strong> <br>(JPEG, PNG Format, 1920px x 600px, max 2MB)
          </p>
        </div>
      </form>
      <!--SUCCESS-->
      <div class="image-upload-caption" v-if="isSuccess && !multiple">
        <ul class="list-unstyled">
          <div class="animated fadeIn" v-for="(item, n) in uploadedFiles" :key="n">
            <div class="img-container fx-img-zoom-in">
              <img :src="item.path" class="img-fluid options-item" :alt="item.name">
                <div class="img-options">
                  <div class="img-options-content">
                      <a class="btn btn-sm btn-danger delete-image-btn" @click="deleteImage(n)" href="#" data-image-id="3"><i class="fa fa-times"></i> {{$t('delete')}}</a>
                  </div>
                </div>
              </div>
          </div>
        </ul>
      </div>
      <!--FAILED-->
      <div v-if="isFailed">
        <p>
          <a href="javascript:void(0)" @click="reset()">{{$t('dropzone.tryAgain')}}</a>
        </p>
        <pre>{{ uploadError }}</pre>
      </div>
      <ntm-modal size="large" ref="modal" :need-footer="false" :need-header="false">
        <div slot="body">
          <div class="row">
            <carousel v-if="multiple && uploadedFiles.length > 0 && carousel" :perPage="3" :autoplay="true" :autoplayTimeout="3000">
              <slide class="uploaded-image" v-for="(item, n) in uploadedFiles" :key="item.id">
                <div class="animated fadeIn col-sm-12">
                  <div class="img-container fx-img-zoom-in">
                    <img :src="item.path" class="img-fluid options-item" :alt="item.name">
                      <div class="img-options">
                          <div class="img-options-content">
                                <a class="btn btn-sm btn-danger delete-image-btn" @click="deleteImage(n)" href="#" data-image-id="3"><i class="fa fa-times"></i> {{$t('delete')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
              </slide>
            </carousel>
          </div>
        </div>
      </ntm-modal>
  </div>
</template>

<script>
import mediaService from '@/services/media.service'

const STATUS_INITIAL = 0
const STATUS_SAVING = 1
const STATUS_SUCCESS = 2
const STATUS_FAILED = 3
const STATUS_DELETING = 4

export default {
  name: 'UploadField',
  props: {
    multiple: {
      type: Boolean,
      default: false
    },
    assetUuid: String,
    assetType: String,
    type: String
  },
  data () {
    return {
      carousel: false,
      uploadedFiles: {},
      uploadError: null,
      currentStatus: null,
      uploadFieldName: 'image[]'
    }
  },
  computed: {
    isInitial () {
      return this.currentStatus === STATUS_INITIAL
    },
    isSaving () {
      return this.currentStatus === STATUS_SAVING
    },
    isSuccess () {
      return this.currentStatus === STATUS_SUCCESS
    },
    isFailed () {
      return this.currentStatus === STATUS_FAILED
    },
    isDeleting () {
      return this.currentStatus === STATUS_DELETING
    }
  },
  methods: {
    reset () {
      // reset form to initial state
      this.uploadedFiles = {}
      this.currentStatus = STATUS_INITIAL
      this.uploadError = null
    },
    deleteImage (n) {
      this.currentStatus = STATUS_DELETING
      mediaService.delete(this.uploadedFiles[n].id)
        .then((x) => {
          this.getFiles()
        }).catch(() => {
          this.currentStatus = STATUS_SUCCESS
        })
    },
    save (formData) {
      // upload data to the server
      this.currentStatus = STATUS_SAVING
      mediaService.upload(this.assetUuid, this.type, formData)
        .then((x) => {
          this.getFiles()
          if (this.multiple) {
            this.openGallery()
          }
        })
        .catch(err => {
          this.uploadError = err.response
          this.currentStatus = STATUS_FAILED
        })
    },
    filesChange (fieldName, fileList) {
      // handle file changes
      const formData = new FormData()
      if (!fileList.length) return
      // append the files to FormData
      Array
        .from(Array(fileList.length).keys())
        .map(x => {
          formData.append(fieldName, fileList[x], fileList[x].name)
        })
      formData.append('assetType', this.assetType)
      // save it
      this.save(formData)
    },
    getFiles () {
      mediaService.getByType(this.assetType, this.assetUuid, this.type)
        .then((x) => {
          this.uploadedFiles = x.data
          if (this.uploadedFiles.length > 0) {
            this.currentStatus = STATUS_SUCCESS
          } else {
            this.$refs.modal.close()
            this.currentStatus = STATUS_INITIAL
          }
        }).catch(() => {
          this.currentStatus = STATUS_INITIAL
        })
    },
    openGallery () {
      this.$refs.modal.open()
      this.carousel = true
    }
  },
  mounted () {
    this.reset()
    this.getFiles()
  }
}
</script>
