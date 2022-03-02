import $ from "jquery";

//++++++++++++++++++++++++++++++++++++++
// Carga los amigos del usuario
//+++++++++++++++++++++++++++++++++++++++
const apiPrint = () => {
  $(`
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <p>Hola <b>${
              JSON.parse(sessionStorage.getItem("usuario")).username
            }</b> en este enlace podrás comprobar toda la documentación para usar nuestra API y tener tu propio chat.</p>
            <a href='http://127.0.0.1:8000/api/doc' target='_blank'>API Doc</a>
            <p>Recuerda usar el token que te facilitamos como parte de la cabecera de las peticiones que asi lo requieran.</p>
            <div style='width: 70vw; font-weight: bold'>
                <code style='overflow-wrap: break-word; word-wrap: break-word;hyphens: auto;'>${JSON.parse(
                  sessionStorage.getItem("usuario")
                ).token.toString()}</code>
            </div>
            <div style='background: black; color: #fff; width: 70vw; font-weight: bold; padding: 1em'>    
                <code style='overflow-wrap: break-word; word-wrap: break-word;hyphens: auto;'>"Authorization" : "bearer ${JSON.parse(
                  sessionStorage.getItem("usuario")
                ).token.toString()}"</code>
            </div>
            <p>Disfruta de nuestro servicio.</p>
        </div>
    `).appendTo("#api");
};

export { apiPrint };
