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
 * @ORM\Table(name="mindmecn_mklab")
 * @ORM\Entity(repositoryClass="Mindmecn\MarkdownBundle\Repository\RvmklabRepository")
 */
class Mklab extends AbstractResource
{
    const MODE_NORMAL = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $version;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Mindmecn\MarkdownBundle\Entity\Rvmklab",
     *     mappedBy="mklab",
     *     cascade={"persist"}
     * )
     * @ORM\OrderBy({"version" = "DESC"})
     */
    protected $rvmklabs;

    /** @var string */
    protected $mklab;
    
   /**
     * @ORM\Column(name="default_mode", nullable=false, type="integer", options={"default" = 0})
     */
    protected $defaultMode = self::MODE_NORMAL;

    public function __construct()
    {
        $this->version = 1;
        $this->rvmklabs = new ArrayCollection();
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getRvmklabs()
    {
        return $this->rvmklabs;
    }
      
    public function addRvmklab($rvmklab)
    {
        $this->rvmklabs->add($rvmklab);
    }

    public function removeRvmklab($rvmklab)
    {
        $this->rvmklabs->removeElement($rvmklab);
    }
    

    /**
     * Required for the formtype.
     *
     * @param string $mklab
     */
    public function setMklab($mklab)
    {
        $this->mklab = $mklab;
    }

    /**
     * Required for the formtype.
     *
     * @return string
     */
    public function getMklab()
    {
        return $this->mklab;
    }

    /**
     * Get the current content of the Resource.
     *
     * @return string
     */
    public function getContent()
    {
        $content = null;
        if (0 < $this->rvmklabs->count()) {
            $content = $this->rvmklabs->get(0)->getContent();
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
       if (0 < $this->rvmklabs->count()) {
           $htmlcontent = $this->rvmklabs->get(0)->getHtmlContent();
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
