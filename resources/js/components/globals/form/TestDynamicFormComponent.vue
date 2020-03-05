<template>
    <div>
        <!-- <div class="row mb-3">
            <div class="col-md-12 pull-right text-right">
                <button class="btn btn-success" @click="saveChanges()" ><i class="far fa-save"></i> Save Changes</button>
            </div>
        </div> -->
        <dynamic-form 
        v-bind:form-settings='makeForm' 
        v-bind:form-values='getValues'
        v-bind:save-form='"/save-form/agent/"'
        ></dynamic-form>
        
    </div>
</template>


<script>

    import DynamicForm from "./DynamicFormComponent.vue";


    export default {
        components: {
            DynamicForm
        },
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                agent: {
                    detail:{}
                },
                csrfToken: '',
                getValues : {
                    company_name : 'test',
                    is_active : 1,
                    shore_type : 'OFF-SHORE',
                    notes : 'This is a test note...',
                    edit : 1,
                },
                makeForm : [{
                    FormTitle : 'Agent Information',
                    FormBody : [
                        {
                            type : 'text',
                            lable : 'Company Name',
                            name : 'company_name',
                            value : 'test'
                        },
                        {
                            type : 'checkbox',
                            lable : 'Status',
                            name : 'is_active',
                            value : true
                        },
                        {
                            type : 'select',
                            lable : 'Shore Type',
                            name : 'shore_type',
                            items :{ 
                                    'ON-SHORE' : 'ON SHORE',
                                    'OFF-SHORE' : 'OFF SHORE'
                            },
                            value : 'ON-SHORE'
                        },
                        {
                            type : 'textbox',
                            lable : 'Notes',
                            name : 'notes',
                            col_size : 12,
                            value : 'This is a test note...'
                        },
                        {
                            type : 'multiselect',
                            lable : 'Disabilities',
                            name : 'disabilitie_ids',
                            col_size: 12,
                            selections : [
                                {
                                    id : 11,
                                    value: 'Hearing',
                                },
                                {
                                    id : 12,
                                    value: 'Physical',
                                },
                                {
                                    id : 13,
                                    value: 'Intellectual',
                                },
                                {
                                    id : 14,
                                    value: 'Learning',
                                },
                            ]
                        }                    
                    ]
                }],
            };
        },
        created() {
            this.fetchData();
            // console.log(this);
        },
        methods: {
            fetchData() {
                // // console.log(course_id);
                // axios({
                //     method: 'get',
                //     url: '/agent/show/info/'+ this.agent_id
                // })
                // .then(res => {
                //     this.agent = res.data;
                // })
                // .catch(err => console.log(err));
            },
            saveChanges() {

                // alert(this.csrfToken);

                // axios.post('/agent/show/info/update/'+ this.agent_id,{
                //     agent: this.agent,
                //     _token: this.csrfToken
                // })
                // .then(res => {
                //     console.log(res);
                //     if(res.data.status == 'updated'){
                //          Toast.fire({
                //             // position: 'top-end',
                //             type: 'success', title: 'Changes saved successfully',
                //         })
                //         this.agent = res.data.agent;
                //     }else{
                //          Toast.fire({
                //             // position: 'top-end',
                //             type: 'error', title: 'Opss.. was not saved successfully',
                //         })
                //     }
                // })
                // .catch(err => console.log(err));
            },
        }
    }
</script>

<style>
    .tab-pane {
        border: 1px solid #e0dfdf;
        border-top: none;
        padding: 1.3rem;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        background-color: #ffffff;
    }

</style>