<template>
    <div>
        <div class="horizontal-line-wrapper mb-3">
            <h6>Documents</h6>
        </div>
        <file-drag-drop-instant
            :uploadURL="'/documents/upload'"
            :fetchURL="'/documents/fetch'"
            :deleteURL="'/documents/delete/'"
            :previewURL="'/documents/preview/'"
            :updateURL="'/documents/update/'"
            :fileTypeValidate="['pdf', 'zip', 'doc', 'docx', 'csv', 'xls', 'xlsx']"
            :fileSizeValidate="5000000"
            :fileDetails="true"
            :versioning="false"
            :updateFileBtn="true"
        >
        </file-drag-drop-instant>
    </div>
</template>

<script>
import FileDragDropInstant from './../globals/FileDragDropInstantComponent.vue'
export default {
    components: {
        FileDragDropInstant
    }
}
</script>
