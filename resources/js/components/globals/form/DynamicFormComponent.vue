<template>
    <div>
        <div v-for="(form, key) in this.formSettings" :key="key">
            <div class="horizontal-line-wrapper mb-2">
                <h6>{{form.FormTitle}}</h6>
            </div>
            <div class="clearfix"></div>
            <div class="form-padding-left-right">
                <div class="row">
                    <div v-for="(itm, k) in form.FormBody" :key="k" v-bind:class="typeof itm['col_size'] !== 'undefined' ? 'col-md-'+itm['col_size'] : 'col-md-6'">
                        <div v-if="itm['type'] === 'text'">
                            <!-- text -->
                            <div class="form-group">
                                <label for="company_name">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span> <span class="font-weight-bold" v-if="typeof itm['optional'] !== 'undefined'"><em>(Optional)</em></span></label>
                                <input class="form-control" v-bind:name="itm['name']" type="text" v-if="typeof itm['readOnly'] !== 'undefined'" readonly v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                <input class="form-control" v-bind:name="itm['name']" type="text" v-else v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div>
                        </div>
                        <div v-else-if="itm['type'] === 'select'">
                            <!-- selectbox -->
                            <div class="form-group">
                                <label for="agent_type">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <select name="agent_type" class="form-control" v-model="inputs[itm['name']] = itm['value']">
                                    <option v-for="(opt, optKy) in itm['items']" v-bind:key="optKy" v-bind:value="optKy">{{opt}}</option>
                                </select>
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div>
                        </div>
                        <div v-else-if="itm['type'] === 'date'">
                            <!-- selectbox -->
                            <!-- <div class="form-group">
                                <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <select v-bind:name="itm['name']" class="form-control" v-model="inputs[itm['name']] = itm['value']">
                                    <option v-for="(opt, optKy) in itm['items']" v-bind:key="optKy" v-bind:value="optKy">{{opt}}</option>
                                </select>
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div> -->

                            <div class="form-group">
                                <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <date-picker  locale="en" v-model="inputs[itm['name']] = itm['value']"></date-picker>
                                <!-- <div v-if="errors && errors['acs.registered_gst_date']" class="badge badge-danger">{{ errors['acs.registered_gst_date'][0] }}</div> -->
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div>

                        </div>
                        <div v-else-if="itm['type'] === 'checkbox'">
                            <!-- checkbox -->
                            <div class="form-group">
                                <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <div class="custom-control custom-switch my-2">
                                    <input type="checkbox" class="custom-control-input" v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                    <label class="custom-control-label" v-bind:for="itm['name']"></label> 
                                    <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="itm['type'] === 'number'">
                            <!-- number -->
                            <div class="form-group">
                                <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <input class="form-control" v-bind:name="itm['name']" type="number"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div>
                        </div>
                        <div v-else-if="itm['type'] === 'radio'">
                            <!-- radiobox -->
                        </div>
                        <div v-else-if="itm['type'] === 'email'">
                            <!-- emailbox -->
                            <div class="form-group">
                                <label for="company_name">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <input class="form-control" v-bind:name="itm['name']" type="email"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div>
                        </div>
                        <div v-else-if="itm['type'] === 'password'">
                            <!-- passwordbox -->
                            <div class="form-group">
                                <label for="company_name">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <input class="form-control" v-bind:name="itm['name']" type="password"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']">
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div>
                        </div>
                        <div v-else-if="itm['type'] === 'textbox'">
                            <!-- textbox -->
                            <div class="form-group">
                                <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <textarea class="form-control" v-bind:name="itm['name']"  v-bind:id="itm['name']" v-model="inputs[itm['name']] = itm['value']"></textarea>
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div>
                        </div>
                        <div v-else-if="itm['type'] === 'multiselect'">
                            <!-- multiselect -->
                            <div class="form-group">
                                <label v-bind:for="itm['name']">{{itm['label']}} <span v-if="typeof itm['required'] !== 'undefined'">*</span></label>
                                <multiselect 
                                    v-model="inputs[itm['name']] = itm['value']" 
                                    :options="itm['selections']" 
                                    :multiple="true"  
                                    placeholder="Type to search" 
                                    :close-on-select="false"  
                                    track-by="value" 
                                    label="value"
                                >
                                    <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                                </multiselect>
                                <div v-if="errors && errors['inputs.'+itm['name']]" class="badge badge-danger">{{ errors['inputs.'+itm['name']][0] }}</div>
                            </div>
                        </div>
                        <div v-if="itm['type'] === 'plus'">
                            <!-- start plus -->
                            <a class="btn btn-success text-white mb-2" @click="addPlusRow(itm['inputs'])"><i class="fas fa-plus-circle"></i></a>
                            <div class="card shadow mb-4" v-for="(getRow, kk) in inputs.plus" :key="kk">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- {{kk}} -->
                                        <div v-for="(i, key) in itm['inputs']" :key="key" v-bind:class="typeof i['col_size'] !== 'undefined' ? 'col-md-'+i['col_size'] : 'col-md-6'">
                                            <div v-if="i['type'] === 'text'">
                                                <div class="form-group">
                                                    <label for="company_name">{{i['label']}} <span v-if="typeof i['required'] !== 'undefined'">*</span> <span class="font-weight-bold" v-if="typeof i['optional'] !== 'undefined'"><em>(Optional)</em></span></label>
                                                    <input class="form-control" v-bind:name="i['name']" type="text" v-if="typeof i['readOnly'] !== 'undefined'" readonly v-bind:id="i['name']" v-model="inputs.plus[kk][i['name']]">
                                                    <input class="form-control" v-bind:name="i['name']" type="text" v-else v-bind:id="i['name']" v-model="inputs.plus[kk][i['name']]">
                                                    <!-- <div v-if="errors && errors['inputs.plus.'+i['name']]" class="badge badge-danger">{{ errors['inputs.plus.'+i['name']][0] }}</div> -->
                                                </div>
                                            </div>
                                            <div v-if="i['type'] === 'textarea'">
                                                <div class="form-group">
                                                    <!-- <label for="company_name">{{i['label']}} <span v-if="typeof i['required'] !== 'undefined'">*</span> <span class="font-weight-bold" v-if="typeof i['optional'] !== 'undefined'"><em>(Optional)</em></span></label>
                                                    <input class="form-control" v-bind:name="i['name']" type="text" v-if="typeof i['readOnly'] !== 'undefined'" readonly v-bind:id="i['name']" v-model="inputs.plus[kk][i['name']]">
                                                    <input class="form-control" v-bind:name="i['name']" type="text" v-else v-bind:id="i['name']" v-model="inputs.plus[kk][i['name']]"> -->

                                                    <label v-bind:for="i['name']">{{i['label']}} <span v-if="typeof i['required'] !== 'undefined'">*</span></label>
                                                    <textarea class="form-control" v-bind:name="i['name']"  v-bind:id="i['name']" v-model="inputs.plus[kk][i['name']]"></textarea>
                                                    <!-- <div v-if="errors && errors['inputs.'+i['name']]" class="badge badge-danger">{{ errors['inputs.'+i['name']][0] }}</div> -->
                                                    <!-- <div v-if="errors && errors['inputs.plus.'+i['name']]" class="badge badge-danger">{{ errors['inputs.plus.'+i['name']][0] }}</div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <a class="btn btn-danger text-white float-right" @click="removePlusRow(kk, getRow['id'])"><i class="fas fa-minus-circle"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- end plus -->
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 pull-right text-right">
                <button class="btn btn-success btn-lg" @click="saveChanges()" ><i class="far fa-save"></i> Save</button>
            </div>
        </div>
        
    </div>
