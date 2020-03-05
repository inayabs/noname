<template>
<div class="app-modal">
    <user-profile/>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 pl-3 pt-1 m-0">
                        <h5 class="m-0 font-weight-bold text-info">User Details</h5>
                    </div>
                    <div class="col-md-6 pr-2 m-0 text-right">
                        <a class="btn btn-primary btn-sm" href="/users"> <i class="fas fa-arrow-circle-left"></i> Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Info</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                        <div>
                            <div class="clearfix"></div>
                            <div class="horizontal-line-wrapper mb-2">
                                <h6>Login Details</h6>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-padding-left-right">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input class="form-control" name="username" type="text" id="uname" v-model="user.username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input class="form-control" name="password" type="password" id="password" placeholder="leave blank if password will not be changed" v-model="user.change_password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="horizontal-line-wrapper mb-2">
                                <h6>Personal Information</h6>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-padding-left-right">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input class="form-control" name="firstname" type="text" id="fname" v-model="user.party.person.firstname">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Lastname</label>
                                            <input class="form-control" name="lastname" type="text" id="lname" v-model="user.party.person.lastname">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <date-picker locale="en" v-model="user.party.person.date_of_birth"></date-picker>
                                            <!-- <date-picker :max-date="new Date()" v-model="issue_date" locale="en"></date-picker> -->
                                            <!-- <div v-if="errors && errors['acs.registered_gst_date']" class="badge badge-danger">{{ errors['acs.registered_gst_date'][0] }}</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_of_birth">Gender</label>
                                            <select name="gender" class="form-control" v-model="user.party.person.gender">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="horizontal-line-wrapper mb-2">
                                <h6>Department Details</h6>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-padding-left-right">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id">Role</label>
                                            <multiselect 
                                                v-model="user.roles" 
                                                :options="roles" 
                                                :multiple="true"  
                                                placeholder="Type to search" 
                                                :close-on-select="false"
                                                track-by="id" 
                                                label="name"
                                            >
                                                <span slot="noResult">Oops! No units found. Consider changing the search query.</span>
                                            </multiselect>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role_id">User Role</label>
                                            <select name="role_id" class="form-control" v-model="slct_role">
                                                <option v-for="value in role" v-bind:value="value.id" v-bind:key="value.id">
                                                    {{ value.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_status">Active</label>
                                            <div class="custom-control custom-switch my-2">
                                                <input type="checkbox" class="custom-control-input" id="user_status" v-model="user.is_active">
                                                <label class="custom-control-label" for="user_status"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="horizontal-line-wrapper mb-2">
                                <h6>Email Details</h6>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-padding-left-right">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_address">Email Address</label>
                                            <input class="form-control" name="name" type="email" id="email_address" v-model="user.email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="horizontal-line-wrapper mb-2">
                                <h6>Profile Image</h6>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-padding-left-right">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a @click="editProfile" class="profile-wrapper">
                                            <img :src="avtr_path" alt="profile">
                                            <div class="edit-profile">
                                                <a class="btn btn-link btn-sm float-right"><i class="fas fa-edit"></i></a>
                                            </div>
                                        </a>
                                        <div class="clearfix" style="height:30px"></div>
                                        <!-- <user-profile></user-profile> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 pull-right text-right">
                                    <button class="btn btn-success btn-lg" @click="saveChanges()"><i class="far fa-save"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
</template>
<script>
    import UserProfile from './userProfileComponent.vue';
    import CropUpload from './CropUploadComponent.vue';
    
    export default {
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        components: {
            UserProfile,
            CropUpload
        },
        data() {
            return {
                userList : [],
                avtr_path : '/storage/user/avatars/'+window.user.profile_image,
                department : [],
                departments : window.departments,
                roles : window.roles,
                slct_role : '',
                user : {
                    roles: [],
                    party: {
                        person: {}
                    },
                },
                person : {
                    firstname : "",
                    lastname : ""
                },
                user_id : window.user_id,
                csrfToken: '',
            };
        },
        created(){
            this.fetchUser();
        },
        methods: {
            fetchUser(){
                this.user = window.user;
                console.log(this.user);
                if(this.user.party.person == null){
                    this.user.party.person = {};
                }else{
                    this.user.party.person.date_of_birth = moment(window.user.party.person.date_of_birth)._d;
                }
            },
            saveChanges(){
                // console.log('yo');
                axios.post('/user/show/update/'+user_id,{
                    user : this.user,
                    _token: this.csrfToken
                })
                .then(res => {
                    if(res.data.status == 'updated'){
                        Toast.fire({
                            type: 'success', title: 'Changes is saved successfully',
                        });
                    }else{
                        Toast.fire({
                            type: 'error', title: 'Oops... something went wrong',
                        });
                    }
                })
                .catch(err => console.log(err));
            },
            editProfile () {
                this.$modal.show('size-modal',{
                    avtr_path : '',
                });
            }
        }
    }
</script>

<style>
.tab-pane {border: 1px solid #e0dfdf;border-top: none;padding: 1.3rem;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;background-color: #ffffff;}
.profile-wrapper{display:inline-block;position: relative;}
.profile-wrapper:hover .edit-profile {visibility: visible;opacity: 1;}
.profile-wrapper img{border-radius: 5px;border: solid #ccc 3px;width: 200px;}
.profile-wrapper .edit-profile{width:100%; height: 100%; background-color:#0000002b; position: absolute;top: 0;right: 0;color: #fff !important;opacity: 0;visibility: hidden; -webkit-transition: opacity 600ms, visibility 600ms;transition: opacity 600ms, visibility 600ms;}
</style>