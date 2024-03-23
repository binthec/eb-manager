<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
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

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y p-4">
            <div class="pb-4">
                <form class="row" @submit.prevent="form.post(route('books.store'), { onSuccess: () => form.reset() })">
                    <div class="col-6">
                        <input class="form-control" :class="{ 'is-invalid' : form.errors.file }" type="file" id="formFile"
                               @change="onFileSelected">
                        <InputError :message="form.errors.file"/>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success">登録</button>
                    </div>
                </form>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr class="text-center table-success">
                    <th>id</th>
                    <th>ファイル名</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(book, index) in books">
                    <td class="text-center">{{ book.id }}</td>
                    <td>{{ book.filename }}</td>
                    <td></td>
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
