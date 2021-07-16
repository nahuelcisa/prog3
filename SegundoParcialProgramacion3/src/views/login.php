{% extends 'login.html' %}

{% block content %}
<div class="container ">
        <div class="row justify-content-center mt-5">
            <div class="row">
                <h2 class="col-2 offset-4" style="color: darkcyan;">LOGIN</h2>
            </div>
            <div class="col-12 col-lg-4 mt-2 p-4 rounded-3 " style="background-color: lightgrey;">
                <form action="">
                    <div class="mb-3">
                        <label class="form-label text-light">Correo</label>
                        <div class="d-flex">
                            <i class="– fas fa-envelope pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="email" class="form-control" placeholder="correo" id="correo">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label text-light">Clave</label>
                        <div class="d-flex">
                            <i class="fas fa-key pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="password" placeholder="contraseña" class="form-control" id="clave">
                        </div>
                    </div>
                    <div class="row content-center">
                            <br>
                            <br>
                        <div id="divResultado" class="col-12 col-md-12">
                    </div>
                    </div>
                    <div class="row justify-content-around mt-1">
                        <button type="submit" id="btnEnviar" class="col-5 btn btn-primary">Enviar</button>
                        <button type="reset" class="col-5 btn btn-warning text-light">Limpiar</button>
                    </div>
                </form>
                <div class="row mt-4 justify-content-center">
                    <button type="button" class="btn btn-success col-11" id="btnRegistro" >Quiero registrarme!</button>
                </div>
            </div>
        </div>
    </div>
{% endblock %}