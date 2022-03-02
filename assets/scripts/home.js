import $ from "jquery";
import { homePrint } from "../scripts/homeHandler";

$(document).on("click", ".pressable", () => {
  console.log("hello");
});

$("#content").on("DOMSubtreeModified", () => {
  //homePrint();
});
