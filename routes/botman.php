<?php
use App\Http\Controllers\BotManController;

use App\Conversations\SaludoEdad;

$botman = resolve('botman');

///////////////////////////////////////////////

$botman->hears('/start', function ($bot) {
    $nombres = $bot->getUser()->getFirstName() ?: "desconocido";
    $bot->reply('Hola ' . $nombres . ', bienvenido al bot de quices!');
});

$botman->hears('/ayuda', function ($bot) {
    $ayuda = ['/ayuda' => 'Mostrar este mensaje de ayuda',
              'acerca de|acerca' => 'Ver la información quien desarrollo este lindo bot',
              'listar quizzes|listar' => 'Listar los cuestionarios disponibles',
              'iniciar quiz <id>' => 'Iniciar la solución de un cuestionario',
              'ver puntajes|puntajes' => 'Ver los últimos puntajes',
              'borrar mis datos|borrar' => 'Borrar mis datos del sistema'];
    
    $bot->reply("Los comandos disponibles son:");

    foreach($ayuda as $key=>$value)
    {
            $bot->reply($key . ": " . $value);
    }
});

$botman->hears('acerca de|acerca', function ($bot) {
    $msj = "Este bot de charla fue desarrollado por:\n".
            "Jorge I. Meza <jimezam@autonoma.edu.co>\n".
            "Durante el curso de Procesos Agiles de Desarrollo de Software.";

    $bot->reply($msj);
});






$botman->fallback(function ($bot) {
    $bot->reply("No entiendo que quieres decir, vuelve a intentarlo.");
});
