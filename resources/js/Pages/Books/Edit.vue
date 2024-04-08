<script setup xmlns="http://www.w3.org/1999/html">
import {computed} from "vue";
import {Head, useForm, Link, usePage} from "@inertiajs/vue3";

// コンポーネント
import useFormatDate from "@/Composables/FormatDate.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import InputError from "@/Components/InputError.vue";
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import CustomPopover from "@/Components/CustomPopover.vue";
import TextareaInput from "@/Components/TextareaInput.vue";

const book = computed(() => usePage().props.book);
const types = computed(() => usePage().props.types);

const {getJADate, getJADatetime} = useFormatDate();
const form = useForm({
    type: book.value.type ?? '',
    invoice: book.value.invoice ?? '',
    registration_number: book.value.registration_number ?? '',
    title: book.value.title ?? '',
    publisher: book.value.publisher ?? '',
    issue_date: book.value.issue_date ?? '',
    price: book.value.price ?? '',
    memo: book.value.memo ?? '',
});
</script>
<template>
    <Head title="Books 電子帳簿 編集"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Electronic Books　電子帳簿 編集</h2>
        </template>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y p-4">
            <form @submit.prevent="form.patch(route('books.update', book.id))">
                <div class="row row-cols-2">
                    <div class="col-12 d-flex">
                        <p>{{ book.filename }}</p>
                        <p class="m-auto me-0 bg-gray-200 pt-1 pb-1 pl-2 pr-2 text-sm rounded">
                            作成日：{{ getJADate(book.created_at) }}</p>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-center">
                            <img :src="'/storage/' + book.filepath"/>
                        </div>
                        <div class="text-end img-info mt-2">
                            <span>{{ getJADatetime(book.lastModified) }}</span>
                            <span>{{ book.width }} x {{ book.height }}</span>
                            <span>{{ Math.round(book.size / 1024) }} KB</span>
                            <span v-show="book.XResolution">{{ book.XResolution }} dpi</span>
                            <CustomPopover :placement="'top'"
                                           :content="'画像登録時に自動取得された情報です'"
                                           :icon-class="'text-secondary'"/>
                        </div>
                    </div>
                    <div class="col form-content">

                        <p class="fw-bold">電子保存情報</p>
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
                                autocomplete="price"
                            />
                            <InputError class="mt-2" :message="form.errors.price"/>
                        </div>

                        <div>
                            <InputLabel for="memo" value="メモ"/>
                            <TextareaInput
                                id="memo"
                                type="textarea"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.memo}"
                                v-model="form.memo"
                                autocomplete="memo"
                            />
                            <InputError class="mt-2" :message="form.errors.memo"/>
                        </div>

                        <p class="fw-bold mt-14">インボイス情報</p>
                        <div>
                            <InputLabel for="type" value="書類の種類"/>
                            <select class="form-select" v-model="form.type">
                                <option>選択してください</option>
                                <option v-for="(type, index) in types" :value="index">{{ type }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.type"/>
                        </div>

                        <div>
                            <InputLabel for="invoice" value="適格請求書等"/>
                            <div class="form-check form-check-inline">
                                <input v-model="form.invoice" type="radio" name="invoice" id="invoice_no"
                                       class="form-check-input" value="0">
                                <label class="form-check-label" for="invoice_no">該当しない</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input v-model="form.invoice" type="radio" name="invoice" id="invoice_yes"
                                       class="form-check-input" value="1">
                                <label class="form-check-label" for="invoice_yes">該当する</label>
                            </div>
                            <InputError class="mt-2" :message="form.errors.invoice"/>
                        </div>

                        <div>
                            <InputLabel for="registration_number" value="登録番号"/>
                            <TextInput
                                id="registration_number"
                                type="text"
                                class="form-control"
                                :class="{'is-invalid' : form.errors.registration_number}"
                                v-model="form.registration_number"
                                autocomplete="registration_number"
                            />
                            <InputError class="mt-2" :message="form.errors.registration_number"/>
                        </div>

                    </div>
                </div>
                <div class="row border-0 mt-4 d-flex justify-content-between">
                    <Link :href="route('books.index')" class="col-3 btn btn-outline-secondary">もどる</Link>
                    <div class="col-6 text-end">
                        <span v-show="form.recentlySuccessful" class="mr-2 text-success">
                            <i class="bi bi-check2-circle text-xl align-middle mr-1"/>Saved!
                        </span>
                        <button class="btn btn-success col-6" :disabled="form.processing">
                            <span v-if="form.processing === true">
                                <span class="spinner-border spinner-border-sm text-light mr-2" role="status"/>更新中...
                            </span>
                            <span v-else>更新する</span>
                        </button>
                    </div>
                </div>
            </form>
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

.form-content div {
    margin-bottom: 1rem;
}

.img-info span {
    background-color: #ccc;
    margin-right: 5px;
    padding: 2px 8px;
    border-radius: 1rem;
}
</style>
