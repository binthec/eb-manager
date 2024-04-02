<script setup xmlns="http://www.w3.org/1999/html">
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"

defineProps(['book']);
</script>
<template>
    <Head title="Books 電子帳簿 編集"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Electronic Books　電子帳簿 編集</h2>
        </template>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y p-4">
            {{ book.filename }}
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: "Edit"
}
</script>

<style scoped>

</style>
