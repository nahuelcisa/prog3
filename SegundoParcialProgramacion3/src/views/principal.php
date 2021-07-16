{% extends 'principal.html' %}
{% block content %}
    <div class="container w-70" style="margin-top:30px">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul id="main-nav" class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-primary" href="#" id="navbardrop" data-toggle="dropdown">
                                Listados <b class="caret"></b>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item text-primary" href="#" id="usuarios">Usuarios</a>
                                <a class="dropdown-item text-primary" href="#" id="autos">Autos</a>
                            </div>
                        </li>                   
                        <li class="dropdown dropdown">
                            <a class="nav-link text-primary" href="#" id="altaAutos">
                            Alta Autos
                            </a>
                        </li>
                        <li class="dropdown dropdown">
                        <a class="nav-link text-primary " href="#" id="navbardrop">
                            <span id="usuario_info">---</span>
                        </a>
                        </li>
                        <!---
                        <li class="dropdown dropdown" id="buscarApellido">
                            <a class="nav-link " href="#" id="altaAutos">
                            <h6>Buscar por usuario apellido</h6>
                                <form class="form-inline">
                                    <input type="text" class="form-control mb-2 ml-sm-2" id="apellido" placeholder="Apellido(op)">
                                    <button type="button" class="btn btn-primary mb-2" id="btnApellido">
                                        <i class="bi-search"></i>
                                    </button>
                                </form>
                            </a>
                        </li>
                        <li class="dropdown dropdown" id="buscarAuto">
                            <a class="nav-link " href="#" id="altaAutos">
                            <h6>Buscar por auto ID</h6>
                                <form class="form-inline">
                                    <input type="text" class="form-control mb-2 ml-sm-2" id="auto" placeholder="id(op)">
                                    <button type="button" class="btn btn-primary mb-2" id="btnAuto">
                                        <i class="bi-search"></i>
                                    </button>
                                </form>
                            </a>
                        </li>
                        !--->
                        <li class="dropdown dropdown">
                            <a class="nav-link text-primary " href="#" id="filtrarAutosPrecio">
                            Autos precio > 199999 y color != rojo
                            </a>
                        </li>
                        <li class="dropdown dropdown">
                            <a class="nav-link text-primary " href="#" id="filtrarAutosPromedio">
                            Precio promedio de autos de marcas con F.
                            </a>
                        </li>
                        <li>
                        <div class= "col-6 bg-success d-block" style="height: auto;" id="divInfo"></div>
                        </li>
                        <li class="dropdown dropdown">
                            <a class="nav-link text-primary " href="#" id="soloEmpleados">
                            Solo empleados/encargados (nombre y foto)
                            </a>
                        </li>
                        <li class="dropdown dropdown">
                            <a class="nav-link text-primary" href="#" id="Logout">
                            Logout
                            </a>
                        </li>
                    </ul>
                </div>
                
        </nav>
    </div>
    <div class="container-fluid" style="margin-top: 150px;">
        <div class="row" id="divResultado">
            <div class="col-6 bg-danger d-block" style="height: auto;" id="divIzq">
                <h1>izquierda</h1>
            </div>
            <div class= "col-6 bg-success d-block" style="height: auto;" id="divDer">
                <h1>derecha</h1>
            </div>
        </div>
    </div>
    <!---Modal para si el token se expiro o no, vuelve a login--->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Token expirado</h5>
          </div>
          <div class="modal-body">
            Para continuar operando en el sistema, debe iniciar sesion nuevamente.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick=IrLogin()>Login</button>
          </div>
        </div>
      </div>
    </div>
{% endblock %}