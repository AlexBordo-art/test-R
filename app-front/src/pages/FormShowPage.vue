<template>
  <main class="flex items-center justify-center h-screen">
    <div class="
      border-8 border-gray-200 rounded-xl
      w-[500px] -mt-14 p-8
      flex flex-col gap-y-5
    ">
      <div v-if="feedback.isLoaded" class="flex flex-col">
        <h1 class="text-3xl font-medium text-gray-500">{{ feedback.title }}</h1>
        <p class="text-sm text-gray-400">{{ datetime }}</p>
        <p class="text-base mt-2 text-gray-500">{{ feedback.description }}</p>
        <!-- Новые поля -->
        <p class="text-base mt-2 text-gray-500">Сервис: {{ feedback.service_name }}</p>
        <p class="text-base mt-2 text-gray-500">Рейтинг: {{ feedback.rating }}</p>
        <div class="flex">
          <template v-for="star in 5" :key="star">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{ 'text-yellow-500': star <= feedback.rating, 'text-gray-300': star > feedback.rating }">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15.638l-6.172 3.245a1 1 0 01-1.452-1.054l1.794-6.928-5.286-4.086a1 1 0 01.554-1.705l6.573-.573L11.794.221a1 1 0 011.412 0l2.382 5.272 6.573.573a1 1 0 01.554 1.705l-5.286 4.086 1.794 6.928a1 1 0 01-1.452 1.054L12 15.638z"/>
            </svg>
          </template>
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
     "
    >
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
 service_name: '', // новое поле
 rating: 0, // новое поле
 isLoaded: false
});
const datetime = computed(() => {
 return new Date(Number(feedback.datetime)).toLocaleString()
})
onBeforeMount(() => {
 axios.get<FeedbackResponse>(env.backend_url + `/feedbacks/${idFromRouter}`)
 .then(feedbackResponse => {
  const feedbackResponseData = feedbackResponse.data;
  feedback.title = feedbackResponseData.title;
  feedback.description = feedbackResponseData.description;
  feedback.datetime = feedbackResponseData.datetime;
  feedback.service_name = feedbackResponseData.service_name; // новое поле
  feedback.rating = feedbackResponseData.rating; // новое поле
  feedback.isLoaded = true;
 }).catch(error => {
  alert(error);
 });
});
interface FeedbackResponse {
 title: string;
 description: string;
 datetime: string;
 service_name: string; // новое поле
 rating: number; // новое поле
}
</script>

