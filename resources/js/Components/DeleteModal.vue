<script setup>
import {Modal} from "@kouts/vue-modal";
import {useForm} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps(['modal']);
const book = computed(() => props.modal.book);
const form = useForm({});

/**
 * フォームの実行処理
 * @param id
 */
function submit(id) {
    form.delete(route('books.destroy', id), {onSuccess: () => props.modal.show.value = false});
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
                <span v-if="form.processing === true">
                    <span class="spinner-border spinner-border-sm text-dark mr-1" role="status"
                          aria-hidden="true"></span>削除中...
                </span>
                <span v-else>削除実行</span>
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
