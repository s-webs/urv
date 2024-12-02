<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    attendances: Array
})

const generateMapLink = (longitude, latitude) => {
    return `https://yandex.ru/maps/?pt=${longitude},${latitude}&z=18&l=map`
}
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="container mx-auto">
            <div class="mt-8 bg-white rounded-lg p-8">
                <div>
                    <h1 class="text-2xl">Список отметок</h1>
                </div>
                <div class="mt-8">
                    <div v-for="attendance in attendances" class="border rounded-lg p-4 flex justify-between">
                        <div>{{ attendance.user.name }}</div>
                        <div class="flex gap-4">
                            <div>{{ attendance.check_in_time }}</div>
                            <div>
                                <a :href="generateMapLink(attendance.longitude, attendance.latitude)"
                                   class="bg-blue-700 hover:bg-blue-400 text-white rounded-lg py-2 px-4"
                                   target="_blank">
                                    Ссылка на местоположение
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
