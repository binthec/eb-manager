<script setup xmlns="http://www.w3.org/1999/html">
import {computed, defineProps} from "vue";
import {Head, useForm, Link, usePage} from "@inertiajs/vue3";

// コンポーネント
import useFormatDate from "@/Composables/FormatDate.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import InputError from "@/Components/InputError.vue";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const book = computed(() => usePage().props.book);

const {getJADate, getJADatetime} = useFormatDate();
const form = useForm({
    title: book.value.title,
    publisher: book.value.publisher,
    issue_date: book.value.issue_date,
    price: book.value.price,
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
                <div class="col-12"><p>{{ book.filename }}</p></div>
                <div class="col">
                    <div class="mb-4 d-flex justify-content-center">
                        <img :src="'/storage/' + book.filepath"/>
                    </div>
                </div>
                <div class="col">
                    <form @submit.prevent="form.patch(route('books.update', book.id))" class="mb-4">
                        <div>
                            <InputLabel for="title" value="名前"/>
                            <TextInput
                                id="name"
                                type="text"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.title}"
                                v-model="form.title"
                                autofocus
                                autocomplete="title"
                            />
                            <InputError class="mt-2" :message="form.errors.title"/>
                        </div>

                        <div>
                            <InputLabel for="publisher" value="発行元"/>
                            <TextInput
                                id="publisher"
                                type="text"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.publisher}"
                                v-model="form.publisher"
                                autocomplete="publisher"
                            />
                            <InputError class="mt-2" :message="form.errors.publisher"/>
                        </div>

                        <div>
                            <InputLabel for="issue_date" value="発行日"/>
                            <TextInput
                                id="issue_date"
                                type="text"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.issue_date}"
                                v-model="form.issue_date"
                                autocomplete="issue_date"
                            />
                            <InputError class="mt-2" :message="form.errors.issue_date"/>
                        </div>

                        <div>
                            <InputLabel for="price" value="金額"/>
                            <TextInput
                                id="price"
                                type="text"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.price}"
                                v-model="form.price"
                                autofocus
                                autocomplete="price"
                            />
                            <InputError class="mt-2" :message="form.errors.price"/>
                        </div>

                        <div class="mt-3 text-end">
                            <span v-show="form.recentlySuccessful" class="mr-2 text-success">
                                <i class="bi bi-check2-circle text-xl align-middle mr-1"/>Saved!
                            </span>
                            <button class="btn btn-success col-6" :disabled="form.processing">
                                <span v-if="form.processing === true">
                                    <span class="spinner-border spinner-border-sm text-light mr-2"
                                          role="status"/>更新中...
                                </span>
                                <span v-else>更新する</span>
                            </button>
                        </div>
                    </form>
                    <hr/>

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

form div{
    margin-bottom: 1rem;
}
</style>
