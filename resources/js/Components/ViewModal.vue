<script setup>
import {Modal} from "@kouts/vue-modal";
import dayjs from "dayjs";
defineProps(['modal', 'book']);
</script>

<template>
    <div>
        <Modal v-model="modal.show" :title="modal.book.filename" :modal-class="'modal-xl'">
            <div class="row">
                <div class="col-6">
                    <div class="mb-4">
                        <img :src="'storage/' + book.filepath"/>
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
                            <td>{{ dayjs(book.created_at).format('YYYY/MM/DD') }}</td>
                        </tr>
                        <tr>
                            <td>総画素数</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>解像度</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>階調</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-outline-secondary" @click="modal.show = false">
                    閉じる
                </button>
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
table tbody tr td:first-child{
    text-align: center;
    background-color: #f7fafc;
    width: 30%;
}
</style>
