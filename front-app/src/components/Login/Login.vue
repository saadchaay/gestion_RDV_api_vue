<template>
  <div class="container d-flex justify-content-center">
    <div class="card mx-5 my-5">
      <div class="card-body px-2">
        <h2 class="card-heading px-3">Login</h2>
        <h5 class="card-subheading px-3 pb-3">Enter Your Reference Code</h5>
        <form v-on:submit.prevent="login">
          <div class="row rtwo">
            <div class="form-group col-md-12 fthree">
              <input
                type="reference"
                class="form-control"
                placeholder="Your Reference"
                v-model="reference"
              />
            </div>
          </div>
          <span class="error-feedback" v-if="v$.reference.$error">
            Reference, {{ v$.reference.$errors[0].$message }}</span
          >
          <div class="row rfour">
            <small class="text-muted px-3">
              <p class="para2 pl-3">
                Don't have an account?<router-link to="/sign-up"
                  >Sign Up</router-link
                >
              </p>
            </small>
            <div class="col-md-4 ml-3">
              <button type="submit" class="btn btn-primary mt-3">
                <span>Submit</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import useValidate from "@vuelidate/core";
import { required, minLength } from "@vuelidate/validators";
export default {
  name: "LoginUser",
  data: function () {
    return {
      v$: useValidate(),
      reference: "",
      data: {
        reference: "",
      },
    };
  },
  validations() {
    return {
      reference: { required, minLength: minLength(7) },
    };
  },
  methods: {
    ...mapActions(["redirectTo"]),
    async login() {
      this.v$.$validate();
      if (this.v$.$error) {
        console.log("Form validation Failed!");
      } else {
        console.log(this.reference);
        this.data.reference = this.reference;
        const res = await fetch("http://localhost/back-api/users/login", {
          method: "POST", // or 'PUT'
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(this.data),
        });
        if (res.status == 200) {
          const data = await res.json();
          localStorage.setItem("user-login", JSON.stringify(data));
          this.redirectTo({ val: "appointments" });
        }
      }
    },
  },
};
</script>

<style scoped>
.container {
  font-family: Arial, Helvetica, sans-serif;
  border-radius: 20px;
}

.card-heading,
.card-subheading {
  font-weight: bold;
}

.card {
  width: 450px;
  height: 100%;
  border: none;
  border-radius: 10px;
  opacity: 1;
}

.form-control {
  border: none;
  border-radius: 10px;
}

.form-control {
  background-color: #eee !important;
}

.form-control:focus {
  color: #495057;
  border-color: #fff !important;
  outline: 0;
  box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.25) !important;
}

.ftwo input {
  width: 120%;
  background: rgba(165, 147, 69, 0.075);
}

.para2 {
  font-size: 12px;
}

.btn-primary {
  border-radius: 8px;
  background: #2979ff;
  width: 120px;
}

.btn-primary span {
  font-size: 15px;
}
.error-feedback {
  color: red;
  font-size: 0.8em;
}
</style>
