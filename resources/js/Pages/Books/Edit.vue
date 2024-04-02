<script setup xmlns="http://www.w3.org/1999/html">
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import useFormatDate from "@/Composables/FormatDate.js";
import {Link} from "@inertiajs/vue3";

const {getJADate, getJADatetime} = useFormatDate();

defineProps(['book']);
</script>
<template>
    <Head title="Books 電子帳簿 編集"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Electronic Books　電子帳簿 編集</h2>
        </template>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y p-4">
            <div class="row row-cols-2">
                <div class="col">
                    <p>{{ book.filename }}</p>
                    <div class="mb-4 d-flex justify-content-center">
                        <img :src="'/storage/' + book.filepath"/>
                    </div>
                </div>
                <div class="col">
                    電子保存情報
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>発行元</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>発行日</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>金額</td>
                            <td></td>
                        </tr>

                        </tbody>
                    </table>

                    アップロード日・サイズ情報
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>アップロード日</td>
                            <td>{{ getJADate(book.created_at) }}</td>
                        </tr>
                        <tr>
                            <td>サイズ</td>
                            <td>{{ Math.round(book.size / 1024) }} KB</td>
                        </tr>
                        <tr>
                            <td>総画素数</td>
                            <td>{{ book.width }} x {{ book.height }}</td>
                        </tr>
                        <tr>
                            <td>解像度</td>
                            <td>
                                <span v-if="book.XResolution">{{ book.XResolution }} dpi</span>
                                <span v-else class="text-secondary text-sm">取得できませんでした</span>
                            </td>
                        </tr>
                        <tr>
                            <td>撮影日時</td>
                            <td>{{ getJADatetime(book.lastModified) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row border-0 d-flex justify-content-between">
                <Link :href="route('books.index')" class="col-3 btn btn-outline-secondary">もどる</Link>
                <Link :href="route('books.edit', book.id)" class="col-3 btn btn-success">更新する</Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: "Edit"
}
</script>

<style scoped>
table tbody tr td:first-child {
    text-align: center;
    background-color: #f7fafc;
    width: 30%;
}
</style>
