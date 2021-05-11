{% extends 'partials/body.twig.php'  %}

{% block title %}Empresa - NEXT{% endblock %}

{% block body %}

<div class="col-md-10 center-screen bg-white padding mt-5">
    <h1>Empresa</h1>
    <hr>
    <div>
        <div style="float: left"> 
            <a href="{{BASE}}novo-empresa/" class="btn btn-info btn-sm">Nova empresa</a>
        </div>
        <div class="padding" style="float: right">
            {% include 'partials/buscarEmpresa.twig.php' %}
        </div>
    </div>
    <div>
        <table class="table table-striped">
            <thead class="thead-dark table-dark">
                <tr>
                    <td>Código</td>
                    <td>Empresa</td> 
                    <td>Usuário</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                {% for empresa in empresas %}
                    <tr>
                        <td>{{ empresa.id }}</td>
                        <td>{{ empresa.nome }}</td>  
                        <td>{{ empresa.id_usuario}}</td>  
                        <td><a href={{ empresa.link_editar}} style="color:#0000FF";>editar</a></td>
                        <td><a href={{ empresa.link_deletar}} style="color:#FF0000";>excluir</a></td>               
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}
