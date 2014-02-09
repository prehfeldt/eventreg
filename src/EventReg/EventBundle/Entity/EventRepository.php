<?php

namespace EventReg\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository {

    public function findAllOrderedByDate() {
        return $this->getEntityManager()
            ->createQuery('SELECT e FROM EventBundle:Event e ORDER BY e.dateTime ASC')
            ->getResult();
    }
}
