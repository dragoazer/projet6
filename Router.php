class Router {

    private $url; // Contiendra l'URL sur laquelle on souhaite se rendre
    private $routes = []; // Contiendra la liste des routes

    public function __construct($url){
        $this->url = $url;
    }

	public function get($path, $callable){
	    $route = new Route($path, $callable);
	    $this->routes["GET"][] = $route;
	    return $route; // On retourne la route pour "enchainer" les méthodes
	}
}