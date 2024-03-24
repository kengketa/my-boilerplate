<template>
    <Layout>
        <form @submit.prevent="submit()">
            <div class="w-80">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Role Name</span>
                    </div>
                    <input v-model="form.name" class="input input-bordered w-full"
                           placeholder="Type here"
                           type="text"/>
                </label>
                <div class="mt-4">
                    <img :src="displayImage" @click="$refs.fileInput.click()">
                </div>
                <div>
                    <input ref="fileInput" class="hidden" type="file" @change="handleFileUpload">
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-primary uppercase btn-sm mt-2" type="submit">Submit</button>
                </div>
            </div>
        </form>

    </Layout>

</template>
<script>
import Layout from "@/Pages/Dashboard/Layout/Layout.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {router} from "@inertiajs/vue3";

export default {
    name: "RoleEdit",
    components: {Layout},
    props: {
        role: {
            type: Object,
            required: true
        }
    },
    mounted() {
        this.displayImage = this.role.image;
    },
    data() {
        return {
            form: useForm({
                name: this.role.name,
                image: null
            }),
            displayImage: null
        };
    },
    methods: {
        handleFileUpload(event) {
            const files = Array.from(event.target.files);
            const url = URL.createObjectURL(files[0]);
            this.displayImage = url;
            this.form.image = files[0];
        },
        async submit() {
            const url = this.route('dashboard.roles.update', this.role.id);
            await router.post(url, {
                _method: 'patch',
                name: this.form.name,
                image: this.form.image
            });
        }
    }
};
</script>
