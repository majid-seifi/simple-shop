<template>
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                         class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="my-3">{{ profile.name }}</h5>
                </div>
            </div>
            <div class="card mb-4 mb-md-0">
                <div class="card-body">
                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                    </p>
                    <p class="mb-1" style="font-size: .77rem;">Web</p>
                    <div class="progress rounded" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Full Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ profile.name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ profile.email }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Phone</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"> - </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Mobile</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"> - </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Address</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"> - </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <Table title="My Bookmarked Products" :loading="loading" :links="products.links" :products="products.data"></Table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ProfileService from "../services/profile.service";
import Table from "./product/Table.vue";

export default {
    name: "Profile",
    components: {Table},
    beforeRouteUpdate (to, from, next) {
        next();
        this.getProfile(to?.query?.page);
    },
    data() {
        return {
            loading: false,
            profile: {},
            products: {
                data: [],
                links: [],
            },
        }
    },
    mounted() {
        this.getProfile(this.$route?.query?.page);
    },
    methods: {
        getProfile(page) {
            this.loading = true;
            ProfileService.show(page).then(data => {
                this.profile = data.user;
                this.products = data.products;
            }).catch(error => {
                console.log(error)
                this.profile = {};
            }).finally(() => {
                this.loading = false;
            });
        },
    },
}
</script>

<style scoped>

</style>
