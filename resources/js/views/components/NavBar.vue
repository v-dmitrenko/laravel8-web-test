<template>
    <div>
        <nav class="navbar navbar-expand navbar-dark bg-primary">
            <a href class="navbar-brand" @click.prevent>Company</a>
            <div class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link to="/" class="nav-link">
                        <font-awesome-icon icon="home" />Home
                    </router-link>
                </li>
            </div>

            <div v-if="!currentUser" class="navbar-nav ml-auto">
                <li class="nav-item">
                    <router-link to="/register" class="nav-link">
                        <font-awesome-icon icon="user-plus" />Sign Up
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/login" class="nav-link">
                        <font-awesome-icon icon="sign-in-alt" />Login
                    </router-link>
                </li>
            </div>

            <div v-if="currentUser" class="navbar-nav ml-auto">
                <li class="nav-item">
                    <router-link to="/profile" class="nav-link">
                        <font-awesome-icon icon="user" />
                        {{ currentUser.name }}
                    </router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href @click.prevent=handleLogout>
                        <font-awesome-icon icon="sign-out-alt" />LogOut
                    </a>
                </li>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    computed: {
        currentUser() {
            return this.$store.state.auth.user;
        },
    },
    methods: {
        handleLogout() {
            this.$store.dispatch('logout');
            this.$router.push('/login');
        },
    }
};
</script>
