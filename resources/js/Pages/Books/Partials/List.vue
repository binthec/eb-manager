<script setup>
import {computed, onBeforeUpdate, provide, reactive, ref, watch} from "vue";
import useFormatDate from "@/Composables/FormatDate.js";
import _ from "lodash";

// コンポーネント
import ViewModal from "@/Components/ViewModal.vue";
import DeleteModal from "@/Components/DeleteModal.vue";

const {getJADate} = useFormatDate();
const props = defineProps(['books']);
const books = computed(() => props.books);

const viewModal = reactive({
    show: false,
    book: {}
});

const delModal = reactive({
    show: false,
    book: {},
    deleted: false,
});

// アップロードされたかどうかの状態を持つ
const uploaded = ref(false);
// アップロードされたファイルのID
const uploadedId = ref(0);

/**
 * アップロードされたばかりのcardには、目立つように数秒枠を表示する
 * @param card_id
 * @returns {boolean}
 */
function isUploadedCard(card_id) {
    return uploaded.value && card_id === uploadedId.value;
}

/**
 * 削除完了した際に、削除済み画像があった場所に数秒空枠を表示する
 */
watch((books), (newVal, oldVal) => {
    console.log('oldVal.length = ' + oldVal.length);
    console.log('newVal.length = ' + newVal.length);
    console.log('変更を検知！');

    if (newVal.length < oldVal.length) {
        console.log('削除されました！');
        delModal.deleted = true;
    } else if (newVal.length > oldVal.length) {
        uploaded.value = true;
        uploadedId.value = _.head(newVal).id;
        setTimeout(() => {
            // 枠が消えた後に、値は初期化する
            uploaded.value = false;
            uploadedId.value = 0;
        }, 1500);
    }
});

/**
 * 削除モーダルは削除後に値をscript内で変更する必要があるため provide して
 * 親の値と双方向にやりとり出来るようにする
 */
provide('delModal', delModal);
</script>

<template>
    <div class="row row-cols-4 border-top-0">
        <div v-show="delModal.completed === true" class="col mb-3">
            <div class="card h-100 deleting-card d-flex align-items-sm-center">
                <p class="mb-0">削除済</p>
            </div>
        </div>
        <div class="col mb-3" v-for="(book) in books">
            <div class="card h-100 position-relative">
                <div v-show="isUploadedCard(book.id)" class="is-uploaded"></div>
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
                        <i class="bi bi-file-earmark-image text-success"/>
                    </span>
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
.is-uploaded {
    border: solid 5px #54c5cb;
    position: absolute;
    height: 100%;
    width: 100%;
    animation: fadeout-anime 1s linear forwards;
}

@keyframes fadeout-anime {
    100% {
        opacity: 0;
    }
}

.deleting-card {
    border: dashed 2px #babbbc;
    border-radius: 0.3rem;

    .p {
        margin: auto 0;
    }
}

.card,
.img-box,
.card-footer {
    overflow: hidden;
}

img {
    transition: transform 0.3s;
}

img:hover,
.card-footer span:hover {
    cursor: pointer;
    transform: scale(1.2);
}
</style>
