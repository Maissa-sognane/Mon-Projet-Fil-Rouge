<?php
namespace App\Tests\controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


class ProfilControllerTest extends WebTestCase
{
    protected function createAuthenticatedClient(string $username, string $password): KernelBrowser
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
               "mail":"admin@gmail.com",
               "password":"passer"
           }'
        );
        $data = json_decode($client->getResponse()->getContent(), true);
        $client->setServerParameter('HTTP_Authorization', \sprintf('Bearer %s', $data['token']));
        $client->setServerParameter('CONTENT_TYPE', 'application/json');

        return $client;
    }

    public function testShowProfil()
    {
        $client = $this->createAuthenticatedClient("admin@gmail.com","passer");
        $client->request('GET', '/api/admin/profils');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCreateProfil(){
        $client = $this->createAuthenticatedClient("admin@gmail.com","passer");
        $client->request(
            'POST',
            '/api/admin/profils',
            [],
            [],
            ['CONTENT_TYPE'=>'application/json'],
            '{
                    "libelle":"medecin",
                    "isdeleted":false
                    }'

        );
        $responseContent = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK,$responseContent->getStatusCode());
    }

  public function testUpdateProfil(){
      $client = $this->createAuthenticatedClient("admin@gmail.com","passer");
      $client->request(
          'PUT',
              '/api/admin/profil/4',
          [],
          [],
          ['CONTENT_TYPE'=>'application/json'],
          '{
                    "libelle":"medecin",
                    "isdeleted":false
                   }'
      );
      $responseContent = $client->getResponse();
      $this->assertEquals(Response::HTTP_OK,$responseContent->getStatusCode());
  }
}