{% extends 'partials/body.twig.php'  %}

{% block title %}Novo Usuário - Mini Framework{% endblock %}

{% block body %}
<div class="max-width center-screen bg-white padding mt-5">
    <h5>Confirmar exclusão do  Usuário {{user.name}}</h5>

    <hr>

    <form action="{{BASE}}delete-user/{{user.id}}" method="post">

        <div class="mt-3">
            <input type="hidden" id="id" name="id" value="{{user.id}}"/>
        </div>        

        <div class="mt-3 text-right">
            <a href="{{BASE}}user/" class="btn btn-info btn-sm">Voltar</a>
            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
        </div>

    </form>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}