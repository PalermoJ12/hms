import { createStore } from "vuex";
import axiosClient from "../axios-config/axios-client";

const store = createStore({
  state() {
    return {
      products: [],
      users: [],
      userLogged: localStorage.getItem("token"),
      user_id: localStorage.getItem("user"),
    };
  },
  mutations: {
    setProduct(state, products) {
      state.products = products;
    },
    setUsers(state, users) {
      state.users = users;
    },
  },
  actions: {
    async getProduct({ commit }) {
      try {
        const res = await axiosClient.get("/products");
        console.log(res.data);
        commit("setProduct", res.data.products);
      } catch (err) {
        console.error(err);
      }
    },

    async getUsers({ commit }) {
      try {
        const res = await axiosClient.get("/users");
        console.log(res.data);
        commit("setUsers", res.data.users);
      } catch (err) {
        console.error(err);
      }
    },
  },
  getters: {
    allProducts: (state) => state.products,
    allUsers: (state) => state.users,
  },
});

export default store;
