import $ from "jquery";
import { checkSession } from "../scripts/loginHandler";
import { login } from "../templates/login";

$(document).on("click", "#Logout", () => {
  $("#salas #amigos").empty();
  sessionStorage.removeItem("usuario");
  if (!checkSession()) {
    $(login).appendTo("body");
  }
});
