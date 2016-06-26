<?php
// Routes


$app->get('/', 'Netzwelt\Controllers\LoginController:getLogin');
$app->post('/', 'Netzwelt\Controllers\LoginController:postLogin'); //verify
$app->get('/auth/logout', 'Netzwelt\Controllers\LoginController:logout')->setName('logout');


$app->get('/auth/login', 'Netzwelt\Controllers\LoginController:getLogin')->setName('login');
$app->post('/auth/login', 'Netzwelt\Controllers\LoginController:postLogin'); //verify


$app->get('/projects/home', 'Netzwelt\Controllers\ProjectController:projects')->setName('home');


$app->get('/create/person', 'Netzwelt\Controllers\PersonController:getCreateperson')->setName('createperson');
$app->post('/create/person', 'Netzwelt\Controllers\PersonController:postCreateperson');


$app->get('/create/project', 'Netzwelt\Controllers\ProjectController:getproject')->setName('createproject');
$app->post('/create/project', 'Netzwelt\Controllers\ProjectController:postproject');


$app->get('/projects/assign', 'Netzwelt\Controllers\ProjectController:assign_project');
$app->get('/projects/mems', 'Netzwelt\Controllers\ProjectController:mems');


$app->get('/projects/mems/add', 'Netzwelt\Controllers\ProjectController:add_member');
$app->get('/projects/mems/remove', 'Netzwelt\Controllers\ProjectController:remove_member');