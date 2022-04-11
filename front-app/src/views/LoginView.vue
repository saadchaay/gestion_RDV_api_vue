<template>
  <NavComponent />
  <LoginUser />
</template>

<script>
import NavComponent from "@/components/NavComponent.vue";
import LoginUser from "@/components/Login/Login.vue";
export default {
  name: "LoginView",
  components: {
    LoginUser,
    NavComponent,
  },
};
</script>

<style></style>
