<?php

namespace PregunteMe\AdministracionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContenidosControllerTest extends WebTestCase
{
    public function testCargararchivo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/contenidos/cargar');
    }

    public function testDescargararchivo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/contenidos/descargar');
    }

}
