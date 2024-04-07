<script setup>
import {inject, reactive, watch} from "vue";

const toast = inject('customToast');

/**
 * toast の値を監視し、変化があった場合はn秒後に初期化する
 */
watch((toast), (newVal, oldVal) => {
    if (newVal.show) {
        setTimeout(() => {
            toast.show = false;
            toast.type = '';
        }, 5000);  // n秒後に初期化する
    }
});
</script>

<template>
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
        <div class="toast" :class="[{'show' : toast.show}, toast.type]" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="toast-body d-flex">
                <slot/>
                <span v-show="toast.type === 'deleted'">削除が完了しました。</span>
                <span v-show="toast.type === 'uploaded'">アップロードが完了しました。</span>
                <span v-show="toast.type === 'success'">操作が完了しました。</span>
                <span v-show="toast.type === 'error'">操作に失敗しました。再度やり直してください。</span>
                <button type="button" class="btn-close m-auto me-0" data-bs-dismiss="toast" aria-label="Close"
                        @click="toast.show = false"></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CustomToast"
}
</script>

<style lang="scss" scoped>
.toast {
    animation: auto-hide 5s linear forwards;

    &.success, &.uploaded, &.deleted {
        border-top: solid 5px #76e17f;
    }

    &.error {
        border-top: solid 5px #ff7171;
    }
}

@keyframes auto-hide {
    90% {
        opacity: 100;
    }
    100% {
        opacity: 0;
    }
}
</style>
