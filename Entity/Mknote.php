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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;

/**
 * @ORM\Table(name="mindmecn_mknote")
 * @ORM\Entity(repositoryClass="Mindmecn\MarkdownBundle\Repository\RvmknoteRepository")
 */
class Mknote extends AbstractResource
{
    const MODE_NORMAL = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $version;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Mindmecn\MarkdownBundle\Entity\Rvmknote",
     *     mappedBy="mknote",
     *     cascade={"persist"}
     * )
     * @ORM\OrderBy({"version" = "DESC"})
     */
    protected $rvmknotes;

    /** @var string */
    protected $mknote;
    
   /**
     * @ORM\Column(name="default_mode", nullable=false, type="integer", options={"default" = 0})
     */
    protected $defaultMode = self::MODE_NORMAL;

    public function __construct()
    {
        $this->version = 1;
        $this->rvmknotes = new ArrayCollection();
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getRvmknotes()
    {
        return $this->rvmknotes;
    }
      
    public function addRvmknote($rvmknote)
    {
        $this->rvmknotes->add($rvmknote);
    }

    public function removeRvmknote($rvmknote)
    {
        $this->rvmknotes->removeElement($rvmknote);
    }
    

    /**
     * Required for the formtype.
     *
     * @param string $mknote
     */
    public function setMknote($mknote)
    {
        $this->mknote = $mknote;
    }

    /**
     * Required for the formtype.
     *
     * @return string
     */
    public function getMknote()
    {
        return $this->mknote;
    }

    /**
     * Get the current content of the Resource.
     *
     * @return string
     */
    public function getContent()
    {
        $content = null;
        if (0 < $this->rvmknotes->count()) {
            $content = $this->rvmknotes->get(0)->getContent();
        }
        
        return $content;
    }
   
    /**
     * Get the current content of the Resource.
     *
     * @return string
     */
      public function getHtmlContent()
    {
       $htmlcontent = null;
       if (0 < $this->rvmknotes->count()) {
           $htmlcontent = $this->rvmknotes->get(0)->getHtmlContent();
        }
 
       if (empty($htmlcontent)){
           $htmlcontent = 'undefine';
       }
  
          return $htmlcontent;
     }
     
    public function getDefaultMode()
    {
        return $this->defaultMode;
    }

    public function setDefaultMode($defaultMode)
    {
        $this->defaultMode = $defaultMode;
    }

}
