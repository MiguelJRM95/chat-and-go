import $ from "jquery";

//++++++++++++++++++++++++++++++++++++++
// Carga los amigos del usuario
//+++++++++++++++++++++++++++++++++++++++
const amigosPrint = () => {
  fetch("http://127.0.0.1:8000/api/amigos", {
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
      Array.from(finalResponse).forEach((amigo) => {
        $(
          `<div style="display: flex; flex-direction: column; justify-content: space-between; margin: 20px; padding-left: 10px; padding-right: 10px;width: 170px; background: #fff; cursor: pointer"><img src='${
            amigo.perfil.avatar
          }'><p>Nickname: <br> ${amigo.username}</p><p>Frase de estado: <br>"${
            amigo.perfil.frase_estado || "Sin estado"
          }"</p></div>`
        ).appendTo("#amigos");
      });
      if ($("#amigos").children().length === 0) {
        $("<p>Actualmente no tienes amigos</p>").appendTo("#amigos");
      }
    });
};

export { amigosPrint };
