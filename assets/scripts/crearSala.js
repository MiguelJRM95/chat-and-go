import $ from "jquery";
import { homePrint } from "./homeHandler";

const crearSala = (nombreSala) => {
  fetch("http://127.0.0.1:8000/api/salas_usuario/add", {
    method: "POST",
    body: JSON.stringify({
      nombre_sala: nombreSala,
    }),
    headers: {
      Authorization: `Bearer ${
        JSON.parse(sessionStorage.getItem("usuario")).token
      }`,
    },
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      let finalResponse = Object.keys(data).map((key) => data[key]);
      $(`<p>Sala ${nombreSala} creada</p>`).insertBefore($("#nueva_sala"));
    })
    .then(function (data) {
      $("#nueva_sala_form").toggle();
      $(sala_input).val("");
      homePrint();
    });
};

export { crearSala };
