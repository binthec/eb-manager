<script setup>
import dayjs from "dayjs";
defineProps(['viewModal', 'delModal', 'books'])
</script>

<template>
    <div class="row row-cols-4 border-top-0">
        <div class="col mb-3" v-for="(book) in books">
            <div class="card h-100">
                <img :src="'storage/' + book.filepath" class="align-self-center"/>
                <div class="card-body bg-light">
                    【{{ book.id }}】{{ book.filename }}<br/>
                    <span class="text-sm text-secondary">{{ dayjs(book.created_at).format('YYYY/MM/DD') }}</span>
                </div>
                <div class="card-footer text-xl bg-white d-flex justify-content-evenly">
                    <span class="pl-2 pr-2 control-btn rounded-lg"
                          @click="viewModal.show = true; viewModal.book = book">
                        <i class="bi bi-file-earmark-image text-success"/>
                    </span>
                    <span class="pl-2 pr-2 control-btn rounded-lg"
                          @click="delModal.show = true; delModal.book = book">
                        <i class="bi bi-trash3-fill text-danger"/>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "List"
}
</script>

<style scoped>

</style>
