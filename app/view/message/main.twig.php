{% extends 'partials/body.twig.php'  %}

{% block title %}Página não encontrada - NEXT{% endblock %}

{% block body %}
<div class="col-md-10 center-screen bg-white padding mt-5">
    <div class="card border-danger mb-3">
        <div class="card-header">{{title}}</div>
        <div class="card-body">
            <p class="card-text">{{message}}</p>
        </div>
    </div>
</div>
{% endblock %}