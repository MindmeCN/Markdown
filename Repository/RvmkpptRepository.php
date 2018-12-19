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
use Mindmecn\MarkdownBundle\Entity\Mkppt;

class RvmkpptRepository extends EntityRepository
{
    /**
     * Returns the last rvmkppt of a mkppt.
     *
     * @param Mkppt $mkppt
     *
     * @return Rvmkppt
     */
    public function getLastRevision(Mkppt $mkppt)
    {
        $dql = "
            SELECT r FROM Mindmecn\MarkdownBundle\Entity\Rvmkppt r
            JOIN r.mkppt t2
            WHERE r.version = (SELECT MAX(r2.version) FROM Mindmecn\MarkdownBundle\Entity\Rvmkppt r2
            JOIN r2.mkppt t WHERE t.id = {$mkppt->getId()})
            and t2.id = {$mkppt->getId()}
        ";
	    $query = $this->_em->createQuery($dql);


        return $query->getSingleResult();
    }
}
