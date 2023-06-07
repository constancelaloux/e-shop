<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ObjectManager;
class RegistrationController extends AbstractController
{
    public function index(UserPasswordHasherInterface $passwordHasher, ObjectManager $manager)
    {
        // ... e.g. get the user data from a registration form
        $user = new User();
        $plaintextPassword = 'password';

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);
    }
}