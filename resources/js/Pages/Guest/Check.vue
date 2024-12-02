<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';

const errorMessage = ref('');
const successMessage = ref('');
const mapLinkGoogle = ref('');
const mapLinkYandex = ref('');

const form = useForm({
    latitude: null,
    longitude: null,
});

const checkIn = () => {
    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                form.latitude = position.coords.latitude;
                form.longitude = position.coords.longitude;
                console.log(form.latitude, form.longitude)
                mapLinkGoogle.value = `https://www.google.com/maps?q=${form.latitude},${form.longitude}`;
                mapLinkYandex.value = `https://yandex.ru/maps/?pt=${form.longitude},${form.latitude}&z=18&l=map`;
            },
            (error) => {
                console.error('Ошибка геолокации:', error);
                errorMessage.value = 'Не удалось получить ваше местоположение. Пожалуйста, проверьте настройки.';
            }
        );
    } else {
        errorMessage.value = 'Ваше устройство не поддерживает геолокацию.';
        mapLinkGoogle.value = '';
        mapLinkYandex.value = '';
    }
};


</script>

<style scoped>
.error {
    color: red;
    margin-top: 10px;
}

.success {
    color: green;
    margin-top: 10px;
}
</style>

<template>
    <div>
        <h2>Отметка прихода</h2>
        <p>Для отметки прихода мы проверим ваше местоположение.</p>
        <button class="bg-green-600 p-4 mt-4" @click="checkIn">Отметить приход</button>

        <p v-if="mapLinkGoogle" class="mt-4">
            <span class="block">Google</span>
            <a :href="mapLinkGoogle" target="_blank" class="text-blue-600 border">Открыть местоположение на карте</a>
        </p>
        <p v-if="mapLinkYandex" class="mt-4">
            <span class="block">Yandex</span>
            <a :href="mapLinkYandex" target="_blank" class="text-blue-600 border">Открыть местоположение на карте</a>
        </p>
    </div>
</template>

<style scoped>

</style>
