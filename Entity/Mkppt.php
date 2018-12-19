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
 * @ORM\Table(name="mindmecn_mkppt")
 * @ORM\Entity(repositoryClass="Mindmecn\MarkdownBundle\Repository\RvmkpptRepository")
 */
class Mkppt extends AbstractResource
{
    const MODE_NORMAL = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $version;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Mindmecn\MarkdownBundle\Entity\Rvmkppt",
     *     mappedBy="mkppt",
     *     cascade={"persist"}
     * )
     * @ORM\OrderBy({"version" = "DESC"})
     */
    protected $rvmkppts;

    /** @var string */
    protected $mkppt;
    
   /**
     * @ORM\Column(name="default_mode", nullable=false, type="integer", options={"default" = 0})
     */
    protected $defaultMode = self::MODE_NORMAL;

    public function __construct()
    {
        $this->version = 1;
        $this->rvmkppts = new ArrayCollection();
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getRvmkppts()
    {
        return $this->rvmkppts;
    }
      
    public function addRvmkppt($rvmkppt)
    {
        $this->rvmkppts->add($rvmkppt);
    }

    public function removeRvmkppt($rvmkppt)
    {
        $this->rvmkppts->removeElement($rvmkppt);
    }
    

    /**
     * Required for the formtype.
     *
     * @param string $mklab
     */
    public function setMkppt($mkppt)
    {
        $this->mkppt = $mkppt;
    }

    /**
     * Required for the formtype.
     *
     * @return string
     */
    public function getMkppt()
    {
        return $this->mkppt;
    }

    /**
     * Get the current content of the Resource.
     *
     * @return string
     */
    public function getContent()
    {
        $content = null;
        if (0 < $this->rvmkppts->count()) {
            $content = $this->rvmkppts->get(0)->getContent();
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
       if (0 < $this->rvmkppts->count()) {
           $htmlcontent = $this->rvmkppts->get(0)->getHtmlContent();
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
