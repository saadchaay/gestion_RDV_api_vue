<template>
  <!-- Section 1 -->
  <section class="relative w-full px-8 text-gray-700 bg-white body-font">
    <div
      class="container flex flex-col flex-wrap items-center justify-between py-5 mx-auto md:flex-row max-w-7xl"
    >
      <router-link
        to="/"
        class="relative z-10 flex items-center w-auto text-2xl font-extrabold leading-none text-blue-600 select-none"
        >CleanTeeth.</router-link
      >

      <nav
        v-if="this.reference"
        class="top-0 left-0 z-0 flex items-center justify-center w-full h-full py-5 -ml-0 space-x-5 text-base md:-ml-5 md:py-0 md:absolute"
      >
        <router-link
          to="/"
          class="relative font-medium leading-6 text-gray-600 transition duration-150 ease-out hover:text-gray-900"
          x-data="{ hover: false }"
          @mouseenter="hover = true"
          @mouseleave="hover = false"
        >
          <span class="block">Home</span>
          <span
            class="absolute bottom-0 left-0 inline-block w-full h-0.5 -mb-1 overflow-hidden"
          >
            <span
              x-show="hover"
              class="absolute inset-0 inline-block w-full h-1 h-full transform bg-gray-900"
              x-transition:enter="transition ease duration-200"
              x-transition:enter-start="scale-0"
              x-transition:enter-end="scale-100"
              x-transition:leave="transition ease-out duration-300"
              x-transition:leave-start="scale-100"
              x-transition:leave-end="scale-0"
            ></span>
          </span>
        </router-link>
        <router-link
          to="/appointments"
          class="relative font-medium leading-6 text-gray-600 transition duration-150 ease-out hover:text-gray-900"
          x-data="{ hover: false }"
          @mouseenter="hover = true"
          @mouseleave="hover = false"
        >
          <span class="block">Appointment</span>
          <span
            class="absolute bottom-0 left-0 inline-block w-full h-0.5 -mb-1 overflow-hidden"
          >
            <span
              x-show="hover"
              class="absolute inset-0 inline-block w-full h-1 h-full transform bg-gray-900"
              x-transition:enter="transition ease duration-200"
              x-transition:enter-start="scale-0"
              x-transition:enter-end="scale-100"
              x-transition:leave="transition ease-out duration-300"
              x-transition:leave-start="scale-100"
              x-transition:leave-end="scale-0"
            ></span>
          </span>
        </router-link>
      </nav>

      <div
        v-if="!this.reference"
        class="relative z-10 inline-flex items-center space-x-3 md:ml-5 lg:justify-end"
      >
        <router-link
          to="/login"
          class="inline-flex items-center justify-center px-4 py-2 text-base font-medium leading-6 text-gray-600 whitespace-no-wrap bg-white border border-gray-200 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:shadow-none"
        >
          Sign in
        </router-link>
        <span class="inline-flex rounded-md shadow-sm">
          <router-link
            to="/sign-up"
            class="inline-flex items-center justify-center px-4 py-2 text-base font-medium leading-6 text-white whitespace-no-wrap bg-blue-600 border border-blue-700 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            Sign up
          </router-link>
        </span>
      </div>
      <div
        v-if="this.reference"
        class="relative z-10 inline-flex items-center space-x-3 md:ml-5 lg:justify-end"
      >
        <a
          href="#"
          class="inline-flex items-center justify-center px-4 py-2 text-base font-medium leading-6 text-gray-600 whitespace-no-wrap bg-white border border-gray-200 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:shadow-none"
        >
          {{ this.reference }}
        </a>
        <span class="inline-flex rounded-md shadow-sm">
          <button
            @click="logout()"
            class="inline-flex items-center justify-center px-4 py-2 text-base font-medium leading-6 text-white whitespace-no-wrap bg-blue-600 border border-blue-700 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            Logout
          </button>
        </span>
      </div>
    </div>
  </section>
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

<!-- <style scoped>
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
  flex-wrap: wrap;
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
</style> -->
