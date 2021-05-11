{% extends 'partials/body.twig.php'  %}

{% block title %}Excluir Empresa - NEXT{% endblock %}

{% block body %}
<div class="col-md-10 center-screen bg-white padding mt-5">
    <h5>Confirmar exclusão da  Empresa {{empresa.nome}}</h5>

    <hr>

    <form action="{{BASE}}delete-empresa/{{empresa.id}}" method="post">

        <div class="mt-3">
            <input type="hidden" id="id" name="id" value="{{empresa.id}}"/>
        </div>        

        <div class="mt-3 text-right">
            <a href="{{BASE}}empresa/" class="btn btn-info btn-sm">Voltar</a>
            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
        </div>

    </form>
    <hr>
    <p>@KecoLima 2021</p>    
</div>
{% endblock %}