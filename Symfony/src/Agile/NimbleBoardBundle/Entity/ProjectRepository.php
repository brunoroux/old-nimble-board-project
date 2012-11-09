<?php

namespace Agile\NimbleBoardBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
  public function findOneByIdJoinedToStories($id)
  {
    $query = $this->getEntityManager()->createQuery('
      select p, s from NimbleBoardBundle:Project p
      join p.stories s
      where p.id = :id
    ')->setParameter('id', $id);
    try {
      return $query->getSingleResult();
    } catch (\Doctrine\ORM\NoResultException $e) {
      return null;
    }
  }
}