<template>
  <div>
    <div class="container" v-if="this.success">
      <div class="alert alert-success">
        {{ this.success }}
      </div>
      <button class="btn btn-secondary" v-on:click="back()">Back</button>
    </div>
    <div class="container" v-if="!this.all_apt.dateApt">
      <h4>{{ title }}</h4>
      <form v-on:submit.prevent="getAPP">
        <input type="text" placeholder="Topic of appointment" v-model="topic" />
        <br /><span class="error-feedback" v-if="v$.topic.$error">{{
          v$.topic.$errors[0].$message
        }}</span>
        <input type="date" v-model="dateApt" />
        <br /><span class="error-feedback" v-if="v$.dateApt.$error">{{
          v$.dateApt.$errors[0].$message
        }}</span>
        <button type="submit" class="btn btn-primary mt-3">
          <span>Search</span>
        </button>
      </form>
    </div>
    <div class="container mt-4" v-if="this.all_apt.dateApt && !this.success">
      <h3>Schedules Available</h3>
      <div class="d-flex justify-content-center row flex-wrap">
        <div
          class="card"
          style="width: 10rem"
          v-for="schedule in all_schedules"
          v-bind:key="schedule.id"
        >
          <div class="card-body">
            <h6 class="card-title">
              Start: <span>{{ schedule.start }}</span>
            </h6>
            <h6 class="card-title">
              End: <span>{{ schedule.end }}</span>
            </h6>
            <button class="btn btn-info" v-on:click="take(schedule.id)">
              Take this
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import useValidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { mapActions } from "vuex";
export default {
  name: "SchComp",
  props: {
    id: {
      type: Number,
      default: 0,
    },
    title: {
      type: String,
      default: "Add Appointment",
    },
  },
  data: function () {
    return {
      v$: useValidate(),
      dateApt: "",
      topic: "",
      all_schedules: {},
      success: "",
      all_apt: {},
    };
  },
  validations() {
    return {
      dateApt: { required },
      topic: { required },
    };
  },
  mounted() {
    console.log(this.id_appointment);
  },
  methods: {
    ...mapActions(["redirectTo"]),
    back() {
      this.redirectTo({ val: "appointment" });
    },

    // get schedules available
    async getAPP() {
      this.v$.$validate();
      if (!this.v$.$error) {
        this.all_apt.dateApt = this.dateApt;
        const res = await fetch(
          "http://localhost/back-api/appointments/schedules",
          {
            method: "POST",
            headers: {
              "content-type": "application/json",
            },
            body: JSON.stringify(this.all_apt),
          }
        );
        const data = await res.json();
        this.all_schedules = data;
      }
    },

    // add appointment && update appointment
    async take(id) {
      this.all_apt = {
        id_apt: this.id,
        schedule: id,
        sjtApt: this.topic,
        ref_user: localStorage.getItem("reference"),
        dateApt: this.dateApt,
      };

      // ADD
      if (this.id == 0) {
        const res = await fetch(
          "http://localhost/back-api/appointments/create",
          {
            method: "POST",
            headers: {
              "content-type": "application/json",
            },
            body: JSON.stringify(this.all_apt),
          }
        );
        const data = await res.json();
        this.success = data.Success;

        // UPDATE
      } else {
        const res = await fetch("http://localhost/back-api/appointments/edit", {
          method: "PATCH",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify(this.all_apt),
        });
        const data = await res.json();
        if (data) {
          this.success = data.Success;
        } else {
          console.log("Error to update appointment!");
        }
      }
    },
  },
};
</script>
<style scoped>
form {
  width: 330px;
  border-top: 1px dotted #d9d9d9;
  margin: 10px auto;
}
input[type="button"] {
  width: auto;
}
button {
  color: #4c4c4c;
}
input {
  width: 250px;
  padding: 5px;
  margin: 10px 0 10px;
  border-radius: 5px;
  border: 1px solid #acbfa5;
}
.card {
  margin: 0.8em 1.3em;
}
.card-title {
  font-weight: bold;
}
.card-title span {
  color: #6665ee;
}
input[type="submit"] {
  width: 100px;
  background-color: #6665ee;
  border-radius: 5px;
  border: 2px solid #4443ea;
  color: #fff;
}
h4 {
  color: #4c4c4c;
  text-align: center;
}
.container {
  text-align: center;
  width: 80%;
  border: 1px solid #d0d0d0;
  background-color: #fff;
  padding-top: 40px;
  padding-bottom: 40px;
  border-radius: 5px;
  margin: 2em auto;
}
.btn {
  width: 90%;
  color: #ffffff;
}
.error-feedback {
  color: red;
  font-size: 0.8em;
}
</style>
