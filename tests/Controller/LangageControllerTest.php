<?php

namespace App\Tests\Controller;

use App\Entity\Langage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LangageControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $langageRepository;
    private string $path = '/langage/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->langageRepository = $this->manager->getRepository(Langage::class);

        foreach ($this->langageRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Langage index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'langage[display_name]' => 'Testing',
            'langage[technical_name]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->langageRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Langage();
        $fixture->setDisplay_name('My Title');
        $fixture->setTechnical_name('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Langage');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Langage();
        $fixture->setDisplay_name('Value');
        $fixture->setTechnical_name('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'langage[display_name]' => 'Something New',
            'langage[technical_name]' => 'Something New',
        ]);

        self::assertResponseRedirects('/langage/');

        $fixture = $this->langageRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDisplay_name());
        self::assertSame('Something New', $fixture[0]->getTechnical_name());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Langage();
        $fixture->setDisplay_name('Value');
        $fixture->setTechnical_name('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/langage/');
        self::assertSame(0, $this->langageRepository->count([]));
    }
}
