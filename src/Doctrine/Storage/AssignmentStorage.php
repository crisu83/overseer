<?php namespace Crisu83\Overseer\Doctrine\Storage;

use Crisu83\Overseer\Entity\Assignment;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AssignmentStorage implements \Crisu83\Overseer\Storage\AssignmentStorage
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $repository;


    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $this->entityManager->getRepository(Assignment::class);
    }


    /**
     * @inheritdoc
     */
    public function saveAssignment(Assignment $assignment)
    {
        $this->entityManager->persist($assignment);
        $this->entityManager->flush($assignment);
    }


    /**
     * @inheritdoc
     */
    public function getAssignment($subjectId)
    {
        return $this->repository->findOneBy(['subjectId' => $subjectId]);
    }


    /**
     * @inheritdoc
     */
    public function clearAssignments()
    {
        $conn = $this->entityManager->getConnection();
        $conn->executeQuery('TRUNCATE `rbac_assignments`');
    }
}
