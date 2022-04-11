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
    this.redirectTo({ val: "appointments" });
  },
  methods: {
    ...mapActions(["redirectTo"]),
  },
};
</script>
