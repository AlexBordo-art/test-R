 import { createApp } from 'vue'
 import App from './App.vue'
import router from './router'
import vue3StarRatings from "vue3-star-ratings";

 import './assets/main.css'

// const app = createApp(App)

// app.use(router)

// app.mount('#app')

const app = createApp(App)

app.use(router)
app.component('vue3-star-ratings', vue3StarRatings); // регистрация компонента

app.mount('#app')
