<template>
  <div v-if="this.id_appointment">
    <SchComp :id="this.id_appointment" :title="this.title" />
  </div>
  <div class="container mt-5" v-if="this.success">
    <div class="alert alert-success">
      {{ this.success }}
    </div>
    <button class="btn btn-secondary" v-on:click="back()">Back</button>
  </div>
  <div class="container mt-4" v-if="!this.success && !this.id_appointment">
    <div class="text-left">
      <button
        type="button"
        class="btn btn-secondary my-3"
        @click="goAppointment()"
      >
        Add an Appointment
      </button>
    </div>
    <div class="d-flex justify-content-center row">
      <div class="col-md-12">
        <div class="rounded">
          <div class="table-responsive table-borderless">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Appointment Topic</th>
                  <th>Appointment Date</th>
                  <th>Schedules</th>
                  <th>Duration</th>
                  <th>Actions</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="table-body">
                <tr
                  class="cell-1"
                  v-for="apt in appointments"
                  v-bind:key="apt.id"
                >
                  <td class="text-center">{{ apt.id_apt }}</td>
                  <td>{{ apt.sujetApt }}</td>
                  <td>{{ apt.dateApt }}</td>
                  <td>{{ apt.start_time }}</td>
                  <td>{{ apt.duration }}</td>
                  <td>
                    <button
                      class="btn btn-info"
                      v-on:click="update(apt.id_apt)"
                    >
                      Edit
                    </button>
                    <button
                      class="btn btn-danger ml-1"
                      v-on:click="cancel(apt.id_apt)"
                    >
                      Cancel
                    </button>
                  </td>
                </tr>
                <tr class="alert-error" v-if="this.error">
                  <td colspan="7">{{ this.error }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions } from "vuex";
import SchComp from "./SchComp.vue";

export default {
  name: "AptComponent",
  data: function () {
    return {
      title: "Edit Appointment",
      id_appointment: "",
      ref: { reference: "" },
      appointments: {},
      error: "",
      success: "",
    };
  },
  mounted() {
    this.getAll();
  },
  methods: {
    ...mapActions(["redirectTo"]),
    goAppointment() {
      this.redirectTo({ val: "schedules" });
    },
    back() {
      this.success = "";
    },
    async getAll() {
      this.ref.reference = localStorage.getItem("reference");
      const res = await fetch("http://localhost/back-api/appointments/all", {
        method: "POST",
        Headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(this.ref),
      });
      const data = await res.json();
      switch (res.status) {
        case 200:
          this.appointments = data.Appointments;
          break;
        case 404:
          this.error = data.Error;
          break;
      }
    },
    //cancel appointment
    async cancel(id) {
      const res = await fetch(
        "http://localhost/back-api/appointments/cancel/" + id,
        {
          method: "DELETE",
          headers: {
            "content-type": "application/json",
          },
        }
      );
      const data = await res.json();
      this.success = data.Success;
    },
  },
  components: { SchComp },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css?family=Assistant");

body {
  background: #eee;
  font-family: Assistant, sans-serif;
}

.cell-1 {
  border-collapse: separate;
  border-spacing: 0 4em;
  background: #fff;
  border-bottom: 5px solid transparent;
  background-clip: padding-box;
}

thead {
  background: #dddcdc;
}
.alert-error {
  background-color: rgb(255, 177, 88);
}
</style>
