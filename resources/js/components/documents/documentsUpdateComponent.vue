<template>
    <div>
        <div class="row mb-2 d-flex justify-content-between">
            <div class="col-md-6">
                <a href="/documents" class="btn btn-primary btn-sm text-primary text-light"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
            </div>
        </div>
        <div class="horizontal-line-wrapper mb-3">
            <h6>{{ $data.related_documents.name }}</h6>
        </div>
        <file-drag-drop-instant
            :uploadURL="'/documents/related/upload'"
            :fetchURL="'/documents/related/fetch/'+u_id"
            :deleteURL="'/documents/delete/'"
            :previewURL="'/documents/preview/'"
            :fileTypeValidate="['pdf', 'zip', 'doc', 'docx', 'csv', 'xls', 'xlsx']"
            :fileSizeValidate="5000000"
            :versioning="true"
            :fileDetails="true"
            :updateNoteURL="'/documents/note/update/'"
            :updateNoteBtn="true"
            :updateFileBtn="false"
        >
        </file-drag-drop-instant>
    </div>
</template>

<script>
import FileDragDropInstant from './../globals/FileDragDropInstantComponent.vue'
export default {
    components: {
        FileDragDropInstant
    },
    data () {
        return {
            getSpecificDocument: [],
            u_id: related_documents.u_id,
            related_documents: related_documents,
            find_related_documents: find_related_documents,
        }
    }
}
</script>

<style scoped>
    .btn.update{display: none;}
</style>
