<script setup>
import {inject, onMounted, watch} from "vue";
import {Toast} from 'bootstrap';

const toast = inject('customToast');

watch((toast), (newVal, oldVal) => {
    if (newVal.show) {
        // toast の設定
        const el = document.getElementById('el');    // toast 本体の要素
        const toastEl = Toast.getOrCreateInstance(el, { // toast を初期化
            delay: 1000,
        });
        toastEl.show(); // toast を表示
        el.addEventListener('hidden.bs.toast', () => { // 非表示完了した際の処理
            toast.show = false; // toast 用の値を初期化
            toast.type = '';
            //console.log('非表示完了！');
        })
    }
});
</script>

<template>
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
        <div id="el" class="toast" role="alert" aria-live="assertive"
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
    animation: auto-hide 3s linear forwards;

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
