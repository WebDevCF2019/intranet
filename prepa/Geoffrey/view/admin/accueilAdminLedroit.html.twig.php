{# on étend le template depuis base.html.twig, qui est donc son parent #}
{% extends "template1.html.twig" %}

{# on veut surcharger le title, on utilise le bloc, on récupère le contenu du parent {{ parent() }} et on rajoute notre texte #}
{% block title %}{{ parent() }} | Accueil de l'admin des étudiants{% endblock %}

{% block menuhaut %}
    {% include "admin/menuHautAdmin.html.twig" %}
{% endblock %}

{% block milieu %}
    <!-- Page Content -->
    <main role="main" class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Administration du CF2m</h1>
                <p class="lead">Gestion des droits</p>
            </div>
            <div class="col-lg-6 text-left">
                <h5 class='mb-4'><a href="?adminledroit&addledroit">Ajouter un droit</a></h5>
                {# Faites apparaître tous les stagiaires avec les sections quand ils en ont, avec un lien modifier, et un lien supprimer #}
                {# dump(ledroit) #}
                {% for item in ledroit %}
                    <h4>{{ item.lintitule }} {{ item.ladescription}}<small> <a href='?adminledroit&update={{ item.idledroit }}'>Mettre à jour</a> | <a href='?adminledroit&delete={{ item.idledroit }}'>Supprimer</a> </small></h4>
                    {% if item.lintitule is empty %}
                        <p>Cet utilisateur n'a pas de droits</p>
                    {% else %}
                        <p>{{ item.lintitule }}</p>
                    {% endif %}
                {% else %}
                    <h4 class='mt-3'>Pas encore de droit</h4>
                {% endfor %}
            </div>
        </div>
    </main>

{% endblock %}

{% block bas %}
    {% include "footer.html.twig" %}
{% endblock %}
