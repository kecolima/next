{% extends 'partials/body.twig.php'  %}

{% block title %}Novo Usuário - NEXT{% endblock %}

{% block body %}
<div class="col-md-10 center-screen bg-white padding mt-5">
    <h1>Editar Usuário</h1>

    <hr>

    <form action="{{BASE}}update-usuario/{{usuario.id}}" method="post">

        <div class="mt-3">
            <label for="txtNome">Nome do usuário</label>
            <input type="hidden" id="id" name="id" value="{{usuario.id}}"/>
            <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="{{usuario.name}}" required>
        </div>

        <div class="mt-3">
            <label for="txtEmail">email</label>
            <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="{{usuario.email}}" required>
        </div>

        <div class="mt-3">
            <label for="txtSenha">Senha</label>
            <input type="text" id="txtSenha" name="txtSenha" class="form-control" placeholder="*******" required>
        </div>

        <div class="mt-3 text-right">
            <a href="{{BASE}}usuario/" class="btn btn-info btn-sm">Voltar</a>
            <button type="submit" class="btn btn-success btn-sm">Enviar</button>
        </div>

    </form>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}