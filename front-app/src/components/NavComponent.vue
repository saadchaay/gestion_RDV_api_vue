<template>
  <header>
    <h2 class="logo">
      <router-link to="/"> Clean<span>Teeth</span></router-link>
    </h2>
    <nav>
      <ul v-if="this.reference">
        <li><router-link to="/">Home</router-link></li>
        <li><router-link to="/appointments">Appointment</router-link></li>
      </ul>
      <ul v-if="!this.reference">
        <li class="marginLeft">
          <button @click="redirectTo({ val: 'Login' })">Login</button>
        </li>
        <li>
          <button @click="redirectTo({ val: 'SignUp' })">Sign Up</button>
        </li>
      </ul>
      <ul v-if="this.reference">
        <li class="ref"><b> Ref: </b>{{ this.reference }}</li>
        <li>
          <button @click="logout()">Log Out</button>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "NavComponent",
  props: {
    ref_user: String,
  },
  data: function () {
    return {
      reference: "",
    };
  },
  mounted() {
    this.reference = localStorage.getItem("reference");
  },
  components: {},
  methods: {
    ...mapActions(["redirectTo"]),
    logout() {
      localStorage.clear();
      this.redirectTo({ val: "Login" });
    },
  },
};
</script>

<style scoped>
header {
  display: flex;
  justify-content: space-around;
  align-items: center;
  background-color: #f1f1f1;
  height: 80px;
}
h2 {
  flex: 1;
  text-align: center;
  margin: 0;
}
.logo {
  margin-left: 1em;
}
span {
  color: blue;
}
nav {
  flex: 3;
  display: flex;
  justify-content: space-around;
  align-items: center;
}
ul {
  display: flex;
  justify-content: space-around;
  align-items: center;
  margin: 0;
}
li {
  list-style: none;
  margin: 0 1.2em;
  white-space: nowrap;
}
li:hover {
  font-weight: bold;
}
li.btn:hover {
  font-weight: normal;
}
a {
  text-decoration: none;
  color: rgb(61, 61, 61);
}
button {
  font-size: 1em;
  padding: 0.6em 0.7em;
  color: white;
  background: rgb(89, 145, 250);
  border: none;
  border-radius: 8px;
}
button:hover {
  cursor: pointer;
  font-weight: bold;
}
.marginLeft {
  margin-left: 35em;
}
.ref:hover {
  font-weight: normal;
}
</style>
