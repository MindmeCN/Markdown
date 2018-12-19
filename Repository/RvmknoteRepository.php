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
use Mindmecn\MarkdownBundle\Entity\Mknote;

class RvmknoteRepository extends EntityRepository
{
    /**
     * Returns the last revision of a mknote.
     *
     * @param Mknote $mknote
     *
     * @return Rvmknote
     */
    public function getLastRevision(Mknote $mknote)
    {
        $dql = "
            SELECT r FROM Mindmecn\MarkdownBundle\Entity\Rvmknote r
            JOIN r.mknote t2
            WHERE r.version = (SELECT MAX(r2.version) FROM Mindmecn\MarkdownBundle\Entity\Rvmknote r2
            JOIN r2.mknote t WHERE t.id = {$mknote->getId()})
            and t2.id = {$mknote->getId()}
        ";
	    $query = $this->_em->createQuery($dql);


        return $query->getSingleResult();
    }
}
