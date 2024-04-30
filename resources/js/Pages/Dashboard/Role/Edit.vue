<template>
    <Layout>
        <form @submit.prevent="submit()">
            <div class="w-full">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Role Name</span>
                    </div>
                    <input v-model="form.name" class="input input-bordered w-full"
                           placeholder="Type here"
                           type="text"/>
                </label>
                <div class="mt-4">
                    <div class="carousel carousel-end rounded-box">
                        <div v-for="(image,index) in displayImages" :key="index" class="carousel-item">
                            <div class="relative">
                                <img :alt="image.name" :src="image.url" class="h-80 w-80"/>
                                <button class="text-red-500 absolute top-2 right-2" type="button"
                                        @click="handleDeleteImage(image)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                         stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div
                            class="w-80 min-h-80  border-dashed border-2 flex items-center justify-center cursor-pointer carousel-item"
                            @click="$refs.fileInput.click()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                    </div>
                </div>
                <!--                <div class="mt-4 flex gap-2 flex-wrap">-->
                <!--                    <div v-for="(image,index) in displayImages" :key="index">-->
                <!--                        <div class="relative w-80 h-80">-->
                <!--                            <img :src="image.url" class="w-full h-full object-cover">-->
                <!--                            <button class="text-red-500 absolute top-2 right-2" type="button"-->
                <!--                                    @click="handleDeleteImage(image)">-->
                <!--                                <svg class="w-6 h-6" fill="none" stroke="currentColor"-->
                <!--                                     stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">-->
                <!--                                    <path-->
                <!--                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"-->
                <!--                                        stroke-linecap="round"-->
                <!--                                        stroke-linejoin="round"/>-->
                <!--                                </svg>-->
                <!--                            </button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="w-80 min-h-80  border-dashed border-2 flex items-center justify-center cursor-pointer"-->
                <!--                         @click="$refs.fileInput.click()">-->
                <!--                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"-->
                <!--                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">-->
                <!--                            <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round"/>-->
                <!--                        </svg>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div>
                    <input ref="fileInput" accept="image/*" class="hidden" multiple type="file"
                           @change="handleFileUpload">
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
        if (this.role.images.data.length > 0) {
            this.role.images.data.forEach(image => {
                this.displayImages.push(image);
            });
        }
    },
    data() {
        return {
            form: useForm({
                name: this.role.name,
                images: [],
                delete_images: []
            }),
            displayImages: []
        };
    },
    methods: {
        handleDeleteImage(image) {
            this.displayImages = this.displayImages.filter(img => {
                return img.url != image.url
            });
            if (image.id === null) {
                return;
            }
            this.form.delete_images.push(image);
        },
        handleFileUpload(event) {
            const files = Array.from(event.target.files);
            files.forEach(file => {
                const image = {
                    id: null,
                    url: URL.createObjectURL(file),
                    name: file.name
                }
                this.displayImages.push(image);
                this.form.images.push(file);
            })
        },
        async submit() {
            const url = this.route('dashboard.roles.update', this.role.id);
            await router.post(url, {
                _method: 'patch',
                name: this.form.name,
                images: this.form.images,
                delete_images: this.form.delete_images
            });
        }
    }
};
</script>
