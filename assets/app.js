/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.css";

// start the Stimulus application
//import "./bootstrap";

import { Router } from "./controllers/router";
import { PATHS } from "./constants/routes";

console.log(PATHS)

const ROUTER = new Router(PATHS);

let home = document.getElementById("Home")
let about = document.getElementById("About")
let contact = document.getElementById("Contact")

home.onclick = () => {
  ROUTER.load('home')
}

about.onclick = () => {
  ROUTER.load('about')
}

contact.onclick = () => {
  ROUTER.load('contact')
}


console.log(Router)










/* import { perfil as perfil_import } from "./views/perfil.js";

window.onload = () => {
  let root = document.getElementById("root");
  let perfil = document.getElementById("perfil");
  let perfil_content = document.getElementById("template-content").content;
  perfil.addEventListener("click", (e) => {
    e.preventDefault();
    root.innerHTML = perfil_import;
  });
  let rooms = document.getElementById("rooms");
  let amigos = document.getElementById("amigos");

  let buttons = document.getElementsByClassName("pressable");
  document.addEventListener("click", (e) => {
    if (e.target && e.target.className === "pressable") {
      console.log("pressed");
    }
  });
}; */
