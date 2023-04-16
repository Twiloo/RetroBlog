<?php

namespace RoutesAPI;

include_once 'src/FrameworkBundle/entities/exceptionEntity.php';

set_exception_handler(function ($e) {
  $message = $e->getMessage();
  $code = $e->getCode();
  $path = $e->getPath();
  header("Content-Type: application/json");
  echo json_encode(array("code" => $code, "message" => $message, "path" => $path));
});

require_once 'app/config.php';
if (!CONFIG_LOADED) {
    throw new \Exception("La configuration du site n'a pas été trouvé ou est indisponible.", 503);
}

require_once __DIR__ . '/router.php';

function get(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\ApiBundle\\' . $path_to_include;
  }
  \Framework\Router::get('/api' . $route, $path_to_include);
}

function post(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\ApiBundle\\' . $path_to_include;
  }
  \Framework\Router::post('/api' . $route, $path_to_include);       
}

function put(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\ApiBundle\\' . $path_to_include;
  }
  \Framework\Router::put('/api' . $route, $path_to_include);          
}

function patch(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\ApiBundle\\' . $path_to_include;
  }
  \Framework\Router::patch('/api' . $route, $path_to_include);              
}

function delete(string $route, string|callable $path_to_include) : void {
  if (is_string($path_to_include)) {
    $path_to_include = 'src\\ApiBundle\\' . $path_to_include;
  }
  \Framework\Router::delete('/api' . $route, $path_to_include);            
}

get('', 'Controllers/redirectController');

// Static API GET
get('/test', 'Controllers/testController');

// Don't look at this code, it's ugly and it's not optimized at all but it works and I don't care I guess :D
\Framework\Router::any('/api/$path/$path2/$path3/$path4/$path5', function ($path, $path2, $path3, $path4, $path5) {
  throw new \Framework\entities\exceptionEntity("La requête demandée n'a pas été trouvée ou n'est pas disponible", 404, "$path/$path2/$path3/$path4/$path5");
});

\Framework\Router::any('/api/$path/$path2/$path3/$path4', function ($path, $path2, $path3, $path4) {
  throw new \Framework\entities\exceptionEntity("La requête demandée n'a pas été trouvée ou n'est pas disponible", 404, "$path/$path2/$path3/$path4");
});

\Framework\Router::any('/api/$path/$path2/$path3', function ($path, $path2, $path3) {
  throw new \Framework\entities\exceptionEntity("La requête demandée n'a pas été trouvée ou n'est pas disponible", 404, "$path/$path2/$path3");
});

\Framework\Router::any('/api/$path/$path2', function ($path, $path2) {
  throw new \Framework\entities\exceptionEntity("La requête demandée n'a pas été trouvée ou n'est pas disponible", 404, "$path/$path2");
});

\Framework\Router::any('/api/$path', function ($path) {
  throw new \Framework\entities\exceptionEntity("La requête demandée n'a pas été trouvée ou n'est pas disponible", 404, $path);
});
