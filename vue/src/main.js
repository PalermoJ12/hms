import { createApp } from "vue";
import store from "./store/store-js";
import router from "./router/index";
import {
  createVuestic,
  VaButton,
  VaCard,
  VaCardTitle,
  VaDataTable,
  VaIcon,
  VaCardContent,
  VaModal,
  VaForm,
  VaProgressBar,
  VaInput,
  VaSelect,
} from "vuestic-ui";
import "vuestic-ui/styles/essential.css";
import "vuestic-ui/styles/typography.css";
import App from "./App.vue";
const app = createApp(App);
import "./index.css";

app
  .use(store)
  .use(
    createVuestic({
      components: {
        VaButton,
        VaCard,
        VaCardTitle,
        VaCardContent,
        VaDataTable,
        VaIcon,
        VaModal,
        VaForm,
        VaProgressBar,
        VaInput,
        VaSelect,
      },
      config: {
        colors: {
          variables: {
            // Default colors
            primary: "#002c85",
            secondary: "#002c85",
            success: "#40e583",
            info: "#2c82e0",
            danger: "#e34b4a",
            warning: "#ffc200",
            gray: "#babfc2",
            dark: "#34495e",
          },
        },
      },
    })
  )
  .use(router)
  .mount("#app");
