<template>
  <NavComponent />
  <AptComponent />
</template>
<script>
import AptComponent from "@/components/AptComponent.vue";
import { mapActions } from "vuex";
import NavComponent from "@/components/NavComponent.vue";
export default {
  name: "AptView",
  components: {
    AptComponent,
    NavComponent,
  },
  mounted() {
    let user = localStorage.getItem("reference");
    if (!user) {
      this.redirectTo({ val: "Login" });
    }
    this.check_login();
  },
  methods: {
    ...mapActions(["redirectTo"]),
    check_login() {
      const if_loggedIn = localStorage.getItem("reference");
      if (!if_loggedIn) {
        console.log("User not logged In yet!");
      } else {
        this.reference = if_loggedIn;
      }
    },
  },
};
</script>
