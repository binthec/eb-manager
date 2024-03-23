<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import {Head, useForm} from "@inertiajs/vue3";
import {reactive, ref} from "vue";
import {Link} from "@inertiajs/vue3";

import {Modal} from "@kouts/vue-modal";
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

const uploadModal = reactive({
    show: false,
    obj_url: '',
});

defineProps(['books']);

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
    uploadModal.show = false;
}

/**
 * ファイルが選択されたら確認画面を表示する
 * @param event
 */
function onFileSelected(event) {
    let selected_file = event.target.files[0];

    // Modal 用のデータ
    uploadModal.obj_url = URL.createObjectURL(selected_file);
    uploadModal.show = true;

    // 送信用データ
    form.filename = selected_file.name;
    form.file = selected_file;
}
</script>

<template>
    <Head title="Books ー電子帳簿ー"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Electronic Books　電子帳簿</h2>
        </template>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y p-4">
            <form class="pb-4">
                <input class="form-control" type="file" id="formFile" :class="{ 'is-invalid' : form.errors.file }"
                       @change="onFileSelected">
                <InputError :message="form.errors.file"/>
            </form>

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

    <Modal v-model="uploadModal.show" title="以下の内容で登録します">
        <div class="pt-4 pb-4">
            <img :src="uploadModal.obj_url"/>
        </div>
        <button type="button" class="btn btn-outline-secondary justify-between" @click="uploadModal.show = false">
            やめる
        </button>
        <button type="button" class="btn btn-success ml-4 float-end"
                @click="form.post(route('books.store'), { onSuccess: formReset })">
            登録実行
        </button>
    </Modal>

    <ViewModal :modal="viewModal" :filename="viewModal.book.filename">
        <img :src="'storage/' + viewModal.book.filepath"/>
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
