<script setup>
import {Modal} from "@kouts/vue-modal";
import {Link} from "@inertiajs/vue3";

defineProps(['modal']);
</script>

<template>
    <Modal v-model="modal.show" :title="modal.book.filename">
        <div class="modal-body mb-4">
            <slot />
        </div>

        <button type="button" class="btn btn-outline-secondary justify-end" @click="modal.show = false">
            閉じる
        </button>
    </Modal>
</template>

<script>
export default {
    name: "DeleteModal"
}
</script>

<style scoped>

</style>
