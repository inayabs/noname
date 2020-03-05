<template>
  <div id="file-drag-drop">
    <div class="row">
      <div class="col-md-12">
        <div class="position-relative">
          <div v-if="($props.uploaderToolbar === true)"  class="uploader-toolbar d-flex align-content-center justify-content-between mb-2">
            <div>lorem</div>
            <div class="btn-group grid-layout">
              <button class="btn btn-link px-2 py-1 rounded-0 active" role="button" aria-pressed="true"><i class="fas fa-th"></i></button>
              <button class="btn btn-link px-2 py-1 rounded-0"><i class="fas fa-th-list"></i></button>
            </div>
          </div>
          <form ref="fileform" class="file-form mb-4 mt-0 pt-4 px-2" :class="[onDrag ? 'on-drag' : '', progressBar ? 'on-progress' : '']">
            <div class="row">
              <div class="card-wrapper col-3 mb-4 position-relative" v-for="(file, key) in sortDescFiles">

                <a v-bind:href="previewURL+file.id" class="card file-listing h-100" v-bind:key='file.id' target="_blank">
                  <div class="img-icon-container">
                    <div class="extra-details">
                      <div v-if="$props.versioning === true && file.is_current === 1" class="">Current</div>
                      <div v-if="$props.fileDetails === true" class="current-file">v{{ file.version  }}</div>
                    </div>
                    <div v-if="file.file_type !== 'image'" class="preview-item-icon" v-bind:class="file.file_ext">
                      <span>
                        <label class="text-uppercase m-0">{{file.file_ext}}</label>
                      </span>
                    </div>
                    <div v-else class="preview preview-item-img card-img-top" v-bind:ref="'preview'+parseInt( key )" v-bind:style="'background-image: url(' + file.file_path +  ');'"></div>
                  </div>
                  <div class="card-body p-2">
                    <p class="card-text">{{ file.name }}</p>
                  </div>
                </a>
                <div class="btn-group-vertical card-btn" role="group">
                  <a href="javascript:void(0)" class="btn btn-link btn-sm remove" v-tooltip:right="'Delete File'" v-on:click="removeFile( file, key )"><i class="fa fa-trash-alt" aria-hidden="true"></i></a>
                  <!-- If fileDetails is enabled -->
                  <a v-if="($props.fileDetails === true)" v-bind:href="updateURL+file.u_id" class="btn btn-link btn-sm update" v-tooltip:right="'Update File'" :class="[updateFileBtn ? '' : 'd-none']"><i class="fas fa-history"></i></a>
                  <a v-if="($props.updateNoteBtn === true)" @click="updateNote(file.id)" class="btn btn-link btn-sm update" v-tooltip:right="'Update Note'"><i class="far fa-edit"></i></a>
                  <!-- end If fileDetails is enabled -->
                </div>
              </div>
            </div>
            <div v-if="$data.files == 0" class="uploader-icon d-flex flex-column align-items-center justify-content-center">
              <div class="icon-wrapper">
                <i class="fas fa-cloud-upload-alt"></i>
              </div>
              <span>Drop Files Here</span>
            </div>
            <!-- Start File Caption HTML Markdown -->
            <div class="fileform-caption"><i class="fas fa-file-upload"></i> Drop your files here! <span> supported files: <b>{{ $props.fileTypeValidate.toString()  }}</b></span></div>
            <!-- End File Caption HTML Markdown -->
            <!-- Start Progressbar HTML Markdown -->
            <div class="progress d-none">
              <div class="progress-bar" role="progressbar" v-bind:style.prop="'width: ' +uploadPercentage+ '%'" v-bind:aria-valuenow.prop="uploadPercentage" aria-valuemin="0" aria-valuemax="100">{{ uploadPercentage }}%</div>
              <!-- <div class="progress-bar" role="progressbar" v-bind:style.prop="'width: 90%'" v-bind:aria-valuenow.prop="90" aria-valuemin="0" aria-valuemax="100">90 %</div> -->
            </div>
            <div class="on-progress-bg"></div>
            <!-- End Progressbar HTML Markdown -->
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    /*
      Variables used by the drag and drop component
    */
    data(){
      return {
        dragAndDropCapable: false,
        files: [],
        uploadPercentage: 0,
        noteText: '',
        onDrag: 0,
        progressBar: 0,
      }
    },
    computed: {
      sortDescFiles : function(){
        function compare(a,b){
          if (a.id > b.id)
            return -1;
          if(a.id < b.id)
            return 1;
          return 0;
        }
        return this.files.sort(compare);
      },
    },

    props: {
        // URL's
        uploadURL: '',
        fetchURL: '',
        deleteURL: '',
        previewURL: '',
        updateURL: '',
        updateNoteURL:'',
        // File Validate Option
        fileTypeValidate: '',
        fileSizeValidate: '',
        // File Details and Versioning Option
        fileDetails: '',
        versioning: '',
        // Nutton Options
        updateFileBtn: '',
        updateNoteBtn: '',
        // Uploader Toolbar Option
        uploaderToolbar: '',
    },
    created(){
      this.fetchAttachments();
    },
    mounted(){
      /*
        Determine if drag and drop functionality is capable in the browser
      */
      this.dragAndDropCapable = this.determineDragAndDropCapable();

      /*
        If drag and drop capable, then we continue to bind events to our elements.
      */
      if( this.dragAndDropCapable ){
        /*
          Listen to all of the drag events and bind an event listener to each
          for the fileform.
        */
        ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach( function( evt ) {
          /*
            For each event add an event listener that prevents the default action
            (opening the file in the browser) and stop the propagation of the event (so
            no other elements open the file in the browser)
          */
          this.$refs.fileform.addEventListener(evt, function(e){
            e.preventDefault();
            e.stopPropagation();
          }.bind(this), false);
        }.bind(this));

        /*
          Add an event listener for drop to the form
        */
        this.$refs.fileform.addEventListener('drop', function(e){
            /*
                Capture the files from the drop event and add them to our local files
                array.
            */
           if (this.fileDetails === true) {
                for( let i = 0; i < e.dataTransfer.files.length; i++ ){

                  let isValid = 1;
                  let vm = this;
                  let dataFiles = e.dataTransfer.files[i];
                  // validate file type
                  if(this.fileTypeValidate != '' ){
                    let ext = e.dataTransfer.files[i].name.split('.');
                    // console.log(ext);
                    if(this.fileTypeValidate.indexOf(ext[ext.length-1]) == -1){
                    // console.log('type validate');
                      isValid = 0;
                      Toast.fire({
                          position: 'top-end',
                          type: 'error', title: 'File type is not allowed',
                      })
                      return false;
                    }
                  }
                  // validate file size
                  if(this.fileSizeValidate != '' && this.fileSizeValidate < e.dataTransfer.files[i].size){
                    isValid = 0;
                    Toast.fire({
                        position: 'top-end',
                        type: 'error', title: 'File size is to large!',
                    })
                    return false;
                  }
                  // console.log(e.dataTransfer.files[i]);
                  // Compare and Validate Existing File
                  var compareID = [];
                  var compareName = [];

                  // IF File does exist and versioning is not enabled
                  for(let c = 0; c < this.files.length; c++) {
                    if(this.versioning != true){
                      if(dataFiles.name == this.files[c].name) {
                        compareID = 1;
                        Toast.fire({
                            position: 'top-end',
                            type: 'error', title: 'File already exist! Please click "update file" button to add new version of this file.',
                        })
                        break;
                      }
                    }
                    if(this.versioning == true){
                      if(dataFiles.name != this.files[c].name) {
                        compareName = 1;
                        break;
                      }
                    }
                  }
                  // If file does not exist and versioning is enabled
                  if(compareName == 1) {
                      Toast.fire({
                        position: 'top-end',
                        type: 'error', title: 'File is not the same! Please refer to the file name and file type.',
                      })
                      break;
                  }
                  if (compareID != 1 ) {
                    swal.fire({
                      title: 'Add file note',
                      input: 'text',
                      inputAttributes: {
                        autocapitalize: 'on'
                      },
                      allowOutsideClick: false,
                      showCancelButton: true,
                      confirmButtonText: 'Upload',
                      confirmButtonColor: '#355dce',
                    }).then((result) => {
                      if (result.value) {
                        vm.noteText = result.value;
                        if(isValid == 1){
                          this.progressBar = 1;
                          vm.submitFiles(dataFiles, i);
                        }
                      }
                    })
                    break;
                  }
                }
           } else {
             for( let i = 0; i < e.dataTransfer.files.length; i++ ){
               let isValid = 1;
              //  console.log(e.dataTransfer.files[i]);
               // validate file type
               if(this.fileTypeValidate != '' ){
                 let ext = e.dataTransfer.files[i].name.split('.');
                //  console.log(ext);
                 if(this.fileTypeValidate.indexOf(ext[ext.length-1]) == -1){
                //  console.log('type validate');
                   isValid = 0;
                   Toast.fire({
                       position: 'top-end',
                       type: 'error', title: 'File type is not allowed',
                   })
                   return false;
                 }
               }
               // validate file size
               if(this.fileSizeValidate != '' && this.fileSizeValidate < e.dataTransfer.files[i].size){
                 isValid = 0;
                 Toast.fire({
                     position: 'top-end',
                     type: 'error', title: 'File size is to large!',
                 })
                 return false;
               }
               if(isValid == 1){
                 this.progressBar = 1;
                 this.submitFiles(e.dataTransfer.files[i], i);
               }
               // this.files.push( e.dataTransfer.files[i] );
               // this.getImagePreviews(e.dataTransfer.files[i], this.files.length-1);
             }
           }
            /*
                Instantly upload files
            */
            // this.submitFiles();
          this.onDrag = 1;
        }.bind(this));
        // ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop']
        this.$refs.fileform.addEventListener('dragover', function(e){
          this.onDrag = 1;
        }.bind(this));
        this.$refs.fileform.addEventListener('dragleave', function(e){
          this.onDrag = 0;
        }.bind(this));
      }
    },

    methods: {
      /*
        Determines if the drag and drop functionality is in the
        window
      */
      determineDragAndDropCapable(){
        /*
          Create a test element to see if certain events
          are present that let us do drag and drop.
        */
        var div = document.createElement('div');

        /*
          Check to see if the `draggable` event is in the element
          or the `ondragstart` and `ondrop` events are in the element. If
          they are, then we have what we need for dragging and dropping files.

          We also check to see if the window has `FormData` and `FileReader` objects
          present so we can do our AJAX uploading
        */
        return ( ( 'draggable' in div )
                || ( 'ondragstart' in div && 'ondrop' in div ) )
                && 'FormData' in window
                && 'FileReader' in window;
      },
      /*
        Gets the image preview for the file.
      */
      getImagePreviews(file, key){
        /*
          Iterate over all of the files and generate an image preview for each one.
        */
       
          /*
            Ensure the file is an image file
          */
          if ( /\.(jpe?g|png|gif)$/i.test( file.name ) ) {
            /*
              Create a new FileReader object
            */
            let reader = new FileReader();
            /*
              Add an event listener for when the file has been loaded
              to update the src on the file preview.
            */
            reader.addEventListener("load", function(){
              this.$refs['preview'+parseInt( key )][0].src = reader.result;
            }.bind(this), false);
            /*
              Read the data for the file in through the reader. When it has
              been loaded, we listen to the event propagated and set the image
              src to what was loaded from the reader.
            */
            reader.readAsDataURL( file );
          }else{
            /*
              We do the next tick so the reference is bound and we can access it.
            */
            this.$nextTick(function(){
              this.$refs['preview'+parseInt( key )][0].src = '/images/file.png';
            });
          }
      },
      /*
          Fetch the files to the server
      */
      fetchAttachments(){
        let vm = this;
        axios.get(vm.fetchURL)
        .then(function(res){
          vm.files = res.data;
        })
        .catch(function(error){
        });
      },
      /*
          Submits the files to the server
      */
     /* Submit / Upload File Methods Function */
      submitFiles(file, key){
        /*
            Initialize the form data
        */
        let formData = new FormData();
        let vmFile = this.files;
        let vm = this;

        // single file
        formData.append('files', file);
        if(this.fileDetails === true) {
          formData.append('note', this.noteText);
          formData.append('u_id', this.$parent.u_id);
        }
        /*
            Make the request to the POST /file-drag-drop-instant URL
        */
        axios.post( this.uploadURL,
          formData,
          {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: function( progressEvent ) {
                this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
            }.bind(this)
          }
        ).then(function(res){
            if(res.data.status == 'success'){
              Toast.fire({
                  position: 'top-end',
                  type: 'success', title: 'Attachment saved successfully',
              })
              vm.fetchAttachments();
              // console.log(vmFile);
            // console.log('SUCCESS!!');
              vm.uploadPercentage = 0;
              vm.onDrag = 0;
              vm.progressBar = 0;
            }else{
              Toast.fire({
                  position: 'top-end',
                  type: 'error', title: 'Attachment was not saved',
              })
            }
        })
        .catch(function(){
            Toast.fire({
                position: 'top-end',
                type: 'error', title: 'Attachment was not saved',
            })
        });
      },

      /* Remove File Methods Function */
      removeFile( file, key ) {
        let vmFile = file;
        let vm = this;
        let vmKey = key;
        swal.fire({
          title: 'Are you sure delete attachment?',
          text: file.name+" won't able to be retrieved!",
          icon: 'warning',
          showCancelButton: true,
          allowOutsideClick: false,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#363636',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            axios.get(vm.deleteURL+'/'+vmFile.id)
            .then(function(res){
              // vm.files = res.data;
              if(res.data.status == 'success'){
                vm.files.splice(vmKey, 1);
                vm.fetchAttachments();
                swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
              }
            })
          }
        })
      },

      /* Update Note Methods Function */
      updateNote (id) {
        let existingDetails = [];
        for(let c = 0; c < this.files.length; c++){
          if(this.files[c].id == id) {
            existingDetails[0] = this.files[c].note;
            existingDetails[1] = this.files[c].is_current;
          }
        }
        swal.fire({
          title: 'Update file note',
          html:
          '<input id="note" class="swal2-input" value="'+ existingDetails[0] +'">' +
          '<div class="custom-control custom-checkbox">' +
            '<input type="checkbox" class="custom-control-input" id="is_current" '+ (existingDetails[1] === 1 ? 'disabled' : "")  +'>' +
            '<label class="custom-control-label '+ (existingDetails[1] === 1 ? 'checked' : "")  +'" for="is_current">'+ (existingDetails[1] === 1 ? 'This file is already set as current.' : "Check this to set file as current.")  +'</label>' +
          '</div>',
          allowOutsideClick: false,
          showCancelButton: true,
          confirmButtonText: 'Update',
          confirmButtonColor: '#355dce',
          focusConfirm: false,
          preConfirm: () => {
            return [
              document.getElementById('note').value,
              document.getElementById('is_current').checked,
            ]
          },
        }).then((result) => {
          if(result.dismiss != 'cancel') {
            let noteFields = JSON.parse('{"note": "'+result.value[0]+'", "is_current": '+result.value[1]+'}');
            
            axios({method: 'put', url: this.updateNoteURL + id, data: noteFields,
            }).then(response => {
              this.fetchAttachments();
              Toast.fire({
                  position: 'top-end',
                  type: 'success', title: 'File note is saved successfully',
              })
            }).catch(error => {
              if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
                this.fetchAttachments();
                Toast.fire({
                    position: 'top-end',
                    type: 'error', title: 'Opss.. file note was not saved',
                })
              }
            });
          } else {
            Toast.fire({
                position: 'top-end',
                type: 'info', title: 'File update was cancelled.',
            })
          }
        })
      }
    }
  }
