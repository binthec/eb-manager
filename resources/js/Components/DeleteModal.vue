<script setup>
import {Modal} from "@kouts/vue-modal";
import {Link} from "@inertiajs/vue3";

defineProps(['modal']);
</script>

<template>
    <Modal v-model="modal.show" title="削除を実行します">
        <slot />

        <button type="button" class="btn btn-outline-secondary justify-between" @click="modal.show = false">
            やめる
        </button>
        <Link as="button" :href="route('books.destroy', modal.targetId)" method="delete"
              class="btn btn-danger ml-4 float-end" @click="modal.show = false">
            削除実行
        </Link>
    </Modal>
</template>

<script>
export default {
    name: "DeleteModal"
}
</script>

<style scoped>

</style>
