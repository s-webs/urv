<script setup>
import { ref } from 'vue';
import axios from 'axios';

const errorMessage = ref('');
const successMessage = ref('');
const mapLinkGoogle = ref('');
const mapLinkYandex = ref('');

const latitude = ref(null);
const longitude = ref(null);

const checkIn = async () => {
    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            async (position) => {
                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;

                console.log(latitude.value, longitude.value);

                // Формируем ссылки с метками
                mapLinkGoogle.value = `https://www.google.com/maps?q=${latitude.value},${longitude.value}`;
                mapLinkYandex.value = `https://yandex.ru/maps/?pt=${longitude.value},${latitude.value}&z=18&l=map`;

                // Отправляем данные на сервер через axios
                try {
                    const response = await axios.post('/attendance/check-in', {
                        latitude: latitude.value,
                        longitude: longitude.value,
                    });

                    successMessage.value = response.data.message || 'Приход успешно отмечен!';
                    errorMessage.value = '';
                } catch (error) {
                    console.error('Ошибка при отметке прихода:', error);
                    errorMessage.value =
                        error.response?.data?.error || 'Ошибка при отметке прихода. Попробуйте снова.';
                    successMessage.value = '';
                }
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

<template>
    <div class="flex items-center justify-center h-screen bg-gradient-to-r from-cyan-500 to-blue-500">
        <div>
            <h2 class="text-2xl text-center font-bold text-white">Отметка прихода</h2>
            <div class="mt-8 text-center">
                <div class="text-center mt-8 text-gray-300 mb-4">Для отметки прихода мы проверим ваше местоположение.</div>
                <div v-if="successMessage" class="text-green-700 text-center font-bold">{{ successMessage }}</div>
                <div v-if="errorMessage" class="text-red-700 mt-4 font-bold">{{ errorMessage }}</div>
            </div>
            <div class="text-center">
                <button class="bg-gradient-to-r border mt-8 from-indigo-400 to-cyan-400 text-white font-bold rounded-full p-4 mt-4" @click="checkIn">Отметить приход</button>
            </div>
        </div>
    </div>
</template>

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
