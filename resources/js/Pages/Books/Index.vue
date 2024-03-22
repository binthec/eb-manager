<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Head, useForm} from "@inertiajs/vue3";
import {reactive} from "vue";

defineProps(['books']);

const selected_file = reactive({
    name: '',
    data_url: ''
});

const form = useForm({
    name: '',
    file: null
})

/**
 * ファイルを読み込んでArrayBufferとして返します。
 *
 * @param {Blob} file
 * @returns {Promise<Uint8Array>}
 */
function fileToArrayBufferAsync(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.addEventListener("load", (event) => {
            resolve(new Uint8Array(reader.result));
        });
        reader.addEventListener("abort", (event) => {
            reject();
        });
        reader.addEventListener("error", (event) => {
            reject();
        });

        reader.readAsArrayBuffer(file);
    });
};

function onFileSelected(event) {
    console.log('event : ');
    console.log(event);

    selectFile(event.target.files[0]);
}

function selectFile(file) {

    console.log('file : ');
    console.log(file);

    fileToArrayBufferAsync(file)
        .then((buffer) => {
            console.log('buffer : ');
            console.log(buffer);

            selected_file.name = file;
            selected_file.data_url = URL.createObjectURL(file);

            form.name = file.name;
            form.file = file;
        });
}
</script>

<template>
    <Head title="Books ー電子帳簿ー"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Electronic Books　電子帳簿</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">電子帳簿一覧</div>

                    <form @submit.prevent="form.post(route('books.store'), { onSuccess: () => form.reset() })">
                        <input type="file" name="upload_file" @change="onFileSelected"/>
                        <PrimaryButton class="mt-4">submit</PrimaryButton>
                    </form>
                </div>

                <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    <table>
                        <thead>
                        <td>id</td>
                        <td>name</td>
                        </thead>
                        <tbody>
                        <tr v-for="(book, index) in books">
                            <td>{{ book.id }}</td>
                            <td>{{ book.name }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: "Index.vue"
}
</script>

<style scoped>

</style>
