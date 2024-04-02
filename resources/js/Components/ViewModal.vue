<script setup>
import {computed, inject} from "vue";
import {Modal} from "@kouts/vue-modal";
import {Link} from "@inertiajs/vue3";
import useFormatDate from "../Composables/FormatDate.js"

const props = defineProps(['modal']);
const book = computed(() => props.modal.book);
const {getJADate, getJADatetime} = useFormatDate();
</script>

<template>
    <div>
        <Modal v-model="modal.show" :title="book.filename" :modal-class="'modal-xl'">
            <div class="row">
                <div class="col-6">
                    <div class="mb-4 d-flex justify-content-center">
                        <img :src="'/storage/' + book.filepath" class="mh-500"/>
                    </div>
                </div>
                <div class="col-6">
                    電子保存情報
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>発行元</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>発行日</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>金額</td>
                            <td></td>
                        </tr>

                        </tbody>
                    </table>

                    アップロード日・サイズ情報
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>アップロード日</td>
                            <td>{{ getJADate(book.created_at) }}</td>
                        </tr>
                        <tr>
                            <td>サイズ</td>
                            <td>{{ Math.round(book.size / 1024) }} KB</td>
                        </tr>
                        <tr>
                            <td>総画素数</td>
                            <td>{{ book.width }} x {{ book.height }}</td>
                        </tr>
                        <tr>
                            <td>解像度</td>
                            <td>
                                <span v-if="book.XResolution">{{ book.XResolution }} dpi</span>
                                <span v-else class="text-secondary text-sm">取得できませんでした</span>
                            </td>
                        </tr>
                        <tr>
                            <td>撮影日時</td>
                            <td>{{ getJADatetime(book.lastModified) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="col-3 btn btn-outline-secondary" @click="modal.show = false">
                    閉じる
                </button>
                <Link :href="route('books.edit', book.id)" class="col-3 btn btn-success">編集する</Link>
            </div>
        </Modal>
    </div>
</template>

<script>
export default {
    name: "ViewModal"
}
</script>

<style>
.modal-xl {
    max-width: 1072px;
    min-width: 1072px;
}
</style>

<style scoped>
table tbody tr td:first-child {
    text-align: center;
    background-color: #f7fafc;
    width: 30%;
}
</style>
