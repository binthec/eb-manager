<script setup>
import {Modal} from "@kouts/vue-modal";
import {Link} from "@inertiajs/vue3";

defineProps(['modal']);
</script>

<template>
    <Modal v-model="modal.show" title="削除を実行します">
        <p class="bg-warning p-2">【ID:{{ modal.book.id }}】{{ modal.book.filename }}</p>
        <p>
            削除します。よろしいですか。
            <span class="text-danger font-semibold">※この処理は取り消せません。</span>
        </p>
        <div class="d-flex justify-content-center">
            <img :src="'storage/' + modal.book.filepath" class="mh-500"/>
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

</style>
