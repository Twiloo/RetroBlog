<?php

namespace Routes;

include_once 'routesAPI.php';

set_exception_handler(function ($e) {
  include_once 'views/error.php';
});

require_once 'app/config.php';
if (!CONFIG_LOADED) {
  throw new \Exception("La configuration du site n'a pas été trouvé ou est indisponible.", 503);
}

require_once __DIR__ . '/router.php';
require_once 'src/FrameworkBundle/traits/viewTrait.php';

function get(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\AppBundle\\' . $path_to_include;
  }
  \Framework\Router::get($route, $path_to_include);
}

function post(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\AppBundle\\' . $path_to_include;
  }
  \Framework\Router::post($route, $path_to_include);
}

function put(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\AppBundle\\' . $path_to_include;
  }
  \Framework\Router::put($route, $path_to_include);
}

function patch(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\AppBundle\\' . $path_to_include;
  }
  \Framework\Router::patch($route, $path_to_include);
}

function delete(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\AppBundle\\' . $path_to_include;
  }
  \Framework\Router::delete($route, $path_to_include);
}

function any(string $route, string|callable $path_to_include) : void {
  \Framework\Router::any($route, $path_to_include);
}

require_once 'src/AppBundle/Controllers/indexController.php';

// Static GET
get('/', function () {
  \AppBundle\controllers\indexController::indexAction();
});

require_once 'src/AppBundle/Controllers/articleController.php';

get('/articles', function () {
  \AppBundle\controllers\articleController::articleListAction();
});

get('/articles/top', function () {
  \AppBundle\controllers\articleController::articleListAction('top');
});

get('/articles/recent', function () {
  \AppBundle\controllers\articleController::articleListAction('recent');
});

get('/article/new', function () {
  \AppBundle\controllers\articleController::articleFormAction();
});

post('/article/post', function () {
  \AppBundle\controllers\articleController::articlePostAction();
});

any('/404', 'views/404.php');
