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
import { homePrint } from "./scripts/homeHandler";
import { amigosPrint } from "./scripts/amigoshandler";
import { perfilPrint } from "./scripts/perfilHandler";
import { apiPrint } from "./scripts/apiHandler";

const ROUTER = new Router(PATHS);

let home = document.getElementById("Home");
let amigos = document.getElementById("Amigos");
let peticiones = document.getElementById("Peticiones");
let perfil = document.getElementById("Perfil");
let api = document.getElementById("Api");

home.onclick = () => {
  ROUTER.load("home");
  homePrint();
};

amigos.onclick = () => {
  ROUTER.load("amigos");
  amigosPrint();
};

peticiones.onclick = () => {
  ROUTER.load("peticiones");
};

perfil.onclick = () => {
  ROUTER.load("perfil");
  perfilPrint();
};

api.onclick = () => {
  ROUTER.load("api");
  apiPrint();
};

homePrint();
amigosPrint();
perfilPrint();
apiPrint();
