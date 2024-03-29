<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import {Head, useForm} from "@inertiajs/vue3";
import {reactive, ref} from "vue";
import List from "@/Pages/Books/Partials/List.vue";
import useFormatDate from "@/Composables/FormatDate.js";
import _ from "lodash";

//exifデータ読み込み用
import loadImage from "blueimp-load-image"

// modal
import DeleteModal from "@/Components/DeleteModal.vue";
import ViewModal from "@/Components/ViewModal.vue";

const {getJADatetime} = useFormatDate();

const viewModal = ref({
    show: false,
    book: {},
});

const delModal = ref({
    show: false,
    book: {},
});

defineProps(['books']);

/**
 * 送信用の値
 * @type {InertiaForm<{filename: string, file: null}>}
 */
const form = useForm({
    file: null,
    filename: '',
    size: 0,
    width: 0,
    height: 0,
    lastModified: null,

    // exif情報
    XResolution: null,
    YResolution: null,
    ResolutionUnit: null,
})

/**
 * フォームを初期化
 */
function formReset() {
    document.getElementById('formFile').value = '';
    form.reset();
    form.errors = {};
}

/**
 * ファイルが選択されたら確認画面を表示する
 * @param e
 */
function onFileSelected(e) {
    let selected_file = e.target.files[0];

    if (selected_file.type === 'application/pdf') {
        // TODO:PDFの際の処理
    } else {
        loadImage.parseMetaData(selected_file, (data) => {
            // 画像の exif データ取得
            let exif = data.exif && data.exif.getAll();

            // 画像情報取得用
            let img = new Image();
            img.src = URL.createObjectURL(selected_file);
            img.onload = (() => {
                setFormData(selected_file, img, exif);
                form.post(route('books.store'),{ onSuccess: formReset})
            })
        });
    }
}

/**
 * フォームに値をセット
 * @param selected_file
 * @param img
 * @param exif
 */
function setFormData(selected_file, img, exif) {
    // 送信用データ
    form.file = selected_file;
    form.filename = selected_file.name;
    form.size = selected_file.size;
    form.width = img.naturalWidth;
    form.height = img.naturalHeight;
    form.lastModified = getJADatetime(selected_file.lastModified);

    if (exif) {
        form.XResolution = exif.XResolution;
        form.YResolution = exif.YResolution;
        form.ResolutionUnit = exif.ResolutionUnit;
    }
}
</script>

<template>
    <Head title="Books ー電子帳簿ー"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Electronic Books　電子帳簿</h2>
        </template>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y p-4">
            <form>
                <input class="form-control" type="file" id="formFile"
                       :class="{ 'is-invalid' : !_.isEmpty(form.errors) }"
                       :accept="'.png,.jpg,.jpeg'"
                       @change="onFileSelected"/>
                <div v-show="form.errors" class="mb-3">
                    <p v-for="error in form.errors" class="text-danger mb-0">{{ error }}</p>
                </div>
            </form>
            <List v-if="books.length !== 0" :view-modal="viewModal" :del-modal="delModal" :books="books"></List>
            <div v-else class="books-empty border-top-0">ファイルを登録してください。</div>
        </div>
    </AuthenticatedLayout>
    <ViewModal :modal="viewModal" :book="viewModal.book"></ViewModal>
    <DeleteModal :modal="delModal"></DeleteModal>
</template>

<script>
export default {
    name: "Index.vue"
}
</script>

<style scoped>
ul {
    /*list-style: disc;*/
}
</style>
