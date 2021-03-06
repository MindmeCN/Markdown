<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindmecn\MarkdownBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;

/**
 * @ORM\Entity(repositoryClass="Mindmecn\MarkdownBundle\Repository\RvmklabRepository")
 * @ORM\Table(name="mindmecn_mklab_rvmklab")
 */
class Rvmklab
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $version;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Mindmecn\MarkdownBundle\Entity\Mklab",
     *     inversedBy="rvmklabs",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $mklab;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;


    /**
     * @ORM\Column(type="text")
     */
     protected $htmlcontent;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Claroline\CoreBundle\Entity\User",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $user;

    public function __construct()
    {
        $this->version = 1;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function setMklab(Mklab $mklab)
    {
        $this->mklab = $mklab;
        $mklab->addRvmklab($this);
    }

    public function getMklab()
    {
        return $this->mklab;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
     public function setHtmlcontent($htmlcontent)
    {
       $this->htmlcontent = $htmlcontent;
    }

    public function getHtmlcontent()
   {
       return $this->htmlcontent;
   }


    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
