<script setup xmlns="http://www.w3.org/1999/html">
import {computed, defineProps} from "vue";
import {Head, useForm, Link, usePage} from "@inertiajs/vue3";

// コンポーネント
import useFormatDate from "@/Composables/FormatDate.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import InputError from "@/Components/InputError.vue";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';


const props = defineProps(['book']);
const book = computed(() => props.book);

const {getJADate, getJADatetime} = useFormatDate();
const form = useForm({
    title: book.value.title,
});
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
                    <form @submit.prevent="form.patch(route('books.update', book.id))"
                          class="mb-4">
                        <InputLabel for="title" value="名前" />
                        <TextInput
                            id="name"
                            type="text"
                            class="form-control"
                            v-model="form.title"
                            required
                            autofocus
                            autocomplete="title"
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                        <div class="mt-3 text-end">
                            <button class="btn btn-success col-6">更新する</button>
                        </div>
                    </form>
                    <hr/>
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
