<template>
  <div>
    <NavComponent />
    <section>
      <div class="container">
        <div>
          <h2>Pick the dentist that fits all <br />your needs the best.</h2>
          <p>
            Lorem ipsum dolor sit amet, eu duo ferri labor. Mea ex modo reque
            <br />senserit, et sed hinc dolor, scaevola sum salutandi expetendis
            vix ne.
          </p>
          <BtnComponent title="Book Appointment" />
        </div>
        <img src="../assets/banner.jpg" alt="" />
      </div>
    </section>
  </div>
</template>

<script>
// @ is an alias to /src
import NavComponent from "@/components/NavComponent.vue";
import BtnComponent from "../components/BtnComponent.vue";
export default {
  name: "HomeView",
  components: { NavComponent, BtnComponent },
};
</script>

<style scoped>
.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  /* margin: 0em 5em; */
  margin-top: 5em;
}
img {
  width: 600px;
  height: 400px;
}
h2 {
  text-align: left;
  font-size: 2em;
}
p {
  text-align: left;
}
</style>
