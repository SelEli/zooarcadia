<?php

namespace App\Repository;

use App\Document\Comments;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class CommentsRepository extends DocumentRepository
{
    protected $dm; // Mise à jour du niveau d'accès

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        parent::__construct($dm, $dm->getUnitOfWork(), $dm->getClassMetadata(Comments::class));
    }

    public function findAllVisible(): array
    {
        return $this->createQueryBuilder()
            ->field('isVisible')->equals(true)
            ->getQuery()
            ->execute()
            ->toArray();
    }
}
