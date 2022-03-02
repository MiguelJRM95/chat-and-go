import $ from "jquery";

//++++++++++++++++++++++++++++++++++++++
// Carga las salas del usuario al hacer login
//+++++++++++++++++++++++++++++++++++++++
const amigosPrint = () => {
  let xhr = new XMLHttpRequest();

  xhr.onload = () => {
    if (xhr.status >= 200 && xhr.status < 300) {
      const response = JSON.parse(xhr.responseText);
      $("#salas").empty();
      response.forEach((sala) => {
        $(
          `<div style="display: flex; flex-direction: row; justify-content: space-between; margin: 20px; padding-left: 10px; padding-right: 10px;width: 200px; background: #fff; cursor: pointer"><p>ID: ${sala.id}</p><p>Nombre: ${sala.nombre_sala}</p></div>`
        ).appendTo("#salas");
      });
    }
  };

  xhr.onreadystatechange = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 401) {
      //$("<p>No </p>").insertAfter("#login");
      console.log("no se han podido cargar las salas");
    }
  };

  xhr.open("GET", "http://127.0.0.1:8000/api/salas_usuario");
  xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");
  xhr.setRequestHeader(
    "Authorization",
    `Bearer ${JSON.parse(sessionStorage.getItem("usuario")).token}`
  );
  xhr.send();
};

export { homePrint };
