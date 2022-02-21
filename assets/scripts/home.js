import $ from "jquery";

$(document).on("click", ".pressable", () => {
  console.log("hello");
});

$("#content").on("DOMSubtreeModified", () => {
  console.log("cargada");
});
