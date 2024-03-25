<script setup>
import {Modal} from "@kouts/vue-modal";
import {Link} from "@inertiajs/vue3";

defineProps(['modal']);
</script>

<template>
    <Modal v-model="modal.show" title="削除を実行します">
        <p>
            {{ modal.book.filename }} を削除します。よろしいですか。<br>
            <span class="text-danger font-semibold">※この処理は取り消せません。</span>
        </p>
        <div class="d-flex justify-content-center">
            <img :src="'storage/' + modal.book.filepath"/>
        </div>

        <div class="mt-4">
            <button type="button" class="btn btn-outline-secondary justify-between" @click="modal.show = false">
                やめる
            </button>
            <Link as="button" :href="route('books.destroy', modal.book.id)" method="delete"
                  class="btn btn-danger ml-4 float-end" @click="modal.show = false">
                削除実行
            </Link>
        </div>
    </Modal>
</template>

<script>
export default {
    name: "DeleteModal"
}
</script>

<style scoped>
img {
    max-height: 500px;
}
</style>
