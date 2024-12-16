<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Créer des users et un admin
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername($faker->unique()->userName)
                ->setEmail($faker->unique()->email)
                ->setPassword($this->passwordHasher->hashPassword($user, "User_password123"))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $users[] = $user;
        };

        $admin = new User();
        $admin->setUsername("admin")
            ->setEmail("admin@example.com")
            ->setPassword($this->passwordHasher->hashPassword($admin, "Admin_password123"))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        // Créer des articles
        $articles = [];
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence(2))
                ->setContent($faker->paragraphs(2, true))
                ->setAuthor($faker->name)
                ->setImage($faker->imageUrl(640, 480))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisYear()));
            $manager->persist($article);
            $articles[] = $article;
        }

        // Créer des commentaires
        for ($i = 0; $i < 15; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->text(200))
                ->setUser($faker->randomElement($users))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisYear()))
                ->setArticle($faker->randomElement($articles));
            $manager->persist($comment);
        }


        $manager->flush();
    }
}
