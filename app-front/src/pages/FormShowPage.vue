<template>
    <main
        class="flex items-center justify-center h-screen">
        <div class="
            border-8 border-gray-200 rounded-xl
            w-[500px] -mt-14 p-8
            flex flex-col gap-y-5
        ">
            <div v-if="feedback.isLoaded" class="flex flex-col">
                <h1 class="text-3xl font-medium text-gray-500">{{ feedback.title }}</h1>
                <p class="text-sm text-gray-400">{{ datetime }}</p>
                <p class="text-base mt-2 text-gray-500">{{ feedback.description }}</p>
                <p class="text-sm mt-2 text-gray-400">Сервис: {{ feedback.service_name }}</p>
                <div class="flex mt-2">
                    <span class="text-sm text-gray-400 mr-2">Рейтинг:</span>
                    <div class="flex">
                        <svg v-for="star in 5" :key="star" class="w-5 h-5" :class="{ 'text-yellow-400': star <= feedback.rating, 'text-gray-300': star > feedback.rating }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
            <div>
                <RouterLink
                    :to="{ name: 'feedback-create' }"
                    class="
                        flex items-center gap-0.5 outline-brand-2
                        text-gray-400
                        transition-colors
                        focus:text-brand-2 hover:text-brand-2
                ">
                    <svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-6 -mb-0.5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>
                    <span>Новый отзыв</span>
                </RouterLink>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import axios from 'axios';
import { onBeforeMount, reactive, computed } from 'vue';
import { useRoute } from 'vue-router';
import env from '@/env.json';

const idFromRouter = useRoute().params.id
const feedback = reactive({
    title: '',
    description: '',
    datetime: '',
    service_name: '',
    rating: 0,
    isLoaded: false
});

const datetime = computed(() => {
    return new Date(Number(feedback.datetime) * 1000).toLocaleString()
})

onBeforeMount(() => {
    axios.get<FeedbackResponse>(env.backend_url + `/feedbacks/${idFromRouter}`)
        .then(feedbackResponse => {
            const feedbackResponseData = feedbackResponse.data;
            feedback.title = feedbackResponseData.title;
            feedback.description = feedbackResponseData.description;
            feedback.datetime = feedbackResponseData.datetime;
            feedback.service_name = feedbackResponseData.service_name;
            feedback.rating = feedbackResponseData.rating;
            feedback.isLoaded = true;
        }).catch(error => {
            alert(error);
        });
});

interface FeedbackResponse {
    title: string;
    description: string;
    datetime: string;
    service_name: string;
    rating: number;
}
</script>
