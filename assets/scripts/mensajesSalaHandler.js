import $ from "jquery";

//++++++++++++++++++++++++++++++++++++++
// Carga las salas del usuario al hacer login
//+++++++++++++++++++++++++++++++++++++++
const mensajesSalaPrint = (sala_id) => {
  fetch("http://127.0.0.1:8000/api/messages_by_sala", {
    method: "POST",
    body: JSON.stringify({
      sala_id: sala_id,
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
      //console.log(Object.keys(data).map((key) => data[key]));
      $(`<p>hello</p>`).appendTo($(`${sala_id}`));
    });
};

export { mensajesSalaPrint };
