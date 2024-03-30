<script setup>
import {provide, reactive} from "vue";
import useFormatDate from "@/Composables/FormatDate.js";

// コンポーネント
import ViewModal from "@/Components/ViewModal.vue";
import DeleteModal from "@/Components/DeleteModal.vue";

defineProps(['books']);
const {getJADate} = useFormatDate();

const viewModal = reactive({
    show: false,
    book: {}
});

const delModal = reactive({
    show: false,
    book: {}
});

provide('delModal', delModal);
</script>

<template>
    <div class="row row-cols-4 border-top-0">
        <div class="col mb-3" v-for="(book) in books">
            <div class="card h-100">
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

<style scoped>
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
