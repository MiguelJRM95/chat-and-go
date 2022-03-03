import $ from "jquery";

//++++++++++++++++++++++++++++++++++++++
// Carga el perfil del usuario
//+++++++++++++++++++++++++++++++++++++++
const perfilPrint = () => {
  fetch("http://127.0.0.1:8000/api/perfil", {
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
      let finalResponse = Object.keys(data).map((key) => data[key]);
      $("#amigos").empty();
      $(
        `<div style="display: flex; flex-direction: column; justify-content: space-between; margin: 20px; padding-left: 10px; padding: 10px;width: 170px; background: #fff; cursor: pointer">
            <img src='${finalResponse[1]}'>
            <label>Nombre: </label>
            <input type='text' value='${finalResponse[0]}' disabled/>
            <label>Direccion: </label>
            <input type='text' value='${finalResponse[2]}' disabled/>
            <label>Apellidos: </label>
            <input type='text' value='${finalResponse[3]} ${finalResponse[4]}' disabled/>
            <label>Frase de Estado: </label>
            <input type='text' value='${finalResponse[5]}' disabled/>
        </div>`
      ).appendTo("#perfil");
    });
};

export { perfilPrint };
