<?php

namespace Framework;

// Every URI aim at the routes.php file who use this router.php file
// This allows us to have clean URLs without the index.php in the path 
// Example: http://localhost/MVCustom/ instead of http://localhost/MVCustom/index.php
// This also allows us to get params from the URI
// Example: http://localhost/MVCustom/user/1 instead of http://localhost/MVCustom/index.php?user=1
// This also allows us to use the HTTP methods GET, POST, PUT, PATCH, DELETE
// We can also use the function any() to match any HTTP method and unknown URIs
// Example: any('/404', '404.php');

// We can have in the same project a MVC structure for a webapp and a REST API
// For the api we can use the functions get(), post(), put(), patch(), delete()
// Example: get('/api/users', 'api/users.php');

// Any route can call a function or include a file
// Example: any('/users', 'users.php');
// Example: any('/users', function(){ echo 'Hello World'; });

if (!file_exists(SITE_NAME . ".log")) {
  $logfile = fopen(SITE_NAME . ".log", "w");
  fwrite($logfile, 0);
  fclose($logfile);
  include_once 'bddInit.php';
}

$logfile = fopen(SITE_NAME . ".log", "r");
$numberOfConnections = $logfile ? fread($logfile, filesize(SITE_NAME . ".log")) : 0;
$logfile = fopen(SITE_NAME . ".log", "w");
fwrite($logfile, $numberOfConnections + 1);
fclose($logfile);

session_start();

class Router {

  public static function get(string $route, string|callable $path_to_include) : void {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      self::route($route, $path_to_include);
    }
  }

  public static function post(string $route, string|callable $path_to_include) : void {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::route($route, $path_to_include);
    }
  }

  public static function put(string $route, string|callable $path_to_include) : void {
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
      self::route($route, $path_to_include);
    }
  }

  public static function patch(string $route, string|callable $path_to_include) : void {
    if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
      self::route($route, $path_to_include);
    }
  }

  public static function delete(string $route, string|callable $path_to_include) : void {
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
      self::route($route, $path_to_include);
    }
  }

  public static function any(string $route, string|callable $path_to_include) : void {
    self::route($route, $path_to_include);
  }

  private static function route(string $route, string|callable $path_to_include) : void {

    $callback = $path_to_include;
    if (!is_callable($callback)) {
      if (!strpos($path_to_include, '.php')) {
        $path_to_include .= '.php';
      }
    }

    if ($route == "/404") {
      include_once __DIR__ . "/$path_to_include";
      exit();
    }

    $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
    $request_url = rtrim($request_url, '/');
    $request_url = strtok($request_url, '?');
    $route_parts = explode('/', $route);
    $request_url_parts = explode('/', $request_url);
    array_shift($route_parts);
    array_shift($request_url_parts);

    if ($route_parts[0] == '' && count($request_url_parts) == 0) {

      // Callback function
      if (is_callable($callback)) {
        call_user_func_array($callback, []);
        exit();
      }
      include_once __DIR__ . "\\$path_to_include";
      exit();
    }

    if (count($route_parts) != count($request_url_parts)) {
      return;
    }

    $parameters = [];
    for ($i = 0; $i < count($route_parts); $i++) {
      $route_part = $route_parts[$i];
      if (preg_match("/^[$]/", $route_part)) {
        $route_part = ltrim($route_part, '$');
        array_push($parameters, $request_url_parts[$i]);
        $$route_part = $request_url_parts[$i];
      } elseif ($route_parts[$i] != $request_url_parts[$i]) {
        return;
      }
    }

    // Callback function
    if (is_callable($callback)) {
      call_user_func_array($callback, $parameters);
      exit();
    }
    include_once __DIR__ . "/$path_to_include";
    exit();
  }
}
