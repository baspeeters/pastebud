<?php

namespace App\Tests\Integration\API;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class HashPasswordListenerTest extends KernelTestCase
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var EncoderFactory $encoderFactory */
    private $encoderFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->entityManager = self::bootKernel()->getContainer()->get('doctrine')->getManager();
        $this->encoderFactory = new EncoderFactory([User::class => new BCryptPasswordEncoder(15)]);
    }

    /** @test */
    public function it_encodes_the_password_when_creating_a_user()
    {
        // Given that we have a new user
        $user = new User();

        // And we set the plain password on that user
        $user->setPlainPassword('test123');

        // Then when we persist the user
        $this->entityManager->persist($user);

        // Its password should be bcrypt encoded
        self::assertNotEquals('test123', $user->getPassword());
        self::assertRegExp('/^\$2[ayb]\$.+$/', $user->getPassword());
        self::assertTrue($this->encoderFactory->getEncoder($user)
            ->isPasswordValid($user->getPassword(), 'test123', ''));

        // ... and the plain password should be empty
        self::assertEmpty($user->getPlainPassword());
    }
}
