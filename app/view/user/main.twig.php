{% extends 'partials/body.twig.php'  %}

{% block title %}Usuário - Mini Framework{% endblock %}

{% block body %}
<div class="max-width center-screen bg-white padding">
    <h1>Usuário</h1>
    <hr> 
    <div>
        <div style="float: left"> 
            <a href="{{BASE}}novo-user/" class="btn btn-info btn-sm">Novo usuário</a>
        </div>
        <div class="padding" style="float: right">   
            {% include 'partials/buscarUser.twig.php' %}
        </div>
    </div>
    <div>
        <table class="table table-striped">
            <thead class="thead-dark table-dark">
                <tr>                
                    <td>Usuário</td> 
                    <td>Email</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                {% for user in users %}
                    <tr>
                        <td>{{ user.name }}</td>  
                        <td>{{ user.email }}</td>  
                        <td><a href={{ user.link_empresa}} style="color:#00FF00";>ver empresas</a></td>                    
                        <td><a href={{ user.link_editar}} style="color:#0000FF";>editar</a></td>
                        <td><a href={{ user.link_deletar}} style="color:#FF0000";>excluir</a></td>               
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    </div>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}