</script>

<style lang="scss" scoped>

$white: #fff !default;
$blue: #024B67 !default;

.pdf{
  background-color: #f23c0f;
  label::before{content: "\f1c1";}
}
.zip, .rar{
  background-color: #6a1a9c;
  label::before{content: "\f1c6";}
}
.doc, .docx{
  background-color: #2A5699;
  label::before{content: "\f1c2";}
}
.csv, .xls, .xlsx{
  background-color: #207245;
  label::before{content: "\f1c3";}
}
.custom-control-input ~ .custom-control-label.checked{
  &::before{color: #fff !important; border-color:$blue !important;background-color:$blue !important; opacity: 0.5;}
  &::after{background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");}
}
// Uploader Toolbar
.uploader-toolbar{
  .grid-layout{
    .btn{
      opacity: 0.5;
      &:hover,
      &.active{opacity: 1;}
    }
  }
}
// File Form
.file-form{
  display: block;min-height: 400px;height: auto;background: $white;border: 2px dashed #eaeaea;margin: auto;text-align: center;border-radius: 4px;border-top-left-radius: 0 !important;
  &:hover,
  &:focus,
  &:active,
  &.on-drag{
    background-color: rgba($blue, 0.2);border-color: $blue;

    .uploader-icon{
      background-color: rgba($blue, 0.3);
      color: $blue;
    }
  }
  .fileform-caption{
    // display: none;user-select: none;pointer-events: none;color: #ffffff;position: absolute;top: -26px;right: 0;background: #4e73df;padding: 5px 12px;font-size: 12px;border-top-left-radius: 4px;border-top-right-radius: 4px;
    display: none;user-select: none;pointer-events: none;color: #ffffff; width: 100%; position: absolute;top: -10px;left: 0;background: $blue;padding: 5px 10px;font-size: 12px;border-top-left-radius: 4px;border-top-right-radius: 4px;
  }
  &:hover .fileform-caption,
  &.on-drop .fileform-caption{
    display: block;
  }
  .file-listing {
    &:hover {
      text-decoration: none;box-shadow: 0px 0px 10px 1px rgba($blue,0.5);-webkit-box-shadow: 0px 0px 10px 1px rgba($blue,0.5);-moz-box-shadow: 0px 0px 10px 1px rgba($blue,0.5);
      .preview-item-img{
        -webkit-animation: zoomin 0.3s forwards;animation: zoomin 0.3s forwards;
      }
    }
  }
  .card {
    border: none;
    .card-body {
      border: 1px solid #e3e6f0;border-top: none;border-bottom-left-radius: .35rem;border-bottom-right-radius: .35rem;
      .card-text{
        color: #757575;font-size: 14px;line-height: 1.3;
      }
    }
    .img-icon-container{
      position: relative;height: 160px;overflow: hidden;
      .extra-details{
        position: absolute;top: .5rem;left: .5rem;font-size: 10px;font-weight: 700;z-index: 9;
        div {
          background-color: #66BB6A;color: $white;border-radius: .2rem;padding: 0 5px;display: inline-block;
          &:first-child {
            margin-right: 5px;
          }
        }
      }
      .preview-item-icon{
        span {
          user-select: none; -o-user-select: none; -ms-user-select: none; -moz-user-select: none; -webkit-user-select: none;
          pointer-events: none; -o-pointer-events: none; -ms-pointer-events: none; -moz-pointer-events: none; -webkit-pointer-events: none;
        }
        position: relative;height: 100%; text-align: center;vertical-align: middle;font-weight: bolder;color: $white;border-top-left-radius: 4px;border-top-right-radius: 4px;font-size: 24px;display: flex;justify-content: center;align-items: center;
        label::before {
          font-family: 'Font Awesome 5 Free';font-weight: 900;display: inline-block;margin-right: 10px;
        }
      }
      .preview-item-img{
        position: relative;max-width: 100%;height: 100%;background-repeat: no-repeat;background-position: center;background-size: cover;-webkit-animation: zoomout 0.3s forwards;animation: zoomout 0.3s forwards;
        &:hover {
          -webkit-animation: zoomin 0.3s forwards;animation: zoomin 0.3s forwards;
        }
      }
    }
  }
  &.on-progress{
    user-select: none;
    pointer-events: none;
    border-color: $blue;
    .progress{
      display: block !important; position: absolute;top: 50%;left: 50%; right: 50%;width: 80%;border-radius: 0; transform: translate(-50%, -50%); z-index: 10;
    }
    .on-progress-bg{
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      display: block;
      background-color: rgba($white, 0.8);
      z-index: 9;
    }
  }

  .card-btn{
    position: absolute;top: 0;right: .75rem;z-index: 9;
    a{
      color: $white !important;
    }
    .update, .remove{
        border: none;;
        text-shadow:#b5b5b5 0px 0px 5px, #b5b5b5 0px 0px 10px, #b5b5b5 0px 0px 15px;
    }
    .update{
      &:hover{
        animation: shake 1s; animation-iteration-count: infinite; color: #00695C; text-shadow: #00897B 0px 0px 5px, #00897B 0px 0px 10px, #00897B 0px 0px 15px, #00695C 0px 0px 20px, #00695C 0px 0px 30px, #00695C 0px 0px 40px, #00695C 0px 0px 50px, #00695C 0px 0px 75px;
      }
    }
    .remove{
      &:hover{
        animation: shake 1s; animation-iteration-count: infinite; color: #c62828; text-shadow: #e53935 0px 0px 5px, #e53935 0px 0px 10px, #e53935 0px 0px 15px, #c62828 0px 0px 20px, #c62828 0px 0px 30px, #c62828 0px 0px 40px, #c62828 0px 0px 50px, #c62828 0px 0px 75px;
      }
    }
  }

  .uploader-icon{
    height: 200px; width: 200px; border-radius: 50%; background-color: #f7f7f7;position: absolute; top: 50%; left: 50%; right: 50%; transform: translate(-50%, -50%);
    .icon-wrapper{
      font-size: 40px; line-height: 1;
    }
    span{
      font-size: 20px; font-weight: 700;
    }
  }
}
@keyframes zoomin {
  0% { transform: scale(1) } 20% { transform: scale(1.1) } 40% { transform: scale(1.2) } 60% { transform: scale(1.3) } 80% { transform: scale(1.4) } 100% { transform: scale(1.5) }
}
@keyframes zoomout {
  0% { transform: scale(1.5) } 20% { transform: scale(1.4) } 40% { transform: scale(1.3) } 60% { transform: scale(1.2) } 80% { transform: scale(1.1) } 100% { transform: scale(1) }
}
@keyframes shake {
  0% { transform: rotate(0deg); } 10% { transform: rotate(0deg); } 20% { transform: rotate(10deg); } 30% { transform: rotate(-10deg); } 40% { transform: rotate(10deg); } 50% { transform: rotate(-10deg); } 60% { transform: rotate(10deg); } 70% { transform: rotate(-10deg); } 80% { transform: rotate(10deg); } 90% { transform: rotate(0deg); } 100% { transform: rotate(0deg); }
}
</style>