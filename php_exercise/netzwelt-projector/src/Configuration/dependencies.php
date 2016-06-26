<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};


//view
$container['view'] = function($container){
	$view = new \Slim\Views\Twig(__DIR__ . '/../../resources/views', [
		'cache' => false, 
	]);

	$view-> addExtension(new \Slim\Views\TwigExtension(

		$container->router,
		$container->request->getUri()

		));

	return $view;
};

$container['validator'] = function ($container)
{
	return new Netzwelt\Validation\Validator;
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['LoginController'] = function($container){
	return new src\Controllers\LoginController($container->view);
};

$container['HomeController'] = function($container){
	return new \src\Controllers\HomeController($container->view);
};

$container['PersonController'] = function($container){
	return new \src\Controllers\PersonController($container->view);
};

$container['ProjectController'] = function($container){
	return new \src\Controllers\ProjectController($container->view);
};

#$container['USER'] = function($container){
#    return new \src\Controllers\UserController($container->view);
#};

