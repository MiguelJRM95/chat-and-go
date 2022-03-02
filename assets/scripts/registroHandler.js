import $ from "jquery";

const solicitarRegistro = (username, pass, repass, email) => {
  fetch("http://127.0.0.1:8000/api/alta", {
    method: "POST",
    body: JSON.stringify({
      username: username,
      password: { first_pass: pass, second_pass: repass },
      email: email,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then(function (response) {
      return response.json();
      //console.log(response);
    })
    .then(function (data) {
      let finalResponse = Object.keys(data).map((key) => data[key]);
      if (isNaN(finalResponse[0])) {
        $("#registro").next().remove("p");
        $(`<p id='error'>${finalResponse[0]}</p>`).insertAfter("#registro");
        return;
      }
      $("#registro").next().remove("p");
      $(
        `<p id='error'>Enhorabuena ${username}, revisa tu correo para activar tu cuenta</p>`
      ).insertAfter("#registro");
    });
};

export { solicitarRegistro };
