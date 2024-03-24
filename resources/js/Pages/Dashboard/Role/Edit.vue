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

    },
    data() {
        return {
            form: useForm({
                name: this.role.name
            }),
        };
    },
    methods: {
        submit() {
            const url = this.route('dashboard.roles.update', this.role.id);
            this.form.patch(url);
        }
    }
};
</script>
