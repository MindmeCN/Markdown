<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindmecn\MarkdownBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Mindmecn\MarkdownBundle\Entity\Mklab;

class RvmklabRepository extends EntityRepository
{
    /**
     * Returns the last revision of a mklab.
     *
     * @param Mklab $mklab
     *
     * @return Rvmklab
     */
    public function getLastRevision(Mklab $mklab)
    {
        $dql = "
            SELECT r FROM Mindmecn\MklabBundle\Entity\Rvmklab r
            JOIN r.mklab t2
            WHERE r.version = (SELECT MAX(r2.version) FROM Mindmecn\MarkdownBundle\Entity\Rvmklab r2
            JOIN r2.mklab t WHERE t.id = {$mklab->getId()})
            and t2.id = {$mklab->getId()}
        ";
	    $query = $this->_em->createQuery($dql);


        return $query->getSingleResult();
    }
}
