<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagControllerTest extends WebTestCase
{
    public function testCreateTag(): void
    {
        $client = static::createClient();

        // Simule un utilisateur connecté
        $client->loginUser($this->createMockUser());

        // Accède à la page de création de tag
        $crawler = $client->request('GET', '/tag/new');

        // Vérifie que la page de création est accessible
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form'); // Vérifie qu'un formulaire est présent

        // Remplit et soumet le formulaire
        $form = $crawler->selectButton('Créer')->form([
            'tag[name]' => 'Nouveau Tag',
        ]);

        $client->submit($form);

        // Vérifie que la redirection après la création est correcte
        $this->assertResponseRedirects('/tag/new');

        // Suivre la redirection
        $client->followRedirect();

        // Vérifie que le flash message de succès est affiché
        $this->assertSelectorTextContains('.flash-success', 'Tag crée avec succès');
    }

    private function createMockUser()
    {
        // Crée un utilisateur simulé pour les tests
        $user = new \App\Entity\User();
        $user->setEmail('test@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('password'); // Simule un mot de passe
        return $user;
    }
}
