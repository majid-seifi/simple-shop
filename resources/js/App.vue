<template>
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <router-link to="/" class="navbar-brand" href="#">Shop</router-link>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item" exact-active-class="active">
                            <router-link to="/" class="nav-link">Dashboard</router-link>
                        </li>
                        <li v-if="loggedIn" class="nav-item" exact-active-class="active">
                            <router-link to="/profile" class=" nav-link">Profile</router-link>
                        </li>
                        <li v-else class="nav-item" exact-active-class="active">
                            <router-link to="/login" class=" nav-link">Login</router-link>
                        </li>
                        <li v-if="loggedIn" class="nav-item" exact-active-class="active">
                            <a href="/logout" @click.prevent="logout" class="nav-link">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <router-view></router-view>
        </div>
    </main>
</template>
<script>
export default {
    methods: {
        logout() {
            this.$store.dispatch('auth/logout');
            this.$router.push('/login');
        }
    },
    computed: {
        loggedIn() {
            return this.$store.state.auth.status.loggedIn;
        },
    },
}
</script>
