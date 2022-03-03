import $ from "jquery";
import { mensajesSalaPrint } from "./mensajesSalaHandler";

//++++++++++++++++++++++++++++++++++++++
// Carga las salas del usuario al hacer login
//+++++++++++++++++++++++++++++++++++++++
const homePrint = () => {
  fetch("http://127.0.0.1:8000/api/salas_usuario", {
    method: "GET",
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
      $("#salas").empty();
      data.forEach((sala) => {
        $(
          `<div style="display: flex; flex-direction: row; justify-content: space-between; margin: 20px; padding-left: 10px; padding-right: 10px;width: 200px; background: #fff; cursor: pointer" class='sala'><p>ID: ${sala.id}</p><p>Nombre: ${sala.nombre_sala}</p></div>
          <form id='añadir_usuario_form' style="margin: 8px;">
              <input style='height: 30px;' type='text' placeholder='Introduce el nombre del usuario' id='usuario_input_${sala.id}'>
              <button style="background: coral; margin: 0;padding: 3px; color: #fff; font-weight: bold; height: 35px;" id='nuevo_usuario_button'>Añadir Usuario</button>
            </form>
          `
        ).appendTo("#salas");
        $(
          `<div id='${sala.id}' style='border: 1px solid coral; display: flex; flex-direction: column; justify-content: center; align-items:center; width: 60vw'></div>
          `
        ).appendTo("#salas");
        $(
          `<form id='enviar_mensaje_form' style="margin: 8px;">
          <input style='height: 30px;' type='text' placeholder='Introduce el mensaje' id='mensaje_input_${sala.id}'>
          <button style="background: coral; margin: 0;padding: 3px; color: #fff; font-weight: bold; height: 35px;" id='enviar_mensaje_button_${sala.id}' class='mensaje_button' value=${sala.id}>Enviar</button>
        </form>
          `
        ).appendTo("#salas");
      });
      if ($("#salas").children().length === 0) {
        $("<p>Actualmente no estás en ninguna sala</p>").appendTo("#salas");
      }
      return data;
    })
    .then(function (data) {
      //+++++++++++++++++++++++++++++++++++++
      //MUESTRA MENSAJES+++++++++++++++++++++
      //+++++++++++++++++++++++++++++++++++++
      data.forEach((sala) => {
        fetch("http://127.0.0.1:8000/api/messages_by_sala", {
          method: "POST",
          body: JSON.stringify({
            sala_id: sala.id,
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
            //+++++++++++++++++++++++++++++++++++++
            //ORDENO MENSAJES+++++++++++++++++++++
            //+++++++++++++++++++++++++++++++++++++
            let finalResponse = Object.keys(data)
              .map((key) => data[key])
              .reverse();
            //+++++++++++++++++++++++++++++++++++++
            //INSERTO LOS MENSAJES EN LOS CHATS+++++++++++++++++++++
            //+++++++++++++++++++++++++++++++++++++
            finalResponse.forEach((mensaje) => {
              if (
                mensaje.usuario ===
                JSON.parse(sessionStorage.getItem("usuario")).username
              ) {
                $(`
                <div style='border: 2px solid black; width:fit-content; align-self: flex-end; padding: 8px; margin: 0.7em'>
                  <span>Fecha: ${mensaje.fecha}</span>
                  <br>
                  <p>${mensaje.contenido}</p>
                  <p>Usuario: ${mensaje.usuario}</p>
                </div>
                `).appendTo($(`#${sala.id}`));
              } else {
                $(`
                <div style='border: 2px solid black; width:fit-content; align-self: flex-start; padding: 8px; margin: 0.7em'>
                  <span>Fecha: ${mensaje.fecha}</span>
                  <br>
                  <p>${mensaje.contenido}</p>
                  <p>Usuario: ${mensaje.usuario}</p>
                </div>
                `).appendTo($(`#${sala.id}`));
              }
            });
          });
      });
      return data;
    })
    .then((data) => {
      console.log(data);
      console.log($(".mensaje_button"));
      data.forEach((sala) => {
        console.log(sala.id);
        $(`#enviar_mensaje_button_${sala.id}`).on("click", function (e) {
          e.preventDefault();

          console.log(this.id.split("_")[3]);
          console.log($(`#mensaje_input_2`));
          console.log($(`#mensaje_input_${this.id.split("_")[3]}`).val());
        });
      });
      //++++++++++++++++++++++++++++++++++++++++++
      //++DETECTA A QUE SAlA PERTENECE Y ENVIA EL MENSAJE
      //++++++++++++++++++++++++++++++++++++++++++++++++++
      $("#enviar_mensaje_button").on("click", (e) => {
        e.preventDefault();
        console.log($(this.prev()));
      });
    });
};

export { homePrint };
