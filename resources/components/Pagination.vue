<template>
    <div v-if="links.length > 3">
        <nav aria-label="...">
            <ul class="pagination">
                <template v-for="(link, key) in links" :key="key">
                    <li class="page-item" :class="{ 'active': link.active, 'disabled': link.url === null }">
                        <a class="page-link" v-if="link.url === null" v-html="link.label" />
                        <router-link
                            v-else
                            class="page-link"
                            :to="link.url"
                            v-html="link.label"
                        />
                    </li>
                </template>
            </ul>
        </nav>
    </div>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    props: {
        links: Array,
    },
});
</script>
