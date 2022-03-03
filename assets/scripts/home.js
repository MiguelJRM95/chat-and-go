import $ from "jquery";
import { crearSala } from "./crearSala";
import { homePrint } from "./homeHandler";

$(document).on("click", "#nueva_sala", () => {
  $("#nueva_sala_form").toggle();
});

$(document).on("click", " #nuevo_amigo", () => {
  $("#nuevo_amigo_form").toggle();
});

$(document).on("click", "#nueva_sala_button", (e) => {
  e.preventDefault();
  if ($(sala_input).val() !== "") {
    crearSala($(sala_input).val());
  }
});

$(document).on("click", "#nuevo_amigo_button", (e) => {
  e.preventDefault();
});

$(document).on("click", "#editar", () => {
  $("#perfil input").prop("disabled", false);
  $("#editar").prop("id", "cancelar");
  $("#cancelar").text("Cancelar");
  $("<button id='guardar'>Guardar</button>").insertAfter("#cancelar");
});

$(document).on("click", "#cancelar", () => {
  $("#guardar").remove();
  $("#perfil input").prop("disabled", true);
  $("#cancelar").prop("id", "editar");
  $("#editar").text("Editar Perfil");
});

$(document).on("click", "#guardar", () => {
  $("#guardar").remove();
  $("#perfil input").prop("disabled", true);
  $("#cancelar").prop("id", "editar");
  $("#editar").text("Editar Perfil");
  console.log("cambios hechos");
});

const refrescarChat = () => {
  return window.setInterval(() => {
    homePrint();
  }, 2000);
};

let intervalId;

$(document).on("click", ".sala", () => {
  intervalId = refrescarChat();
});

$(document).on("mouseover", ".sala", () => {
  clearInterval(intervalId);
});
