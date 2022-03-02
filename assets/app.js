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

const ROUTER = new Router(PATHS);

let home = document.getElementById("Home");
let amigos = document.getElementById("Amigos");
let peticiones = document.getElementById("Peticiones");
let salas = document.getElementById("Salas");

home.onclick = () => {
  ROUTER.load("home");
};

amigos.onclick = () => {
  ROUTER.load("amigos");
};

peticiones.onclick = () => {
  ROUTER.load("peticiones");
};

salas.onclick = () => {
  ROUTER.load("salas");
};
