<?php

namespace App\Tests\Entity;

use App\Entity\Note;
use App\Entity\User;
use App\Entity\Langage;
use PHPUnit\Framework\TestCase;

class NoteTest extends TestCase
{
    public function testSetAndGetName(): void
    {
        $note = new Note();
        $note->setName('Test Note');
        // difinition du nom de la note

        $this->assertSame('Test Note', $note->getName());
        // Vérifie que le nom est correctement défini
    }

    public function testSetAndGetUser(): void
    {
        $note = new Note();
        $user = new User();
        $note->setUser($user);
        // relation entre la note et l'utilisateur

        $this->assertSame($user, $note->getUser());
        // Vérifie que l'utilisateur est correctement défini
    }

    public function testSetAndGetLangage(): void
    {
        $note = new Note();
        $langage = new Langage();
        $note->setLangage($langage);
        // relation entre la note et le langage

        $this->assertSame($langage, $note->getLangage());
        // Vérifie que le langage est correctement défini
    }
}