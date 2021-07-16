{% extends 'registro.html' %}

{% block content %}

<div class="container " style="background-color :  rgb(153, 167,184)">
        <div class="row justify-content-center mt-5">
            <div class="row">
                <h2 class="col-2 offset-4" style="color: darkcyan;">REGISTRO</h2>
            </div>
            <div class="col-12 col-lg-4 mt-2 p-4 rounded-3 " style="background-color:lightgrey ;">
                <form action="">
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class=" fas fa-envelope pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="email" class="form-control" placeholder="Correo" id="txtCorreo">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="fas fa-key pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="password" placeholder="Contraseña" class="form-control" id="txtClave">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class=" fas fa-user pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Nombre" class="form-control" id="txtNombre">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class=" fas fa-user pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Apellido" class="form-control" id="txtApellido">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="fas fa-id-card pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <select id="dpPerfil" placeholder="Seleccionar perfil" class="form-select">
                                <option>propietario</option>
                                <option>supervisor</option>
                                <option>empleado</option>
                              </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class=" fas fa-camera pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="file" class="form-control" id="foto">
                        </div>
                    </div>
                    <div class="row content-center">
                            <br>
                            <br>
                        <div id="divResultado" class="col-12 col-md-12">
                    </div>
                    <div class="row justify-content-around mt-4">
                        <button type="submit" id="btnEnviarRegistro" class="col-5 btn btn-primary">Enviar</button>
                        <button type="reset" class="col-5 btn btn-warning text-light">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{% endblock %}