</template>


<script>

    import FormTitle from "./FormTitleComponent.vue";

    export default {
        components: {
            FormTitle
        },
        props : {
            formSettings : Array,
            formValues : Object,
            getPlusRow : Array,
            getId : Number,
            saveForm: String,
            deletePlusRoute: String,
        },
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data() {
            return {
                // inputs: this.formValues,
                inputs: {
                    plus:[],
                    id: typeof this.getId !== 'undefined' ? this.getId : 0,
                },
                csrfToken: '',
                errors: [],
                rowCount: 1,
                plusRow: typeof this.getPlusRow !== 'undefined' ? this.getPlusRow : [],
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                // console.log(this.plusRow);
                // console.log(this.inputs);

                // console.log();
                // if(this.$parent.fetchPlus()){
                    // console.log('sulod dri');
                    // this.plusRow = [];
                    this.$parent.fetchPlus();
                // }

                // console.log(this.plusRow);

                // if(typeof this.plusRow !== 'undefined'){
                    
                //     this.plusRow.forEach((element) => {
                //         // console.log(element);
                //         this.inputs.plus.push(element);
                //     });
                // }

            },
            addPlusRow(itms){
                let row = this.plusRow.length;
                this.inputs.plus.push({});
            },
            removePlusRow(key, id){
                if(id){
                    let vm = this;
                    swal.fire({
                        title: 'Are you sure delete Director?',
                        text: " choose wisely...",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            axios.delete(vm.deletePlusRoute+id)
                            .then(function(res){
                            // vm.files = res.data;
                            if(res.data.status == 'success'){
                                swal.fire(
                                    'Deleted!',
                                    'Staff Info has been deleted.',
                                    'success'
                                )
                                // console.log(key);
                                vm.inputs.plus.splice(key, 1);
                            }
                            })
                            .catch(function(error){
                            });
                        }
                    });

                }else{        
                    this.inputs.plus.splice(key, 1);
                }
            },
            saveChanges() {
                // console.log(this.inputs);
                // console.log(this.saveForm);
                // alert(this.csrfToken);

                axios.post(this.saveForm,{
                    inputs: this.inputs,
                    _token: this.csrfToken
                })
                .then(res => {
                    console.log(res);
                    if(res.data.status == 'success'){
                         Toast.fire({
                            // position: 'top-end',
                            type: 'success', title: 'Changes saved successfully',
                        })
                        this.errors = [];
                        // this.inputs.plus = [];
                        this.fetchData();
                    }else{
                         Toast.fire({
                            // position: 'top-end',
                            type: 'error', title: typeof res.data.message !== 'undefined' ? res.data.message : 'Opss.. was not saved successfully',
                        })
                        this.errors = res.data.data;
                    }
                })
                .catch(err => console.log(err));
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