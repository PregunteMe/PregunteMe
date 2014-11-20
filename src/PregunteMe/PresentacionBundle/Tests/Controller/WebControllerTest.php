<?php

namespace PregunteMe\PresentacionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testInscripcion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/inscripcion');
    }

    public function testEvaluacion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/evaluacion');
    }

    public function testResultados()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/resultados');
    }

}
