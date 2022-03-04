class Router {
  /**
   * Metodo inicial.
   *
   * @return {void}.
   */
  constructor(paths) {
    this.paths = paths;
    this.initRouter();
  }

  /**
   * Permite inicializar el router
   *
   * @return {void}.
   */
  initRouter() {
    const {
      location: { pathname = "/" },
    } = window;
    if (!this.checkSession) {
      const URI = pathname === "/" ? "home" : pathname.replace("/", "");
      this.load(URI);
    } else {
      const URI = pathname === "/" ? "login" : pathname.replace("/", "");
      this.load(URI);
    }
  }

  /**
   * Permite iniciar la carga de paginas.
   *
   * @return {void}.
   */
  load(page = "home") {
    const { paths } = this;
    console.log(this);
    console.log(page);
    if (!this.checkSession) {
      const { path, template } = paths[login] || paths.error;
      const $CONTAINER = document.querySelector("#content");
      $CONTAINER.innerHTML = template;
      window.history.pushState({}, "Genial", path);
    } else {
      const { path, template } = paths[page] || paths.error;
      const $CONTAINER = document.querySelector("#content");
      $CONTAINER.innerHTML = template;
      window.history.pushState({}, "Genial", path);
    }
  }

  checkSession() {
    if (sessionStorage.getItem("usuario")) {
      return true;
    }
    return false;
  }
}

export { Router };
