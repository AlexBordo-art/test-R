<template>
    <div class="flex items-center justify-center h-screen">
        <form @submit.prevent="sendForm" class="
            border-8 border-gray-200 rounded-xl
            w-[500px] -mt-14 p-8
            flex flex-col gap-y-3
        ">
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Заголовок</span>
                <input class="
                px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2
            " type="text" v-model="data.title">
            </label>
            
            <input v-model="data.datetime" type="datetime-local" />

            <!-- Новое поле для выбора сервиса -->
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Сервис</span>
                <select v-model="data.service_name" required class="
                px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2
            ">
                    <option disabled value="">Выберите сервис</option>
                    <option>Магазин</option>
                    <option>Доставка</option>
                    <option>Приложение</option>
                </select>
            </label>

            <!-- Новое поле для выбора рейтинга -->
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Рейтинг</span>
                <input type="number" min="1" max="5" v-model.number="data.rating" required class="
                px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2
            ">
                <vue3-star-ratings v-model="data.rating" :star-size="20" :show-rating="false" :step="1"></vue3-star-ratings>
            </label>

            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Описание</span>
                <textarea class="
    px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
    focus-visible:outline-brand-2 outline-2
" rows="6" v-model="data.description"></textarea>

            </label>
            <button class="
                grid place-content-center w-full p-2 mt-1 border-2 border-gray-300 rounded-md shadow-sm outline-none bg-white
                text-lg font-semibold tracking-wide text-gray-400
                transition-all
                focus-visible:bg-brand-2 focus-visible:border-green-700 focus-visible:text-green-800 focus-visible:shadow-xl
                hover:bg-brand-2 hover:border-green-700 hover:text-green-800 hover:shadow-xl
            " type="submit">Отправить</button>
        </form>
    </div>
</template>
<script setup lang="ts">
import { reactive, defineExpose } from 'vue';
import axios from 'axios';
import env from '@/env.json'
import router from '@/router';
import vue3StarRatings from "vue3-star-ratings";

const data = reactive({
    description: '',
    title: '',
    datetime: '',
    service_name: '', 
    rating: 0, 
});

const sendForm = async () => {
    try {
        const response = await sendFormImpl();
        if (!response.data.id)
            throw new Error('Ошибка сервера');
        await router.push({ name: 'feedback-show', params: { id: response.data.id } });
    } catch (error) {
        alert(error);
    }
}

const sendFormImpl = async () => {
    console.log('Отправляемые данные:', data);  // строка для отладки
    return await axios.post<StoreFeedbackResponse>(env.backend_url + '/feedbacks', {
        'description': data.description,
        'title': data.title,
        'service_name': data.service_name, 
        'rating': data.rating,

        'datetime':  new Date(data.datetime).getTime()
    });
}

interface StoreFeedbackResponse {
    id: number
}

defineExpose({
    components: {
        vue3StarRatings
    }
})
</script>
