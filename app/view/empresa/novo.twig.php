{% extends 'partials/body.twig.php'  %}

{% block title %}Novo Empresa - NEXT{% endblock %}

{% block body %}
<div class="col-md-10 center-screen bg-white padding mt-5">
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
                {% for usuario in usuarios %}
                    <option value="{{usuario.id}}">{{usuario.nome}}</option>
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