<?php

namespace App\Controller;

use App\Document\HelloDocument;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index(DocumentManager $dm): Response
    {
        // Créer et sauvegarder un document HelloDocument
        $helloDocument = new HelloDocument();
        $dm->persist($helloDocument);
        $dm->flush();

        // Récupérer le message à partir du document
        $message = $helloDocument->getMessage();

        return new Response($message);
    }
}
