import $ from "jquery";

const addUserSala = (salaid, nombreusuario) => {
  fetch("http://127.0.0.1:8000/api/salas_usuario/addUser", {
    method: "PUT",
    body: JSON.stringify({
      username: nombreusuario,
      sala_id: salaid,
    }),
    headers: {
      Authorization: `Bearer ${
        JSON.parse(sessionStorage.getItem("usuario")).token
      }`,
    },
  })
    .then(function (response) {
      return response.text();
    })
    .then(function (data) {
      console.log(data);
    });
};

export { addUserSala };
