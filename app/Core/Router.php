<?php

class Router {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        // Look in controllers for first value
        if (isset($url[0]) && file_exists(APPROOT . '/app/Controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        require_once APPROOT . '/app/Controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        } else {
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $url = rtrim($url, '/');
            $url = ltrim($url, '/');
            if (empty($url) || $url === 'index.php') {
                return [];
            }
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
