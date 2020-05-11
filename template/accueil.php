    {% extends "template.php" %}
    {% block content %}
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="index.html">Start Bootstrap</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post.html">Sample Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="content">

            <div id="displayTab">

                <div class="tab" id="gameTab">
                    <img id="game" src="public/img/jeux.png">
                    <a href="">Jeux</a> 
                </div>

                <div class="tab">
                 <a href="" class="homeTitle">Musiques</a> 
             </div>

             <div class="tab">
                 <a href="">Politique</a> 
             </div>
         </div>
     
 </div>
{% endblock %}
{% block footer %}
 <footer>
   
        <div class="footerElmt">
            <p>RS</p>
        </div>
        <div class="footerElmt">
            <p>Compte</p>
            <p><a href="">identification</a></p>
            <p><a href="">inscription</a></p>
            <p><a href=""></a></p>
        </div>
        <div class="footerElmt">
            <p>Blog</p>
            <p><a href="">Jeux</a></p>
            <p><a href="">Musiques</a></p>
            <p><a href="">Politique</a></p>
        </div>
        <div class="footerElmt">
            <p>Assistance</p>
            <p><a href="">question</a></p>
            <p><a href="">condition d'utilisation</a></p>
            <p><a href="">mention légale</a></p>
        </div>
</footer>
<script src="./public/js/homeParallax.js"></script>
{% endblock %}

