<script setup>
import {computed, inject, provide, reactive, ref, watch} from "vue";
import useFormatDate from "@/Composables/FormatDate.js";
import _ from "lodash";

// コンポーネント
import ViewModal from "@/Components/ViewModal.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import {Link} from "@inertiajs/vue3";

const {getJADate} = useFormatDate();
const toast = inject('customToast'); // toast を使うので inject する

const props = defineProps(['books']);
const books = computed(() => props.books);

const uploaded = ref(false); // アップロード直後かどうかの状態を持つ
const uploadedId = ref(0);   // アップロードされた直後のレコードID

const viewModal = reactive({
    show: false,      // viewModal の表示・非表示の状態
    book: {}          // 表示する対象の book
});

const delModal = reactive({
    show: false,      // delModal の表示・非表示の状態
    book: {},         // 削除する対象の book
    deleting: false,  // 削除実行中であるかの状態を持つ
});

/**
 * 削除モーダルはファイル削除後に値を script 内で変更し、
 * 親子コンポーネントで双方向にバインディングする必要があるため provide する
 */
provide('delModal', delModal);

/**
 * book_id を持つ card がアップロード直後のものかどうかの判定
 * @param book_id
 * @returns {boolean}
 */
function isUploadedCard(book_id) {
    return uploaded.value && book_id === uploadedId.value;
}

/**
 * book_id をもつ card が削除中かどうかの判定
 * @param book_id
 * @returns {boolean}
 */
function isDeletingCard(book_id) {
    return delModal.deleting && book_id === delModal.book.id;
}

/**
 * アップロード関連の toast にわたす情報をセット
 * @param flag
 * @param id
 */
function setUploaded(flag = false, id = 0) {
    uploaded.value = flag; // アップロードされた直後かどうか
    uploadedId.value = id; // アップロードされたファイルのIDを設定
}

/**
 * books を監視し、変化があった際に card の表示を変化させる
 */
watch((books), (newVal, oldVal) => {
    toast.show = true;
    if (newVal.length > oldVal.length) {           // ファイルがアップロードされた【後】の処理
        setUploaded(true, _.head(newVal).id); // upload直後のファイル情報をセット
        toast.type = 'uploaded';                   // toast のタイプを設定する
        setTimeout(() => {                 // n秒後に初期化する
            setUploaded();
        }, 3000);
    } else if (newVal.length < oldVal.length) { // 削除後の処理
        delModal.deleting = false; // 削除フラグを初期化
        delModal.book = {};        // book を初期化
        toast.type = 'deleted';　  // toast のタイプを設定する
    }
});
</script>

<template>
    <div class="row row-cols-4 border-top-0">
        <div class="col mb-3" v-for="(book) in books">
            <div class="card h-100 position-relative">
                <div v-show="isUploadedCard(book.id)" class="is-uploaded"></div>
                <div v-show="isDeletingCard(book.id)" class="is-deleting"><p>削除中...</p></div>
                <div class="img-box">
                    <img :src="'storage/' + book.filepath" class="align-self-center" loading="lazy"
                         @click="viewModal.show = true"/>
                </div>
                <div class="card-body bg-light">
                    【ID:{{ book.id }}】{{ book.filename }}<br/>
                    <span class="text-sm text-secondary">{{ getJADate(book.created_at) }}</span>
                </div>
                <div class="card-footer text-xl bg-white d-flex justify-content-evenly">
                    <span class="pl-2 pr-2 control-btn rounded-lg"
                          @click="viewModal.show = true; viewModal.book = book">
                        <i class="bi bi-binoculars-fill text-primary"/>
                    </span>

                    <Link class="pl-2 pr-2 control-btn rounded-lg">
                        <i class="bi bi-pencil-square text-success"/>
                    </Link>

                    <span class="pl-2 pr-2 control-btn rounded-lg"
                          @click="delModal.show = true; delModal.book = book">
                        <i class="bi bi-trash3-fill text-danger"/>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <ViewModal :modal="viewModal"/>
    <DeleteModal/>
</template>

<script>
export default {
    name: "List"
}
</script>

<style lang="scss" scoped>
/**
 * アップロード【直後】の card に枠をつけて強調する
 */
.is-uploaded {
    border: solid 5px #76e17f;
    position: absolute;
    height: 100%;
    width: 100%;
    animation: auto-hide 3s linear forwards;
}

@keyframes auto-hide {
    33% {
        opacity: 0;
    }
    66% {
        opacity: 100;
    }
    100% {
        opacity: 0;
    }
}

/**
 * 削除【中】の card にオーバーレイして強調する
 */
.is-deleting {
    border: dashed 2px #babbbc;
    border-radius: 0.3rem;
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 10;
    background-color: rgba(255, 255, 255, 0.8);

    display: flex;
    align-items: center;

    p {
        width: 100%;
        text-align: center;
        font-weight: bold;
        font-size: x-large;
        color: gray;
    }
}

/**
 * common
 */
.card,
.img-box,
.card-footer {
    overflow: hidden;
}

.hover-action {
    cursor: pointer;
    transform: scale(1.2);
}

img {
    transition: transform 0.3s;
    &:hover {
        @extend .hover-action;
    }
}

.card-footer {
    span:hover,
    a:hover{
        @extend .hover-action;
    }
}
</style>
