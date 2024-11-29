<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const errorMessage = ref('');
const successMessage = ref('');
const mapLink = ref('');

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
                mapLink.value = `https://www.google.com/maps?ll=${form.latitude},${form.longitude}`;
            },
            (error) => {
                console.error('Ошибка геолокации:', error);
                errorMessage.value = 'Не удалось получить ваше местоположение. Пожалуйста, проверьте настройки.';
            }
        );
    } else {
        errorMessage.value = 'Ваше устройство не поддерживает геолокацию.';
        mapLink.value = '';
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

        <p v-if="mapLink">
            <a :href="mapLink" target="_blank">Открыть местоположение на карте</a>
        </p>
    </div>
</template>

<style scoped>

</style>
