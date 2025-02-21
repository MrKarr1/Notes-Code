<?php

namespace App\Tests\Controller;

use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class NoteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $noteRepository;
    private string $path = '/note/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->noteRepository = $this->manager->getRepository(Note::class);

        foreach ($this->noteRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Note index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'note[name]' => 'Testing',
            'note[code]' => 'Testing',
            'note[description]' => 'Testing',
            'note[img]' => 'Testing',
            'note[created_at]' => 'Testing',
            'note[is_favori]' => 'Testing',
            'note[user]' => 'Testing',
            'note[langage]' => 'Testing',
            'note[tags]' => 'Testing',
            'note[tag]' => 'Testing',
            'note[folders]' => 'Testing',
            'note[folder]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->noteRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Note();
        $fixture->setName('My Title');
        $fixture->setCode('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImg('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setIs_favori('My Title');
        $fixture->setUser('My Title');
        $fixture->setLangage('My Title');
        $fixture->setTags('My Title');
        $fixture->setTag('My Title');
        $fixture->setFolders('My Title');
        $fixture->setFolder('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Note');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Note();
        $fixture->setName('Value');
        $fixture->setCode('Value');
        $fixture->setDescription('Value');
        $fixture->setImg('Value');
        $fixture->setCreated_at('Value');
        $fixture->setIs_favori('Value');
        $fixture->setUser('Value');
        $fixture->setLangage('Value');
        $fixture->setTags('Value');
        $fixture->setTag('Value');
        $fixture->setFolders('Value');
        $fixture->setFolder('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'note[name]' => 'Something New',
            'note[code]' => 'Something New',
            'note[description]' => 'Something New',
            'note[img]' => 'Something New',
            'note[created_at]' => 'Something New',
            'note[is_favori]' => 'Something New',
            'note[user]' => 'Something New',
            'note[langage]' => 'Something New',
            'note[tags]' => 'Something New',
            'note[tag]' => 'Something New',
            'note[folders]' => 'Something New',
            'note[folder]' => 'Something New',
        ]);

        self::assertResponseRedirects('/note/');

        $fixture = $this->noteRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getCode());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getImg());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getIs_favori());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getLangage());
        self::assertSame('Something New', $fixture[0]->getTags());
        self::assertSame('Something New', $fixture[0]->getTag());
        self::assertSame('Something New', $fixture[0]->getFolders());
        self::assertSame('Something New', $fixture[0]->getFolder());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Note();
        $fixture->setName('Value');
        $fixture->setCode('Value');
        $fixture->setDescription('Value');
        $fixture->setImg('Value');
        $fixture->setCreated_at('Value');
        $fixture->setIs_favori('Value');
        $fixture->setUser('Value');
        $fixture->setLangage('Value');
        $fixture->setTags('Value');
        $fixture->setTag('Value');
        $fixture->setFolders('Value');
        $fixture->setFolder('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/note/');
        self::assertSame(0, $this->noteRepository->count([]));
    }
}
