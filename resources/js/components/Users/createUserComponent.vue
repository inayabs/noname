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
        width="40%"
        height="auto"
        @before-open="beforeOpen"
        @opened="opened"
        @closed="closed"
        @before-close="beforeClose">
  <div class="size-modal-content">
    <h4>Add User</h4>
    <form @submit.prevent="validateSubmit">
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.firstname ? 'has-error' : '']" >
                  <label for="firstname">Firstname</label>
                  <input 
                    id="firstname" 
                    name="firstname" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="text" 
                    v-model="user.firstname">
                  <span v-if="errors.firstname" :class="['badge badge-danger']">{{ errors.firstname[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.lastname ? 'has-error' : '']" >
                  <label for="lastname">Lastname</label>
                  <input 
                    id="lastname" 
                    name="lastname" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="text" 
                    v-model="user.lastname">
                  <span v-if="errors.lastname" :class="['badge badge-danger']">{{ errors.lastname[0] }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div :class="['form-group', errors.username ? 'has-error' : '']" >
                  <label for="username">Username</label>
                  <input 
                    id="username" 
                    name="username" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="text" 
                    v-model="user.username">
                  <span v-if="errors.username" :class="['badge badge-danger']">{{ errors.username[0] }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div :class="['form-group', errors.password ? 'has-error' : '']" >
                  <label for="password">Password</label>
                  <input 
                    id="password" 
                    name="password" 
                    value=""  
                    autofocus="autofocus" 
                    class="form-control" 
                    type="password" 
                    v-model="user.password">
                  <span v-if="errors.password" :class="['badge badge-danger']">{{ errors.password[0] }}</span>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
</modal>
</template>
<script>

  export default {
    name: 'SizeModalTest',
    props: ['id', 'firstname', 'lastname', 'username', 'password'],
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
    data () {
      return {
        value: '',
        user : {
            id : '',
            firstname: '',
            lastname: '',
            username: '',
            password: ''
            
        },
        user_id : '',
        csrf: '',
        errors: [],
        success : false  
      }
    },
    methods: {
      validateSubmit(){
        // consol.log('yo');
        let dataform = new FormData();
        dataform.append('firstname', this.user.firstname);
        dataform.append('lastname', this.user.lastname);
        dataform.append('username', this.user.username);
        dataform.append('password', this.user.password);

          axios.post('/user', dataform).then( response => {
              if(response.data.status == "errors"){
                this.errors = response.data.errors;
              }else{
                this.errors = [];
                this.user.firstname = '';
                this.user.lastname = '';
                this.user.username = '';
                this.user.password = '';
                this.success = true;
                Toast.fire({
                  type: 'success', title: 'Data is saved successfully',
                });
                this.$parent.fetchUsers();
                this.$modal.hide('size-modal');
              }
          })
          .catch((err) => {
            console.log(err);
            // this.errors = error.response.data.errors;
            // this.success = false;
        });
      },
      beforeOpen (e) {
            // console.log(e);
            this.user.id = e.params.id || null;
            this.user.firstname = e.params.firstname;
            this.user.lastname = e.params.lastname;
            this.user.username = e.params.username;
            this.user.password = e.params.password;
            this.edit = e.params.edit || false;
            this.user_id = e.params.user_id || null;
        // this.fetchCourses();
        },
        beforeClose (e){

        },
        opened (e) {
        // e.ref should not be undefined here
            // console.log('opened', e)
            // console.log('ref', e.ref)
        },
        closed (e) {
            console.log('closed', e)
        }
    }
  }
</script>
<style>
  .size-modal-content {
    padding: 10px;
    font-style: 13px;
  }
  .v--modal-overlay[data-modal="size-modal"] {
    background: rgba(0, 0, 0, 0.5);
  }
  .demo-modal-class {
    border-radius: 5px;
    background: #F7F7F7;
    box-shadow: 5px 5px 30px 0px rgba(46,61,73, 0.6);
  }
</style>