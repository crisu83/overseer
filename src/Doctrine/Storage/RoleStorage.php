<?php namespace Crisu83\Overseer\Doctrine\Storage;

use Crisu83\Overseer\Entity\Role;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class RoleStorage implements \Crisu83\Overseer\Storage\RoleStorage
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
        $this->repository    = $this->entityManager->getRepository(Role::class);
    }

    /**
     * @inheritdoc
     */
    public function saveRole(Role $role)
    {
        $this->entityManager->persist($role);
        $this->entityManager->flush($role);
    }

    /**
     * @inheritdoc
     */
    public function getRole($name)
    {
        return $this->repository->findOneBy(['name' => $name]);
    }

    /**
     * @inheritdoc
     */
    public function clearRoles()
    {
        $conn = $this->entityManager->getConnection();
        $conn->executeQuery('TRUNCATE `rbac_roles`');
    }
}
