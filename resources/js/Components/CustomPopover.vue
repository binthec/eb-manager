<script setup>
import {onMounted} from "vue";
import {Popover} from 'bootstrap';

/**
 * content : popover 内に表示する文字列
 * placement : top, bottom, right, left
 */
defineProps(['content', 'placement', 'iconClass']);


onMounted(() => {
    new Popover(document.getElementById('el'), {});
});


</script>
<template>
    <button type="button" id="el"
            data-bs-toggle="popover"
            data-bs-trigger="focus"
            data-bs-custom-class="custom-popover"
            :data-bs-content="content"
            :data-bs-placement="placement ?? 'right'"
    >
    <i class="bi bi-info-circle-fill text-xl" :class="iconClass ?? 'text-warning'"/>
    </button>
</template>

<script>
export default {
    name: "CustomPopover"
}
</script>

<style lang="scss">
.custom-popover {
    --bs-popover-max-width: 300px;
    --bs-popover-border-color: var(--bs-secondary);
    --bs-popover-body-padding-x: 1rem;
    --bs-popover-body-padding-y: .5rem;
}
</style>
