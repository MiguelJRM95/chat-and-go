const PATHS = {
  login: {
    path: "/login",
    template: `
        <div id='login-container'>
            <div id='form-container'>
                <p>Inicia Sesion</p>
                <form class='myform'>
                    <div>
                        <label>Username</label>
                        <input type='text' name='username'/>
                    </div>
                    <div>
                        <label>Contraseña</label>
                        <input type='password' name='password'/>
                    </div>
                    <button id='login'>Login</button>
                </form>
                <a href='#' class='form-link'>Registrarse</a>
            </div>
        </div>
        `,
  },
  registro: {
    path: "/registro",
    template: `
          <div id='login-container'>
              <div id='form-container'>
                  <p>Registro</p>
                  <form>
                      <div>
                          <label>Username</label>
                          <input type='text' name='username'/>
                      </div>
                      <div>
                          <label>Contraseña</label>
                          <input type='password' name='password'/>
                      </div>
                      <div>
                          <label>Repite Contraseña</label>
                          <input type='password' name='repassword'/>
                      </div>
                      <div>
                          <label>Email</label>
                          <input type='email' name='email'/>
                      </div>
                      <button id='registro'>Sign Up</button>
                  </form>
                  <a href='#' class='form-link'>Iniciar Sesión</a>
              </div>
          </div>
          `,
  },
  home: {
    path: "/",
    template: `
            <h1>🏠 Salas</h1>
            <button id='nueva_sala'>Nueva Sala</button>
            <form id='nueva_sala_form' style="display: none; margin: 8px;">
              <input style='height: 30px;' type='text' placeholder='Introduce el nombre de la sala' id='sala_input'>
              <button style="background: coral; margin: 0;padding: 3px; color: #fff; font-weight: bold; height: 35px; width: 30px" id='nueva_sala_button'>+</button>
            </form>
            <div id="salas" style="display: row"></div>
        `,
  },
  amigos: {
    path: "/amigos",
    template: `
            <h1>Amigos</h1>
            <button id='nuevo_amigo'>Añadir Amigo</button>
            <form id='nuevo_amigo_form' style="display: none; margin: 8px;">
              <input style='height: 30px;' type='text' placeholder='Introduce el nombre de usuario'>
              <button style="background: coral; margin: 0;padding: 3px; color: #fff; font-weight: bold; height: 35px; width: 30px" id='nuevo_amigo_button'>+</button>
            </form>
            <div id="amigos"></div>
        `,
  },
  peticiones: {
    path: "/peticiones",
    template: `
            <h1>📱 Peticiones</h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsum harum aliquam reiciendis dignissimos? Perferendis consequuntur vitae fugiat fuga neque ipsum?</p>
            <img src="https://source.unsplash.com/random/600x500" alt="Random Image">
        `,
  },
  perfil: {
    path: "/perfil",
    template: `
            <h1>📱 Perfil</h1>
            <button id='editar'>Editar Perfil</button>
            <div id="perfil" style='display: flex; justify-content: center;'></div>
        `,
  },
  api: {
    path: "/api",
    template: `
            <h1>📱 Api</h1>
            <div id="api" style='display: flex; flex-direction:column; justify-content: center; align-items: center;'></div>
        `,
  },
  error: {
    path: "/error",
    template: `
            <h1>Error 404</h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsum harum aliquam reiciendis dignissimos? Perferendis consequuntur vitae fugiat fuga neque ipsum?</p>
            <img src="https://source.unsplash.com/random/600x500" alt="Random Image">
        `,
  },
};

export { PATHS };
