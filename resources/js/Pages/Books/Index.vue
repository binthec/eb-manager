<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import {Head, useForm} from "@inertiajs/vue3";
import {reactive, ref} from "vue";

import DeleteModal from "@/Components/DeleteModal.vue";
import ViewModal from "@/Components/ViewModal.vue";

const delModal = ref({
    show: false,
    targetId: null,
});

const viewModal = ref({
    show: false,
    book: {},
});

defineProps(['books']);

const selected_file = reactive({
    name: '',
    data_url: ''
});

/**
 * 送信用の値
 * @type {InertiaForm<{filename: string, file: null}>}
 */
const form = useForm({
    filename: '',
    file: null
})

/**
 * 登録ボタン押した時の挙動
 */
function formReset() {
    document.getElementById('formFile').value = '';
    form.reset();
}

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
                <form class="row" @submit.prevent="form.post(route('books.store'), { onSuccess: formReset })">
                    <div class="col-6">
                        <input class="form-control" type="file" id="formFile"
                               :class="{ 'is-invalid' : form.errors.file }"
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
                <tr v-for="(book) in books">
                    <td class="text-center">{{ book.id }}</td>
                    <td data-bs-toggle="tooltip" data-bs-title="削除">{{ book.filename }}</td>
                    <td class="text-xl">
                        <span class="pl-2 pr-2 control-btn rounded-lg"
                              @click="viewModal.show = true; viewModal.book = book">
                            <i class="bi bi-file-earmark-image text-success"/>
                        </span>

                        <span class="pl-2 pr-2 control-btn rounded-lg"
                              @click="delModal.show = true; delModal.targetId = book.id">
                            <i class="bi bi-trash3-fill text-danger"/>
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>

    <ViewModal :modal="viewModal" :filename="viewModal.book.filename">
        <img :src="'storage/' + viewModal.book.filepath" />
    </ViewModal>

    <DeleteModal :modal="delModal">
        <p>
            画像ID : {{ delModal.targetId }} を削除します。よろしいですか。<br>
            <span class="text-danger">※この処理は取り消せません。</span>
        </p>
    </DeleteModal>
</template>

<script>
export default {
    name: "Index.vue"
}
</script>

<style scoped>
.control-btn:hover {
    background-color: #e2f0ec;
}
</style>
