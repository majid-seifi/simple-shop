<template>
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="login">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" v-model="user.email">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" v-model="user.password">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <pre dir="ltr" class="text-danger">{{ error }}</pre>
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "Login",
    created() {
        if (this.$store.state.auth.status.loggedIn) {
            this.$router.push("/");
        }
    },
    data() {
        return {
            user: {
                email: "",
                password: "",
            },
            error: '',
        }
    },
    methods: {
        login() {
            this.$store.dispatch("auth/login", this.user).then(
                () => {
                    this.$router.push({name: "productIndex"})
                },
                (error) => {
                    this.error = JSON.stringify(error.response.data, null, 4);
                    console.log(error);
                }
            );
        }
    }
}
</script>
