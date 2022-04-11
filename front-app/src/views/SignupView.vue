<template>
  <NavComponent />
  <SignUpUser />
</template>

<script>
import SignUpUser from "@/components/Signup/SignUp.vue";
import NavComponent from "@/components/NavComponent.vue";
export default {
  name: "SignupView",
  components: {
    SignUpUser,
    NavComponent,
  },
};
</script>

<style></style>
