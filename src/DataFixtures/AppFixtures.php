<?php

namespace App\DataFixtures;

use App\Entity\Habitats;
use App\Entity\Animals;
use App\Entity\Services;
use App\Entity\Comments;
use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $imagesDir = __DIR__ . '/../../public/img';

        // Fixtures pour Habitats
        for ($i = 1; $i <= 5; $i++) {
            $habitat = new Habitats();
            $habitat->setName($faker->unique()->word);
            $habitat->setDescription($faker->sentence);

            $image = new Images();
            $imagePath = $imagesDir . '/vue-zoo.jpg'; // Utiliser 'vue-zoo.jpg' pour les habitats
            if (file_exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $imageBase64 = base64_encode($imageData);
                $image->setData($imageBase64);
                $image->setImageType('image/jpeg');
                $image->setFilename(basename($imagePath));
                $habitat->setImage($image);
                $manager->persist($image);
            }

            $manager->persist($habitat);
        }

        // Fixtures pour Animals
        for ($i = 1; $i <= 5; $i++) {
            $animal = new Animals();
            $animal->setName($faker->unique()->word);
            $animal->setDescription($faker->sentence);

            $image = new Images();
            $imagePath = $imagesDir . '/safari-train.jpg'; // Utiliser 'safari-train.jpg' pour les animaux
            if (file_exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $imageBase64 = base64_encode($imageData);
                $image->setData($imageBase64);
                $image->setImageType('image/jpeg');
                $image->setFilename(basename($imagePath));
                $animal->setImage($image);
                $manager->persist($image);
            }

            $manager->persist($animal);
        }

        // Fixtures pour Services
        for ($i = 1; $i <= 5; $i++) {
            $service = new Services();
            $service->setName($faker->unique()->word);
            $service->setDescription($faker->sentence);

            $image = new Images();
            $imagePath = $imagesDir . '/safari-train.jpg'; // Utiliser 'safari-train.jpg' pour les services
            if (file_exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $imageBase64 = base64_encode($imageData);
                $image->setData($imageBase64);
                $image->setImageType('image/jpeg');
                $image->setFilename(basename($imagePath));
                $service->setImage($image);
                $manager->persist($image);
            }

            $manager->persist($service);
        }

        // Fixtures pour Comments
        for ($i = 1; $i <= 5; $i++) {
            $comment = new Comments();
            $comment->setName($faker->name);
            $comment->setComment($faker->sentence);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
