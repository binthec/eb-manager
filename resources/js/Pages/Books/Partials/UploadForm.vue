<script setup>
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import loadImage from "blueimp-load-image"
import useFormatDate from "@/Composables/FormatDate.js";
import _ from "lodash";

const {getJADatetime} = useFormatDate();

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
 * ファイル選択ボタンからファイルが選択された場合
 * @param e
 */
function onFileSelected(e) {
    postFile(e.target.files[0]);
}

/**
 * ファイルを選択ボタン（button要素の方）を押下した場合に、
 * d-none を指定している input id="formFile" を発火する
 * @param e
 */
function fireFileInput(e) {
    document.getElementById('formFile').click();
}

/**
 * drag-area でドラッグオーバーされているかどうかの状態を持つ
 * @type {Ref<UnwrapRef<boolean>>}
 */
const onDragOver = ref(false);

/**
 * ファイルをドラッグオーバー中の処理
 * @param e
 */
function dragOverHandler(e) {
    e.preventDefault(); // 規定の動作を行わない
    onDragOver.value = true;
}

/**
 * ファイルをドロップした時の処理
 * @param e
 */
function dropHandler(e) {
    e.preventDefault(); // 規定の動作を行わない
    onDragOver.value = false;
    postFile(e.dataTransfer.files[0]);
}

/**
 * ファイルが選択されたら確認画面を表示する
 * @param e
 */
function postFile(file) {
    if (file.type === 'application/pdf') {
        // TODO:PDFの際の処理
    } else {
        loadImage.parseMetaData(file, (data) => {
            // 画像の exif データ取得
            let exif = data.exif && data.exif.getAll();

            // 画像情報取得用
            let img = new Image();
            img.src = URL.createObjectURL(file);
            img.onload = (() => {
                setFormData(file, img, exif);
                form.post(route('books.store'), {onSuccess: formReset})
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
function setFormData(file, img, exif) {
    // 送信用データ
    form.file = file;
    form.filename = file.name;
    form.size = file.size;
    form.width = img.naturalWidth;
    form.height = img.naturalHeight;
    form.lastModified = getJADatetime(file.lastModified);

    if (exif) {
        form.XResolution = exif.XResolution;
        form.YResolution = exif.YResolution;
        form.ResolutionUnit = exif.ResolutionUnit;
    }
}
</script>

<template>
    <div class="drop-area" :class="{ 'has-error' : !_.isEmpty(form.errors) }"
         @drop="dropHandler" @dragover="dragOverHandler" @dragleave="onDragOver = false">
        <div v-if="onDragOver === true" class="row m-0 border-0 text-center">
            <div class="col-6">
                <div class="fuwa"><i class="bi bi-cloud-upload-fill"/></div>
            </div>
            <div class="col-6 d-flex align-items-center">
                <p class="mb-0 text-secondary">ドロップするとファイルをアップロードします</p>
            </div>
        </div>
        <div v-else class="row m-0 border-0">
            <div class="col-6 text-center">
                <i class="bi bi-file-earmark-arrow-up"/>
            </div>
            <div class="col-6 text-center d-flex align-items-center">
                <div>
                    <p class="text-secondary text-sm">ファイルをここにドラッグ＆ドロップするか<br/>ファイルを選択してください</p>
                    <button type="button" class="btn btn-outline-secondary" @click="fireFileInput">
                        ファイルを選択
                    </button>
                    <input class="d-none" type="file" id="formFile"
                           :accept="'.png,.jpg,.jpeg'"
                           @change="onFileSelected"/>
                </div>
            </div>
        </div>
    </div>
    <div v-show="form.errors" class="mb-3 border-0">
        <p v-for="error in form.errors" class="text-danger mb-0">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: "UploadForm"
}
</script>

<style lang="scss" scoped>
.drop-area {
    border-radius: 0.5rem;
    background-color: #ececec;
    height: 150px;

    &.has-error{
        border: dashed 2px #ff5252;
    }

    i {
        font-size: 100px;
        color: #c9c9c9;
    }

    .fuwa {
        animation: fuwa 2s infinite;
    }

    @keyframes fuwa {
        0% {
            transform: translateY(25px);
        }
        50% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(25px);
        }
    }
}
</style>
