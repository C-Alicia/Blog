<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Post;
use App\Entity\User;
use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\ContactFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        /*  for ($i = 0; $i < 10; $i++) {

            $category = new Category;
            $category->setName('Category' . ($i + 1));
                 
            $manager->persist($category);
        }
        $manager->flush(); */
        
        /*   CategoryFactory::createMany(10);
           PostFactory::createMany(10); */

        CategoryFactory::createMany(5);
        ContactFactory::createMany(5);

        UserFactory::createOne();
        
        PostFactory::createMany(10, 
        function(){
            return ['category' => CategoryFactory::random()];
        });
        
      CommentFactory::createMany(5,
        function(){
            return['user'=>UserFactory::random(), 'post' =>PostFactory::random()];
        });





    }
}
