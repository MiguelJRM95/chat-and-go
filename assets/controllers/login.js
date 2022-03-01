import $ from "jquery";
import { checkSession, loginRequest } from "../scripts/loginHandler";
import { registro } from "../templates/registro";
import { login } from "../templates/login";

sessionStorage.removeItem("usuario");
//console.log(sessionStorage.getItem("usuario"));

if (!checkSession()) {
  $(login).appendTo("body");
}

$(document).on("click", ".form-link", (e) => {
  e.preventDefault();
  if (e.target.innerText.toLowerCase() === "iniciar sesión") {
    $(login).appendTo("body");
  }

  if (e.target.innerText.toLowerCase() === "registrarse") {
    $(registro).appendTo("body");
  }
});

$(document).on("click", "#login", (e) => {
  e.preventDefault();
  let values = {};
  $.each($("input"), function (i, field) {
    values[field.name] = field.value;
  });
  loginRequest(JSON.parse(JSON.stringify(values)));
});

$(document).on("click", "#registro", (e) => {
  e.preventDefault();
  console.log("ok");
});
