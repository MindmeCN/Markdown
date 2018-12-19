<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindmecn\MktemplateBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Mindmecn\MarkdownBundle\Entity\Mktemplate;

class RvmktemplateRepository extends EntityRepository
{
    /**
     * Returns the last revision of a mktemplate.
     *
     * @param Mktemplate $
     *
     * @return Rvtemplate
     */
    public function getLastRevision(Mktemplate $mktemplate)
    {
        $dql = "
            SELECT r FROM Mindmecn\MktemplateBundle\Entity\Rvmktemplate r
            JOIN r.mktemplate t2
            WHERE r.version = (SELECT MAX(r2.version) FROM Mindmecn\MarkdownBundle\Entity\Rvmktemplate r2
            JOIN r2.mktemplate t WHERE t.id = {$mktemplate->getId()})
            and t2.id = {$mktemplate->getId()}
        ";
	    $query = $this->_em->createQuery($dql);


        return $query->getSingleResult();
    }
}
