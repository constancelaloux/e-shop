<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\User;

class AppFixtures extends Fixture
{
    protected $slugger;
    protected $passwordHasher;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $passwordHasher)
    {
        $this->slugger = $slugger;
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new  \Bluemmb\Faker\PicsumPhotosProvider($faker));

        $admin = new User;

        $plaintextPassword = "password";

        $hashedPassword = $this->passwordHasher->hashPassword($admin, $plaintextPassword);

        $admin->setEmail("admin@gmail.com")
              ->setPassword($hashedPassword)
              ->setFullName("Admin")
              ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for($u = 0; $u < 5; $u++)
        {
            $user = new User();

            $plaintextPassword = "password";

            $hashedPassword = $this->passwordHasher->hashPassword($admin, $plaintextPassword);
            
            $user->setEmail("user$u@gmail.com")
                 ->setFullName($faker->name())
                 ->setPassword($hashedPassword);

            $manager->persist($user);
        }

        for($c = 0; $c < 3; $c++)
        {
            $category = new Category;
            $category->setName($faker->department())
                    ->setSlug(strtolower($this->slugger->slug($category->getName())));
            $manager->persist($category);

            for($p = 0; $p < mt_rand(15, 20); $p++)
            {
                $product = new Product;
                $product->setName($faker->productName())
                        ->setPrice($faker->price(4000, 20000))
                        ->setSlug(strtolower($this->slugger->slug($product->getName())))
                        ->setCategory($category)
                        ->setShortDescription($faker->paragraph())
                        ->setMainPicture($faker->imageUrl(400, 400, true));
                        $manager->persist($product);
            }    
        }

        $manager->flush();
    }
}
