{% extends 'partials/body.twig.php'  %}

{% block title %}Novo User - Mini Framework{% endblock %}

{% block body %}
<div class="max-width center-screen bg-white padding mt-5">
    <h1>Cadastrar User</h1>

    <hr>

    <form action="{{BASE}}insert-user" method="post">

        <div class="mt-3">
            <label for="txtNome">Nome do usuário</label>
            <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="usuário" required>
        </div>

        <div class="mt-3">
            <label for="txtEmail">email</label>
            <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="Email" required>
        </div>

        <div class="mt-3">
            <label for="txtSenha">Senha</label>
            <input type="text" id="txtSenha" name="txtSenha" class="form-control" placeholder="Senha" required>
        </div>

        <div class="mt-3 text-right">
            <button type="submit" class="btn btn-success">Enviar</button>
        </div>

    </form>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}