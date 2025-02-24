<?php

namespace App\Tests\Controller;

use App\Entity\Folder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FolderControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $folderRepository;
    private string $path = '/folder/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->folderRepository = $this->manager->getRepository(Folder::class);

        foreach ($this->folderRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Folder index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'folder[name]' => 'Testing',
            'folder[created_at]' => 'Testing',
            'folder[user]' => 'Testing',
            'folder[note]' => 'Testing',
            'folder[notes]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->folderRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Folder();
        $fixture->setName('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUser('My Title');
        $fixture->setNote('My Title');
        $fixture->setNotes('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Folder');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Folder();
        $fixture->setName('Value');
        $fixture->setCreated_at('Value');
        $fixture->setUser('Value');
        $fixture->setNote('Value');
        $fixture->setNotes('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'folder[name]' => 'Something New',
            'folder[created_at]' => 'Something New',
            'folder[user]' => 'Something New',
            'folder[note]' => 'Something New',
            'folder[notes]' => 'Something New',
        ]);

        self::assertResponseRedirects('/folder/');

        $fixture = $this->folderRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getNote());
        self::assertSame('Something New', $fixture[0]->getNotes());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Folder();
        $fixture->setName('Value');
        $fixture->setCreated_at('Value');
        $fixture->setUser('Value');
        $fixture->setNote('Value');
        $fixture->setNotes('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/folder/');
        self::assertSame(0, $this->folderRepository->count([]));
    }
}
