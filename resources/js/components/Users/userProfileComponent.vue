<template>
      <modal name="size-modal"
        transition="nice-modal-fade"
        classes="demo-modal-class"
        :min-width="200"
        :min-height="200"
        :pivot-y="0.1"
        :adaptive="true"
        :scrollable="true"
        :reset="true" 
        width="60%"
        height="auto"
        @before-open="beforeOpen"
        @opened="opened"
        @closed="closed"
        @before-close="beforeClose">
  <div class="size-modal-content">
    <div class="p-3 bg-white shadow rounded-lg">
        <input type="file" class="chooseFile" name="image" accept="image/*" @change="setImage" />

        <!-- Image previewer -->
        <!-- <img :src="imageSrc" width="100"/> -->

        <!-- Cropper container -->
        <div v-if="this.imageSrc" class="my-3 d-flex align-items-center justify-content-center mx-auto">
            <vue-cropper class="mr-2 w-50" ref='cropper' :guides="true" :src="imageSrc"></vue-cropper>

            <!-- Cropped image previewer -->
            <img class="ml-2 w-50 bg-light" :src="croppedImageSrc"/>
        </div>
        <button class="btn btn-success" v-if="this.imageSrc" @click="cropImage">Crop</button>
        <button class="btn btn-success" v-if="this.croppedImageSrc" @click="uploadImage">Upload</button>
    </div>
    </div>
</modal>
</template>

<script>
    import VueCropper from 'vue-cropperjs';
    import 'cropperjs/dist/cropper.css';

    export default {
        name: 'SizeModalTest',
        props: ['avtr_path'],
        components: {
            VueCropper
        },
        data: function() {
            return {
                imageSrc: "",
                croppedImageSrc: "",
                image: '',
                user_id : window.user_id,
                avr_path : '',
            }
        },
        methods: {
            setImage: function (e) {
                const file = e.target.files[0];
                if (!file.type.includes('image/')) {
                    alert('Please select an image file');
                    return;
                }
                if (typeof FileReader === 'function') {
                    const reader = new FileReader();
                    reader.onload  = (event) => {
                        this.imageSrc = event.target.result;

                        // Rebuild cropperjs with the updated source
                        // this.$refs.cropper.replace(event.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Sorry, FileReader API not supported');
                }
            },
            cropImage() {

                // Get image data for post processing, e.g. upload or setting image src
                this.croppedImageSrc = this.$refs.cropper.getCroppedCanvas().toDataURL();
            },
            uploadImage() {
                let vm = this;
                this.$refs.cropper.getCroppedCanvas().toBlob(function (blob) {
                    // console.log(blob)
                    let formData = new FormData();

                    // Add name for our image
                    formData.append('name', "profile"+user_id);

                    // Append image file
                    formData.append('file', blob);
                    //User ID
                    formData.append('user_id', user_id);

                    axios.post(
                        '/user/avatar', formData
                    ).then(response => {
                        if (response.data.status == 'success') {
                            vm.$modal.hide('size-modal'); 
                            Toast.fire({
                                type: 'success', title: 'Profile image is updated successfully',
                            });
                            // location.reload();
                        }
                    }).catch(function (error) {
                        console.log(error);
                        Toast.fire({
                            type: 'error', title: 'Oops... something went wrong',
                        });
                    });
                });
            },
            beforeOpen (e) {
                // console.log(e);
                // this.croppedImageSrc = e.params.avtr_path;
                this.timer = setInterval(() =>  5000)
            },
            beforeClose (e){
                let emptyImageSrc = '';
                let vm = this;
                if(this.croppedImageSrc == emptyImageSrc){
                    vm.$parent.avtr_path = vm.$parent.avtr_path;
                }else{
                    vm.$parent.avtr_path = this.croppedImageSrc;
                }
            },
            opened (e) {
            // e.ref should not be undefined here
                // console.log('opened', e)
                // console.log('ref', e.ref)
            },
            closed (e) {
                // console.log('closed', e)
            }
        }
    }
</script>