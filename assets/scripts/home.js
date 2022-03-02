import $ from "jquery";

$(document).on("click", "#nueva_sala", () => {
  $("#nueva_sala_form").toggle();
});

$(document).on("click", " #nuevo_amigo", () => {
  $("#nuevo_amigo_form").toggle();
});

$(document).on("click", "#nueva_sala_button", (e) => {
  e.preventDefault();
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
