{% extends 'base.html.twig' %}

{% block title %}Réinitialiser votre mot de passe{% endblock %}

{% block body %}
    <h1>Réinitialiser votre mot de passe</h1>

    {{ form_start(resetForm) }}
        {{ form_row(resetForm.plainPassword) }}
        <button class="btn btn-primary">Réinitialiser le mot de passe</button>
    {{ form_end(resetForm) }}
{% endblock %}
