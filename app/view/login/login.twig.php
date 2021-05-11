{% extends 'partials/login.twig.php'  %}

{% block title %}Login - NEXT{% endblock %}

{% block body %}
<div class="col-md-6 center-screen bg-white padding mt-5">
    <h1>Login</h1>

    <hr>

    <form action="{{BASE}}login-usuario" method="post">        
        <div class="">

            <div class="mt-3">
                <label for="txtEmail">Email</label>
                <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="Email" required>
            </div>

            <div class="mt-3">
                <label for="txtSenha">Senha</label>
                <input type="text" id="txtSenha" name="txtSenha" class="form-control" placeholder="Senha" required>
            </div>

            <div class="mt-3 text-right">
                {#           
                <button class="btn btn-warning" type="button">
                    <a style="text-decoration:none" href="{{BASE}}home">Cadastrar</a>
                </button>
                #}
                <button type="submit" class="btn btn-success">Logar</button>
            </div>
        </div>
    </form>
    
    <hr>
    <h6>Para acessar o sistema.</h6>
    <b>Email:</b> admin@admin.com</br>
    <b>Senha:</b> admin</br>
    <hr>
    <p>@KecoLima 2021</p>
</div>
{% endblock %}