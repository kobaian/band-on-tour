<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Gig;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures extends Fixture
{

    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function load(ObjectManager $manager): void
    {
        $bigSpliff = new Gig();
        $bigSpliff->setName('AC/DC + guests');
        $bigSpliff->setDate(new \DateTime());
        $bigSpliff->setIsCancelled(false);
        $manager->persist($bigSpliff);

        $goosla = new Gig();
        $goosla->setName('Goosla');
        $goosla->setDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-12 12:54:32'));
        $goosla->setIsCancelled(true);
        $manager->persist($goosla);

        $comment1 = new Comment();
        $comment1->setGig($goosla);
        $comment1->setAuthorId(1);
        $comment1->setText('Great gig!');
        $comment1->setStatus(Comment::STATUS_PUBLISHED);
        $manager->persist($comment1);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->encoderFactory->getEncoder(Admin::class)->encodePassword('admin', null));
        $manager->persist($admin);

        $manager->flush();
    }
}
