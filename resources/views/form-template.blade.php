<template>
    <div>
        <h3>User Details</h3>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-info-tab" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Info</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                <div>
                    <div class="row mb-3">
                        <div class="col-md-12 pull-right text-right">
                            <button class="btn btn-success"><i class="far fa-save"></i> Save Changes</button>
                        </div>
                    </div>
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
                                    <input class="form-control" name="name" type="text" id="uname">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_password">Password</label>
                                    <input class="form-control" name="password" type="text" id="password">
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
                                    <label for="fname">Firstname</label>
                                    <input class="form-control" name="name" type="text" id="fname">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Lastname</label>
                                    <input class="form-control" name="password" type="text" id="lname">
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
                                    <label for="d_type_id">Department Type</label>
                                    <select class="form-control" id="d_type_id">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_role">User Role</label>
                                    <select class="form-control" id="user_role">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_status" class="width-100-percent not-required"><span class="px-12-font proximanova-semibold">User Status</span> </label>
                                    <div class="form-group no-margin" style="margin-top:3px !important;">
                                        <div class="crm-form-switch-toggle">
                                            <input id="switch" name="" type="checkbox" value="1">
                                            <label for="switch" class="no-margin not-required"></label>
                                        </div>
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
                                    <input class="form-control" name="name" type="text" id="email_address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_password">Email Password</label>
                                    <input class="form-control" name="password" type="text" id="email_password">
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
                            <div class="col-md-6">
                                <!-- <div class="form-group">
                                    <label for="email_address">Email Address</label>
                                    <input class="form-control" name="name" type="text" id="email_address">
                                </div> -->
                                <h2>FINE UPLOADER</h2>      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                userList : [],
                user : {
                    id: "",
                    name: "",
                    email: "",
                    department_id: "",
                    role: "",
                    is_active: ""
                },
                user_id : window.user_id,
                pagination : {},
                edit: false
            };
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
.crm-form-switch-toggle input[type="checkbox"] {display: none;}
.crm-form-switch-toggle label {background-color: #fff;border: 1px solid #dfdfdf;border-radius: 20px;cursor: pointer;display: inline-block;height: 25px;position: relative;vertical-align: middle;width: 45px;user-select: none;box-sizing: content-box;background-clip: content-box;border-color: #dfdfdf;box-shadow: #dfdfdf 0px 0px 0px 0px inset;transition: border 0.4s, box-shadow 0.4s;background-color: #ffffff;}
.crm-form-switch-toggle label:after {content: "";background: #fff;border-radius: 100%;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);height: 25px;position: absolute;top: 0;width: 25px;left: 0px;transition: background-color 0.4s, left 0.2s;}
.crm-form-switch-toggle input:checked ~ label {border-color: #59c493;box-shadow: #59c493 0px 0px 0px 16px inset;transition: border 0.4s, box-shadow 0.4s, background-color 1.2s;background-color: #59c493;}
.crm-form-switch-toggle input:checked ~ label:after {left: 20px;transition: background-color 0.4s, left 0.2s;background-color: #ffffff;}
.crm-form-switch-toggle {display:inline-block; margin-right:5px;}
</style>