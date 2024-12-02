<script setup>
import QrcodeVue from 'qrcode.vue'
</script>

<template>
    <div class="h-screen w-screen overflow-hidden bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center">
        <div class="bg-white w-2/4 h-2/4 flex items-center justify-center rounded-lg box-border">
            <QrcodeVue :value="route('page.check')" :size="320"/>
        </div>
    </div>
</template>

<style scoped>

</style>
