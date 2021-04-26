import Vue from "vue";

export default {
    methods: {
        handleErrors(response) {
            if (response.status === 422) {
                let errors = response.data.errors;
                for (let key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        this.$toast.error(errors[key]);
                    }
                }
            } else {
                let message = 'Error ' + response.status + ': ' + response.statusText + '. ' + response.data.message;
                this.$toast.error(message);
            }
        },
    }
 }
