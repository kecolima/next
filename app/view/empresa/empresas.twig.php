{% extends 'partials/body.twig.php'  %}

{% block title %}Empresa - NEXT{% endblock %}

{% block body %}
<div class="col-md-10 center-screen bg-white padding mt-5">
    <h1>{{usuario}} - empresas</h1>

    <a href="{{BASE}}novo-usuario/" class="btn btn-info btn-sm">Novo usuário</a>

    <hr>
    <table class="table table-striped">
        <thead class="thead-dark table-dark">
            <tr>                
                <td>Empresa</td> 
                <td></td> 
                <td></td>   
            </tr>
        </thead>
        <tbody>
            {% for empresa in empresas %}
                <tr>
                    <td>{{ empresa.nome }}</td>
                    <td><a href={{ empresa.link_editar}} style="color:#0000FF";>editar</a></td>
                    <td><a href={{ empresa.link_deletar}} style="color:#FF0000";>excluir</a></td>                            
                </tr>
            {% endfor %}
            
        </tbody>
        
    </table>
    <div class="mt-3 text-right">
        <a href="{{BASE}}usuario/" class="btn btn-info btn-sm">Voltar</a>
    </div>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}