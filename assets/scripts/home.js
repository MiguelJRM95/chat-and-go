import $ from "jquery";

console.log($(".pressable"));
$(".pressable").on("click", () => {
  console.log("hello");
});
