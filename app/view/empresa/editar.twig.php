{% extends 'partials/body.twig.php'  %}

{% block title %}Nova Empresa - NEXT{% endblock %}

{% block body %}
<div class="col-md-10 center-screen bg-white padding mt-5">
    <h1>Editar Empresa</h1>

    <hr>

    <form action="{{BASE}}update-empresa/{{empresa.id}}" method="post">

        <div class="mt-3">
            <label for="txtNome">Nome do Empresa</label>
            <input type="hidden" id="id" name="id" value="{{empresa.id}}"/>
            <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="{{empresa.nome}}" required>
        </div>
        <div class="mt-3">
            <label for="txtUser">Usuário</label>
            <select class="form-control" id="txtUser" name="txtUser"> 
                <option value="0">Selecione um usuário</option>
                {% for usuario in usuarios %}
                    <option value="{{usuario.id}}">{{usuario.nome}}</option>
                {% endfor %}
            </select>
        </div>
        <div class="mt-3 text-right">
            <a href="{{BASE}}empresa/" class="btn btn-info btn-sm">Voltar</a>
            <button type="submit" class="btn btn-success btn-sm">Enviar</button>
        </div>

    </form>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}