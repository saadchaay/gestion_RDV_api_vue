<template>
  <NavComponent />
  <SchComp />
</template>

<script>
import { mapActions } from "vuex";
import NavComponent from "@/components/NavComponent.vue";
import SchComp from "@/components/SchComp.vue";
export default {
  name: "SchedulesView",
  components: {
    SchComp,
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
