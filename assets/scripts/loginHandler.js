import $ from "jquery";

const checkSession = () => {
  if (!sessionStorage.getItem("usuario")) {
    return false;
  }

  return true;
};

//CREAR FUNCIONES LLENADO DE SECCIONES
const loginRequest = (data) => {
  let xhr = new XMLHttpRequest();

  xhr.onload = () => {
    if (xhr.status >= 200 && xhr.status < 300) {
      const response = JSON.parse(xhr.responseText);
      sessionStorage.setItem("usuario", JSON.stringify(response));
      $("#login-container")
        .fadeOut()
        .promise()
        .then(() => console.log(sessionStorage.getItem("usuario")));
    }
  };

  xhr.onreadystatechange = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 401) {
      $("<p>Usuario o contraseña incorrectos</p>").insertAfter("#login");
    }
  };

  xhr.open("POST", "http://127.0.0.1:8000/api/login_check");
  xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");
  xhr.send(JSON.stringify(data));
};

export { checkSession, loginRequest };
