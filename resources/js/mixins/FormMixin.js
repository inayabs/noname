const Toast = swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
});
export default {
    data() {
        return {
            fields: {}, errors: {}, loaded: true, action: '', method: '', isModal: '', isValid: false, success: false,
        }
    },
    methods: {
        // Create Method
        create() {
            if (this.loaded) {
                this.loaded = false;
                this.errors = {};
                axios({method: this.method,url: this.action,data: this.fields,
                }).then(response => {
                    this.fields = {};
                    this.loaded = true;
                    this.success = true;

                    if(this.isModal === "true") {
                        this.$parent.$modal.hide('size-modal');
                    }
                    
                    Toast.fire({
                        // position: 'top-end',
                        type: 'success', title: 'Data is saved successfully',
                    });
                }).catch(error => {
                    this.loaded = true;
                    this.success = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        Toast.fire({
                            // position: 'top-end',
                            type: 'error', title: 'Opss.. data was not saved',
                        });
                    }
                });
                
            }
        },
        // Update Method
        update() {
            if (this.loaded) {
                this.loaded = false;
                this.errors = {};
                axios({method: this.method,url: this.action,data: this.fields,
                }).then(response => {
                    this.loaded = true;
                    Toast.fire({
                        // position: 'top-end',
                        type: 'success', title: 'Data is updated successfully',
                    });
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                        Toast.fire({
                            // position: 'top-end',
                            type: 'error', title: 'Opss.. data was not updated',
                        });
                        
                    }
                });
            }
        }
    }
}