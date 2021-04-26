<template>
    <div>
        <nav-bar></nav-bar>
        <div class="base-block">
            <p>This is private page - Users</p>

            <div class="card card-container">
                <transition name="fade">
                    <ul v-if="listUsers.length > 0">
                        <li v-for="user in listUsers">
                            <strong>Name:</strong> {{ user.name }},
                            <strong>Email:</strong> {{ user.email }}
                        </li>
                    </ul>
                </transition>

                <p v-if="listUsers.length < 1">List of users is empty</p>
            </div>
        </div>
    </div>
</template>

<script>
import error_handler_mixin from '../../mixins/error-handler';

export default {
    name: 'Users',
    mixins: [error_handler_mixin],
    data() {
        return {
            loading: false,
            successful: false,
            message: '',
            current_page: 0,
            last_page: 0,
        };
    },
    computed: {
        listUsers() {
            return this.$store.state.user.users;
        },
    },
    beforeRouteEnter (to, from, next) {
        next(vm => {
            vm.initData(to.query.page);
            next();
        })
    },
    // when route changes and this component is already rendered,
    // the logic will be slightly different (for prev and next button).
    beforeRouteUpdate (to, from, next) {
        this.current_page = 0;
        this.last_page = 0;
        this.$store.commit('clearUsers');
        this.initData(to.query.page);
        next();
    },
    methods: {
        initData(page) {
            this.current_page = 0;
            this.last_page = 0;
            this.$store.dispatch('getListUsers', page)
                .then(response => {

                    console.log(response);

                    if (response.data.status === 'success') {
                        this.successful = true;
                        if (this.listUsers.length > 0) {
                            this.current_page = response.data.currentPage;
                            this.last_page =  response.data.lastPage;
                        }
                    } else {
                        this.successful = false;
                        this.message = 'Something is wrong';
                        this.$toast.error(message);
                    }

                    this.loading = false;
                })
                .catch(error => {
                    this.successful = false;
                    this.loading = false;
                    this.handleErrors(error.response);
                });
        },
    }
};
</script>

<style>
    .card-container.card {
        max-width: 70% !important;
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
    .fade-enter-active, .fade-leave-active {
        transition: opacity .7s;
    }
    .fade-enter, .fade-leave-to{
        opacity: 0;
    }
    .alink:hover,
    .alink.router-link-active,
    .alink.router-link-exact-active {
        color: indianred;
        cursor: pointer;
        font-weight: 900;
        text-decoration: none;
    }
</style>
