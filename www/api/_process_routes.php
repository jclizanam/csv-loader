<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/app/models/Helpers.php';
$helpers = new Helpers();

function match_router_uri($controller_match)
{

    $controller = new stdClass();
    $controller_pieces = explode('#', $controller_match);
    $controller->class_name = $controller_pieces[0];
    $controller->method_called = $controller_pieces[1];
    $controller->filename = $_SERVER['DOCUMENT_ROOT'] . '/app/controllers/' . $controller->class_name . '.php';

    if (file_exists($controller->filename)) {
        include_once $controller->filename;
        $controller->methods = get_class_methods($controller->class_name);

        if (class_exists($controller->class_name, true) && in_array($controller->method_called, $controller->methods)) {

            $call_class = $controller->class_name;
            $call_method = $controller->method_called;

            $class = new $call_class();
            $class->$call_method();

            unset($controller);
            return true;
        }
    }

    unset($controller);
    return false;
}


// Removing possible parameters in URL
$uri_string = preg_replace("/\?(.*)/", "", $_SERVER['REQUEST_URI']);
// Creating array from URL
$uri_pieces = array_slice(explode("/", $uri_string), 1);

// Removing possible white spaces
if (empty($uri_pieces[(count($uri_pieces) - 1)])) {
    unset($uri_pieces[(count($uri_pieces) - 1)]);
}


// Flag to stop next iteration
$match_found = false;

// Searching URLS without ID parameter
if (count($uri_pieces) > 0) {
    foreach ($routes as $route => $controller_method) {
        if (implode('/', $uri_pieces) == $route) {

            if (match_router_uri($controller_method)) {
                $match_found = true;
                break;
            }
        }
    }


    if (!$match_found) {
        $uri_subtest = $uri_pieces;  // the REQUEST_URI
        unset($uri_subtest[(count($uri_subtest) - 1)]);

        foreach ($routes as $route => $controller_method) {

            // Checking if the Route into the route file have :{id}
            if (preg_match('/\/\:/', $route)) {
                $route_pieces = explode('/', $route);

                // Setting variable with the dynamic ID set in Route file
                $routeIdName = $route_pieces[(count($route_pieces) - 1)];

                //Removing :{id} from route string
                unset($route_pieces[(count($route_pieces) - 1)]);

                if (implode('/', $uri_subtest) == implode('/', $route_pieces)) {

                    $routeIdName = substr($routeIdName, 1);

                    // Assigning ID found in URL request as GET[{dynamic name}] to mock request
                    $_GET[$routeIdName] = $uri_pieces[(count($uri_pieces) - 1)];
                    if (match_router_uri($controller_method)) {
                        $match_found = true;
                        break;
                    }

                    unset($_GET[$routeIdName]);
                }
            } else {
                $helpers->api_response(404, 'Page not found');
            }
        }
    } else {
        $helpers->api_response(404, 'Page not found');
    }
}

?>