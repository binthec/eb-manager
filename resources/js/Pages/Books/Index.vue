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
    filename: '',
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

    let selected_file = event.target.files[0];

    console.log('selected_file : ');
    console.log(selected_file);

    fileToArrayBufferAsync(selected_file)
        .then((buffer) => {
            console.log('buffer : ');
            console.log(buffer);

            // selected_file.name = file;
            // selected_file.data_url = URL.createObjectURL(selected_file);

            form.filename = selected_file.name;
            form.file = selected_file;
        });
}
</script>

<template>
    <Head title="Books ー電子帳簿ー"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Electronic Books　電子帳簿</h2>
        </template>

        <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6 lg:mb-8">
            <form @submit.prevent="form.post(route('books.store'), { onSuccess: () => form.reset() })">
                <label for="formFile" class="form-label">ファイルを選択してください</label>
                <input class="form-control" type="file" id="formFile" @change="onFileSelected">
                <PrimaryButton class="mt-4 float-end">submit</PrimaryButton>
            </form>
        </div>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(book, index) in books">
                    <td>{{ book.id }}</td>
                    <td>{{ book.filename }}</td>
                </tr>
                </tbody>
            </table>
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
