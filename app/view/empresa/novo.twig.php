{% extends 'partials/body.twig.php'  %}

{% block title %}Novo User - Mini Framework{% endblock %}

{% block body %}
<div class="max-width center-screen bg-white padding mt-5">
    <h1>Cadastrar Empresa</h1>

    <hr>

    <form action="{{BASE}}insert-empresa" method="post">

        <div class="mt-3">
            <label for="txtNome">Nome da empresa</label>
            <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="empresa" required>
        </div>
        <div class="mt-3">
            <label for="txtUser">Usuário</label>
            <select class="form-control" id="txtUser" name="txtUser"> 
                <option value="0">Selecione um usuário</option>
                {% for user in users %}
                    <option value="{{user.id}}">{{user.name}}</option>
                {% endfor %}
            </select>
        </div>
        <div class="mt-3 text-right">
            <button type="submit" class="btn btn-success">Enviar</button>
        </div>

    </form>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}