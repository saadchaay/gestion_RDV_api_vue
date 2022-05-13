<template>
  <button :align="{ pos }">
    <router-link to="/appointments" class="btn"> {{ title }} </router-link>
  </button>
</template>

<script>
export default {
  name: "BtnComponent",
  props: {
    title: String,
    pos: {
      type: String,
      default: "center",
    },
  },
};
</script>

<style scoped>
button {
  background: none;
  border: none;
}
.btn {
  font-size: 1em;
  padding: 0.6em 0.7em;
  color: white;
  background: rgb(89, 145, 250);
  border: none;
  border-radius: 8px;
}
.btn:hover {
  cursor: pointer;
  font-weight: bold;
}
</style>
