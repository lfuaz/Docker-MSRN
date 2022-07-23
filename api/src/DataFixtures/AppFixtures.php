<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Message;

class AppFixtures extends Fixture
{


    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function load(ObjectManager $manager): void
    {

        for ($i=0; $i < 100 ; $i++) { 
            $message = new Message();
            $message->setBody($this->generateRandomString(100));
            $message->setFromuid($this->generateRandomString());
            $manager->persist($message);
        }
        
        $manager->flush();
        
    }
}
