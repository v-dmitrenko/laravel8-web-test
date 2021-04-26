<template>
    <div class="col-md-12">
        <div v-if="message" class="card card-container">
            <h4>Account confirmation</h4>
            <img id="profile-img" src="https://avatanplus.com/files/resources/original/57860b87c0e10155e39d0a6e.png"
                 class="profile-img-card"/>
            <div v-if="message"
                class="alert"
                :class="successful ? 'alert-success' : 'alert-danger'"
            >{{message}}</div>
        </div>
    </div>
</template>

<script>
    import error_handler_mixin from '../../../mixins/error-handler'

    export default {
        mixins: [error_handler_mixin],
        data(){
            return {
                message: '',
                successful: false,
            }
        },
        created() {
            this.confirmEmail();
        },
        methods: {
            confirmEmail() {
                let data = {
                    token: this.$route.params.token,
                    email: this.$route.params.email,
                };
                this.$store.dispatch('confirmEmail', data)
                    .then(response => {
                        if (response.data.status === 'success') {
                            this.$router.push('/');
                        } else {
                            this.successful = false;
                            this.message = 'Sorry your link cannot be identified.';
                        }
                    })
                    .catch(error => {
                        this.handleErrors(error.response);
                    });
            },
        }
    }
</script>

<style scoped>
    label {
        display: block;
        margin-top: 10px;
    }

    .card-container.card {
        max-width: 350px !important;
        padding: 40px 40px;
    }

    .card {
        background-color: #f7f7f7;
        padding: 20px 25px 30px;
        margin: 0 auto 25px;
        margin-top: 50px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    }

    .profile-img-card {
        width: 96px;
        height: 96px;
        margin: 0 auto 10px;
        display: block;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
    }
</style>
