<template lang="">
    <div>
        <button class="btn btn-success btn-sm d-table ml-auto" @click="saveCreateUpdate()"><i class="far fa-save"></i> Save Template</button>
        <div class="horizontal-line-wrapper my-3" id="directEdit">
            <h6>Letter Template</h6>
        </div>
        <div class="clearfix"></div>
        <div class="form-padding-left-right">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="inputName">Template name:</label>
                        <input type="text" id="inputName" class="form-control" v-model="fields.name" :class="[errors && errors.name ? 'border-danger' : '']" autofocus>
                        <div v-if="errors && errors.name" class="badge badge-danger">{{ errors.name[0] }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputSubject">Subject:</label>
                        <input type="text" id="inputSubject" class="form-control" v-model="fields.email_subject" :class="[errors && errors.email_subject ? 'border-danger' : '']">
                        <div v-if="errors && errors.email_subject" class="badge badge-danger">{{ errors.email_subject[0] }}</div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="active">Status:</label>
                        <div class="custom-control custom-switch my-2">
                            <input type="checkbox" class="custom-control-input" id="active" v-model="fields.active" value="0">
                            <label class="custom-control-label" for="active">Set as Active</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="inputContent">Body:</label>
                        <ckeditor :editor="editor" :config="editorConfig" v-model="fields.email_content" tag-name="textarea"></ckeditor>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <v-client-table :data="templateList" :columns="columns" :options="options" ref="templateTable">
                            <div class="btn-group" slot="actions" slot-scope="{row}">
                                <a href="#directEdit" class="btn btn-primary btn-sm" @click="edit(row)"> <i class="fas fa-edit"> </i></a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="remove(row.id)"> <i class="fas fa-trash"> </i></a>
                            </div>
                            <span slot="active" slot-scope="{row}" :class="'badge '+[row.active? 'badge-success' : 'badge-danger']">{{ row.active? 'Active' : 'Inactive' }}</span>
                    </v-client-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    name: 'emailtemplate',
    data () {
        return {

            // Fetch Template List
            templateList : [],

            // Save/Update Data Action
            fields: {},
            errors: {},
            loaded: false,
            
            // Vue-Tables-2 Syntax
            columns: ['id', 'name', 'active', 'created_at', 'actions'],
            options: {
                initialPage:1,
                perPage:10,
                highlightMatches:true,
                sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
                headings: {
                    id: '#',
                    name: 'Template Name',
                    active: 'Status',
                    created_at: 'Date Created',
                    actions: 'Actions'
                },
                sortable: ['id', 'name', 'active', 'created_at'],
                rowClassCallback(row) {
                    return row.id = row.id;
                },
                columnClasses: {id: 'class-is'},
                texts: {
                    filter: "Search:",
                    filterPlaceholder: "Search keywords",
                }
            },

            // ckEditor
            editor: ClassicEditor,
            editorConfig: {
                toolbar: [ 'undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', '|', 'link', 'blockQuote', 'insertTable',],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' },
                    ]
                },
                placeholder: "Compose email content",
            },
        }
    },
    watch: {
        fields: function (value) {
            if (value.name != null) {
                this.errors.name = "";
            }
            if (value.email_subject != null) {
                this.errors.email_subject = "";
            }
        }
    },
    created() {
        this.fetchTemplates();
    },
    methods: {
        fetchTemplates() {
            axios.get('/email-templates/list/templates').then(response => {
                this.templateList =  response.data;
            });
        },
        saveCreateUpdate() {
            axios({
                method: 'put',
                url: '/email-templates/store-update/template',
                data: this.fields,
            }).then(response => {
                this.fields = {};
                this.fetchTemplates();
                Toast.fire({
                    // position: 'top-end',
                    type: 'success',
                    title: 'Email Template saved successfully',
                    background: '#DCEDC8',
                })
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                    Toast.fire({
                        // position: 'top-end',
                        type: 'error',
                        title: 'Opss..Email template was not saved',
                        background: '#ffcdd2',
                    })
                }
            });
        },
        edit (row) {
            this.fields = row;
            // console.log(row);
        },
        remove (id) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    axios({
                        method: 'get',
                        url: '/email-templates/delete/' + id,
                    }).then(response => {
                        swal.fire(
                            'Deleted!',
                            'Email template has been deleted.',
                            'success'
                        );
                        this.fetchTemplates();
                    });
                }
            });
        }
    }
}
</script>

<style>
  .ck-editor .ck-content{
      height: 200px !important;
  }
</style>