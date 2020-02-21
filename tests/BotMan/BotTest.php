<?php

namespace Tests\BotMan;

use Tests\TestCase;

class BotTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->bot->receives('Hi')
            ->assertReply('Hello!');
    }

    public function testUnknownCommand()
    {
        $this->bot
            ->receives('IDontUnderstandThis')            
            ->assertReply("No entiendo que quieres decir, vuelve a intentarlo.");
    }
    public function testGreetings()
    {
        $this->bot
            ->setUser([
                'first_name' => 'Pepe'
            ])
            ->receives('/start')            
            ->assertReply('Hola Pepe, bienvenido al bot de quices!');
    }

    public function testHelp()
    {
        $this->bot
            ->receives('/ayuda')            
            ->assertReply('Los comandos disponibles son:');
    }

    public function testAbout()
    {
        $msj = "Este bot de charla fue desarrollado por:\n".
               "Jorge I. Meza <jimezam@autonoma.edu.co>\n".
               "Durante el curso de Procesos Agiles de Desarrollo de Software.";

        $this->bot
            ->receives('acerca de')            
            ->assertReply($msj);

        $this->bot
            ->receives('acerca')            
            ->assertReply($msj);
    }

    public function testListQuizzes()
    {
        $this->seed();

        // $quizzes = \App\Quiz::orderby('titulo', 'asc')->pluck('titulo')->toArray();
        $data = \App\Quiz::orderby('titulo', 'asc')->select('id', 'titulo')->get();

        $quizzes = [];

        foreach($data as $quiz)
            array_push($quizzes, $quiz->id . "- " . $quiz->titulo);

        $this->bot
            ->receives('listar quizzes')            
            ->assertReplies($quizzes);
    
        $this->bot
            ->receives('listar')            
            ->assertReplies($quizzes);
    }

    public function testMakeQuiz()
    {
        $this->seed();

        $quiz = \App\Quiz::where('titulo', 'Quiz de Ejemplo')->first();

        $this->assertNotNull($quiz);

        $preguntas = $quiz->preguntas;

        dd($preguntas);

        /*
        $this->bot
            ->receives('iniciar quiz '.$quiz->id)            
            ->assertReplies($quizzes);    
        */
    }
}
