import $ from "jquery";
import { checkSession, loginRequest } from "../scripts/loginHandler";
import { solicitarRegistro } from "../scripts/registroHandler";
import { registro } from "../templates/registro";
import { login } from "../templates/login";

if (!checkSession()) {
  $(login).appendTo("body");
  if (document.cookie.split("=")[1] !== "") {
    $(
      `
        <p>${document.cookie.split("=")[1].split("%20").join(" ")}</p>
        <p>Ya puedes iniciar sesion</p>
      `
    ).insertAfter("#login");
  }
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
  // document.cookie =
  //   "verificado=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
});

$(document).on("click", "#registro", (e) => {
  e.preventDefault();
  console.log("ok");
  let values = {};
  $.each($("input"), function (i, field) {
    values[field.name] = field.value;
    //console.log(values);
  });
  //console.log(values);
  solicitarRegistro(
    values.username,
    values.password,
    values.repassword,
    values.email
  );
});
