
<!DOCTYPE html>
<html lang="fr">
    <head>
        {% block head %}
            <link rel="icon" type="image/png" href="./public/img/actu_1.0.png" />

            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            <meta name="viewport" content="initial-scale=1, width=device-width">
            <!-- CSS -->
            <link href="{{ css }}" rel="stylesheet"/>

            <title>{{ title }}</title>
            <script src="https://kit.fontawesome.com/aa2b6f73d5.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

            <!-- Bootstrap core CSS -->
            <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

            <!-- Custom fonts for this template -->
            <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
            <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

            <!-- Custom styles for this template -->
            <link href="public/css/clean-blog.min.css" rel="stylesheet">
        {% endblock %} 
    </head>
    <body>
        {% block content %}{% endblock %}
        {% block footer %}{% endblock %}
    </body>
</html>

