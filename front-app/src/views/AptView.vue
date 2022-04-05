<template>
  <AptComponent />
</template>
<script>
import AptComponent from "@/components/AptComponent.vue";
import { mapActions } from "vuex";
export default {
  name: "AptView",
  components: {
    AptComponent,
  },
  mounted() {
    let user = localStorage.getItem("user-login");
    if (!user) {
      this.redirectTo({ val: "Login" });
    }
  },
  methods: {
    ...mapActions(["redirectTo"]),
  },
};
</script>
