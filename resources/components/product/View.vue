<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        View Product
                        <span v-if="bookmarked" class="text-info small">(Bookmarked)</span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label>Title</label>
                                <h3>{{ product.title }}</h3>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label>Details</label>
                                <p>{{ product.details }}</p>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <pre dir="ltr" class="text-danger">{{ error }}</pre>
                        </div>
                        <div v-if="hasBookmarkPermission" class="col-12 mb-2">
                            <button type="button" @click="bookmark(bookmarked)" class="btn" :class="{'btn-primary': !bookmarked, 'btn-danger': bookmarked}">{{ !bookmarked ? 'Bookmark' : 'UnBookmark' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ProductService from "../../services/product.service";

export default {
    name: "ProductView",
    data() {
        return {
            product: {
                title: "",
                details: "",
                bookmark: false,
            },
            error: '',
        }
    },
    mounted() {
        this.showProduct()
    },
    computed: {
        hasBookmarkPermission() {
            return this.$store.state.auth.accesses ? this.$store.state.auth.accesses.find(item => item === 'Bookmark product') : false;
        },
        bookmarked() {
            return this.product.bookmark;
        },
    },
    methods: {
        showProduct() {
            ProductService.show(this.$route.params.id).then(data => {
                const {title, details, bookmark} = data;
                this.product.title = title;
                this.product.details = details;
                this.product.bookmark = bookmark;
            }).catch(error => {
                console.log(error)
            });
        },
        bookmark(type) {
            ProductService.bookmark(this.$route.params.id, type ? 'remove' : 'save').then(data => {
                const {title, details, bookmark} = data.product;
                this.product.title = title;
                this.product.details = details;
                this.product.bookmark = bookmark;
                // change icon
            }).catch(error => {
                this.error = JSON.stringify(error?.response?.data, null, 4);
                console.log(error);
            })
        }
    }
}
</script>
