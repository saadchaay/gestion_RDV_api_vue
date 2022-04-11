<template>
  <NavComponent />
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
  </div>
</template>

<script>
// @ is an alias to /src
import NavComponent from "@/components/NavComponent.vue";
export default {
  name: "HomeView",
  components: { NavComponent },
};
</script>
