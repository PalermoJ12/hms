import { createApp } from "vue";
import store from "./store/store-js";
import router from "./router/index";
import App from "./App.vue";
const app = createApp(App);
import "./index.css";

app.use(store).use(router).mount("#app");
