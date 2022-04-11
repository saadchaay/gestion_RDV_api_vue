<template>
  <div class="container d-flex justify-content-center">
    <div class="card mx-5 my-5">
      <div class="card-body px-2">
        <h2 class="card-heading px-3">Sign Up</h2>
        <h5 class="card-subheading px-3 pb-3">It's quick and easy.</h5>
        <div class="alert" v-if="success.ref != ''">
          {{ success.msg }}<br />
          Your Reference: <span class="ref"> {{ success.ref }} </span>
        </div>
        <form v-on:submit.prevent="submit">
          <div class="row rone">
            <div class="form-group col-md-5 fone">
              <input
                type="text"
                class="form-control"
                placeholder="First name"
                v-model="firstName"
              />
            </div>
            <div class="form-group col-md-5 ftwo">
              <input
                type="text"
                class="form-control ml-3"
                placeholder="Last name"
                v-model="lastName"
              />
            </div>
          </div>
          <span class="error-feedback" v-if="v$.firstName.$error"
            >First Name, {{ v$.firstName.$errors[0].$message }}</span
          >
          <span class="error-feedback" v-else-if="v$.lastName.$error">
            Last Name, {{ v$.lastName.$errors[0].$message }}</span
          >
          <div class="row rtwo">
            <div class="form-group col-md-12 fthree">
              <input
                type="email"
                class="form-control"
                placeholder="Your Email "
                v-model="email"
              />
            </div>
          </div>
          <span class="error-feedback" v-if="v$.email.$error">{{
            v$.email.$errors[0].$message
          }}</span>
          <div class="row rtwo">
            <div class="form-group col-md-12 fthree">
              <input
                type="text"
                class="form-control"
                placeholder="Mobile Number"
                v-model="phone"
              />
            </div>
          </div>
          <span class="error-feedback" v-if="v$.phone.$error">{{
            v$.phone.$errors[0].$message
          }}</span>
          <div class="row rfour">
            <small class="text-muted px-3">
              <p class="para2 pl-3">
                Already have an account?<router-link to="/login"
                  >Login</router-link
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
import {
  required,
  email,
  numeric,
  minLength,
  alpha,
} from "@vuelidate/validators";
export default {
  name: "SignUpUser",
  data: function () {
    return {
      v$: useValidate(),
      userData: {},
      success: {
        ref: "",
        msg: "",
      },
      firstName: "",
      lastName: "",
      email: "",
      phone: "",
    };
  },
  validations() {
    return {
      firstName: { required, alpha },
      lastName: { required, alpha },
      email: { required, email },
      phone: { required, numeric, minLength: minLength(10) },
    };
  },
  mounted() {
    // this.check_login();
  },
  methods: {
    ...mapActions(["redirectTo"]),
    async submit() {
      this.v$.$validate();
      if (!this.v$.$error) {
        this.userData = {
          firstName: this.firstName,
          lastName: this.lastName,
          email: this.email,
          phone: this.phone,
        };
        const res = await fetch("http://localhost/back-api/users/register", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(this.userData),
        });
        if (res.status == 200) {
          const data = await res.json();
          localStorage.setItem("reference", data.reference);
          this.redirectTo({ val: "appointments" });
        }
      } else {
        console.log("Form validation Failed!");
      }
    },
    check_login() {
      const if_loggedIn = localStorage.getItem("reference");
      if (if_loggedIn) {
        this.reference = if_loggedIn;
      } else {
        console.log("User not logged In yet!");
      }
    },
  },
};
</script>

<style scoped>
.container {
  /* background-image: url("../../assets/banner-form.jpg"); */
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

.fone {
  padding-left: 30px;
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

.fone input {
  width: 120%;
  background: rgba(165, 147, 69, 0.075);
}

.ftwo input {
  width: 120%;
  background: rgba(165, 147, 69, 0.075);
}

.fthree {
  padding-left: 30px;
  padding-right: 45px;
}

.fthree input {
  background-color: rgba(165, 147, 69, 0.075);
}

.ffour {
  padding-left: 30px;
}

.ffour input {
  width: 120%;
  background-color: rgba(165, 147, 69, 0.075);
}

.ffive input {
  width: 120%;
  background-color: rgba(165, 147, 69, 0.075);
}

.rthree {
  padding-top: 1px;
}

.para1 {
  height: 10px;
  font-size: 12px;
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
.alert {
  padding: 0.6em 20px;
  background-color: #5dac28;
  color: white;
}
.ref {
  font-weight: bold;
}
.error-feedback {
  color: red;
  font-size: 0.8em;
}

@media screen and (max-width: 768px) {
  .fone input {
    width: 90%;
  }

  .ftwo input {
    width: 86%;
  }

  .fthree {
    width: 110%;
  }

  .ffour input {
    width: 90%;
  }

  .ffive input {
    width: 86%;
  }
}
</style>
