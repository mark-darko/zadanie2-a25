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

            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Описание</span>
                <textarea class="
                    px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                    focus-visible:outline-brand-2 outline-2
                " rows="6" v-model="data.description" />
            </label>

            <!-- Service Selector -->
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Сервис</span>
                <select v-model="data.service_name" class="px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner focus-visible:outline-brand-2 outline-2">
                    <option value="Магазин">Магазин</option>
                    <option value="Доставка">Доставка</option>
                    <option value="Приложение">Приложение</option>
                </select>
            </label>

            <!-- Star Rating -->
            <label class="flex flex-col gap-y-0.5 text-gray-500">
                <span class="text-lg">Рейтинг</span>
                <div class="flex">
                    <button
                        v-for="star in 5"
                        :key="star"
                        @click="setRating(star)"
                        @keydown.space="setRating(star)"
                        type="button"
                        class="focus:outline-none focus:ring-2 focus:ring-brand-2 rounded-full p-1"
                    >
                        <svg class="w-8 h-8" :class="{ 'text-yellow-400': star <= data.rating, 'text-gray-300': star > data.rating }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
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
import { reactive } from 'vue';
import axios from 'axios';
import env from '@/env.json'
import router from '@/router';

const data = reactive({
    description: '',
    title: '',
    datetime: '',
    service_name: 'Магазин', // Default value
    rating: 0,
});

const setRating = (value: number) => {
    data.rating = value;
};

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
    return await axios.post<StoreFeedbackResponse>(env.backend_url + '/feedbacks', {
        'description': data.description,
        'title': data.title,
        'datetime': new Date(data.datetime).getTime(),
        'service_name': data.service_name,
        'rating': data.rating,
    });
}

interface StoreFeedbackResponse {
    id: number
}
</script>
