<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import {Head, useForm} from "@inertiajs/vue3";
import {reactive, ref} from "vue";
import List from "@/Components/Books/List.vue";

import {Modal} from "@kouts/vue-modal";
import DeleteModal from "@/Components/DeleteModal.vue";
import ViewModal from "@/Components/ViewModal.vue";

const viewModal = ref({
    show: false,
    book: {},
});

const delModal = ref({
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
 * @param e
 */
function onFileSelected(e) {
    let selected_file = e.target.files[0];

    // アップロードモーダル表示用画像
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
                <input class="form-control" type="file" id="formFile"
                       :class="{ 'is-invalid' : form.errors.file }"
                       :accept="'.png,.jpg,.jpeg'"
                       @change="onFileSelected"/>
                <InputError :message="form.errors.file"/>
            </form>
            <List :view-modal="viewModal" :del-modal="delModal" :books="books"></List>
        </div>
    </AuthenticatedLayout>

    <Modal v-model="uploadModal.show" title="以下の内容で登録します">
        <div class="pt-4 pb-4 d-flex justify-content-center">
            <img :src="uploadModal.obj_url" class="selected-img"/>
        </div>
        <button type="button" class="btn btn-outline-secondary justify-between" @click="uploadModal.show = false">
            やめる
        </button>
        <button type="button" class="btn btn-success ml-4 float-end"
                @click="form.post(route('books.store'), { onSuccess: formReset })">
            登録実行
        </button>
    </Modal>

    <ViewModal :modal="viewModal"></ViewModal>
    <DeleteModal :modal="delModal"></DeleteModal>
</template>

<script>
export default {
    name: "Index.vue"
}
</script>

<style scoped>
.selected-img {
    max-height: 500px;
}
</style>
