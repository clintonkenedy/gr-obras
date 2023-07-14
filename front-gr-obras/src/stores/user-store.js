import { defineStore } from "pinia";
import { api } from "src/boot/axios";
import { Cookies } from "quasar";

export const useUserStore = defineStore("user", {
  state: () => ({
    id: null,
    name: null,
    email: null,
  }),
  getters: {
    getId: (state) => state.id,
    getName: (state) => state.name,
    getEmail: (state) => state.email,
  },
  actions: {
    async login(email, password) {
      try {
        const res = await api.post("api/login", {
          email: email,
          password: password,
        });
        let tokenString = "Bearer " + res.data.token.access_token;
        Cookies.set("token", tokenString);
        return res;
      } catch (e) {
        if (e) throw e;
      }
    },

    logout() {
      Cookies.remove("token");
      this.clearUser();
    },

    setUser(payload) {
      if (payload.id) this.id = payload.id;
      if (payload.name) this.name = payload.name;
      if (payload.email) this.email = payload.email;
    },

    clearUser() {
      this.id = null;
      this.name = null;
      this.email = null;
    },
  },
});
