{% extends 'partials/body.twig.php'  %}

{% block title %}Novo Usuário - Mini Framework{% endblock %}

{% block body %}
<div class="max-width center-screen bg-white padding mt-5">
    <h1>Editar Usuário</h1>

    <hr>

    <form action="{{BASE}}update-user/{{user.id}}" method="post">

        <div class="mt-3">
            <label for="txtNome">Nome do usuário</label>
            <input type="hidden" id="id" name="id" value="{{user.id}}"/>
            <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="{{user.name}}" required>
        </div>

        <div class="mt-3">
            <label for="txtEmail">email</label>
            <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="{{user.email}}" required>
        </div>

        <div class="mt-3">
            <label for="txtSenha">Senha</label>
            <input type="text" id="txtSenha" name="txtSenha" class="form-control" placeholder="*******" required>
        </div>

        <div class="mt-3 text-right">
            <a href="{{BASE}}user/" class="btn btn-info btn-sm">Voltar</a>
            <button type="submit" class="btn btn-success btn-sm">Enviar</button>
        </div>

    </form>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}