<script setup>
import {Modal} from "@kouts/vue-modal";
import {useForm} from "@inertiajs/vue3";
import {computed, inject} from "vue";

const form = useForm({});
const modal = inject('delModal');
const book = computed(() => modal.book);

/**
 * フォームを submit して削除を実行
 * @param id
 */
function submit(id) {
    form.delete(route('books.destroy', id));
    modal.show = false;    // モーダルを閉じる
    modal.deleting = true; // 削除中フラグを立てる
}
</script>

<template>
    <Modal v-model="modal.show" title="削除を実行します">
        <p class="bg-warning p-2">【ID:{{ book.id }}】{{ book.filename }}</p>
        <p>
            削除します。よろしいですか。
            <span class="text-danger font-semibold">※この処理は取り消せません。</span>
        </p>
        <div class="d-flex justify-content-center">
            <img :src="'storage/' + book.filepath" class="mh-500"/>
        </div>
        <div class="mt-4">
            <button type="button" class="btn btn-outline-secondary justify-between" @click="modal.show = false">
                やめる
            </button>
            <button class="btn btn-danger float-end" @click="submit(book.id)" :disabled="form.processing">
                削除実行
            </button>
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
