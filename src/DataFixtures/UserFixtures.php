<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        // créer 3 categorie fakées

        for($i=1; $i<=30;$i++){
            $user = new User();
            $user->setUsername($faker->name)
                 ->setAge($faker->dateTime)
                 ->setFamille($faker->firstName)
                 ->setTaille($faker->numberBetween($min = 50, $max = 150))
                 ->setEmail($faker->email)
                 ->setRace($faker->word)
                 ->setEnabled(1)
                 ->setSalt(null)
                 ->setPassword($faker->password)
                 ->setConfirmationToken(null)
                 ->setPasswordRequestedAt(null)
                 ->setRoles(array());




            $manager->persist($user);
            /**
            for($j = 1; $j<= mt_rand(4,6); $j++)
            {
                $article = new Article();

                $content = '<p>'.join($faker->paragraphs(5), '</p><p>');'</p>';

                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreateAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);
                $manager->persist($article);

                for($k=1; $k <= mt_rand(4,10); $k++){
                    $comment = new Comment();
                    $content = '<p>'.join($faker->paragraphs(2), '</p><p>').'</p>';


                    $days = (new \DateTime())->diff($article->getCreateAt())->days;



                    $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween('-'. $days.'days'))
                        ->setArticle($article);
                    $manager->persist($comment);
                }
            }*/

        }



        $manager->flush();
    }
}
