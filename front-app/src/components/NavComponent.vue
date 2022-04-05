<template>
  <nav>
    <div>
      <ul>
        <li><a href=""> Home</a></li>
        <li><a href=""> Appointment</a></li>
        <li><a href=""> About Us</a></li>
      </ul>
    </div>
    <div>
      <ul>
        <li><ButtonComponent title="Login" /></li>
        <li><ButtonComponent title="Sign Up" /></li>
      </ul>
    </div>
  </nav>
</template>

<script>
import ButtonComponent from "@/components/ButtonComponent.vue";
export default {
  name: "NavComponent",
  components: {
    ButtonComponent,
  },
};
</script>
