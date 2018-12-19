<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindmecn\MarkdownBundle\Manager;

use Claroline\AppBundle\Persistence\ObjectManager;
use Mindmecn\MarkdownBundle\Entity\Rvmkppt;
use Mindmecn\MarkdownBundle\Entity\Mkppt;
//use Mindmecn\MarkdownBundle\Entity\Widget\MarkdownDisplayConfig;
use Claroline\CoreBundle\Manager\UserManager;
use Mindmecn\MarkdownBundle\Event\Log\LogEditResourceMkpptEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Claroline\CoreBundle\Entity\Widget\WidgetInstance;
use Claroline\CoreBundle\Entity\User;

/**
 * @DI\Service("claroline.manager.mkppt_manager")
 */
class MkpptManager
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var ObjectManager */
    private $om;

    /** @var UserManager */
    private $userManager;
    



    /**
     * @DI\InjectParams({
     *     "eventDispatcher" = @DI\Inject("event_dispatcher"),
     *     "om"              = @DI\Inject("claroline.persistence.object_manager"),
     *     "userManager"     = @DI\Inject("claroline.manager.user_manager"),
     *
     * })
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param ObjectManager            $om
     * @param UserManager              $userManager
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $om,
        UserManager $userManager
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->om = $om;
	$this->userManager = $userManager;
   }

    public function create($content, $htmlcontent, $title, User $user = null)
    {
        $rvmkppt = new Rvmkppt();
	$rvmkppt->setContent($content);
	$rvmkppt->setHtmlcontent($htmlcontent);
        $rvmkppt->setUser($user);
        $mkppt = new Mkppt();
        $mkppt->setName($title);
        $rvmkppt->setMkppt($mkppt);
        $this->om->persist($mkppt);
        $this->om->persist($rvmkppt);
        $this->om->flush();

        return $mkppt;
    }

    public function getLastContentRevision(Mkppt $mkppt)
    {
        $rvmkpptRepo = $this->om->getRepository('MindmecnMarkdownBundle:Rvmkppt');

        return $rvmkpptRepo->getLastRevision($mkppt)->getContent();
    }

    public function createRevision(Mkppt $mkppt, $content, $htmlcontent, User $user = null)
    {
      
        $version = $mkppt->getVersion() + 1;

        $rvmkppt = new Rvmkppt();
	$rvmkppt->setContent($content);
	$rvmkppt->setHtmlcontent($htmlcontent);
        $rvmkppt->setUser($user);
        $rvmkppt->setMkppt($mkppt);
        $rvmkppt->setVersion($version);
        $mkppt->setVersion($version);
        $this->om->persist($rvmkppt);
        $this->om->persist($mkppt);
        $this->om->flush();
         
   
  
        $workspace = $mkppt->getResourceNode()->getWorkspace();
        
        $usersToNotify = $workspace ?
            $this->userManager->getUsersByWorkspaces([$workspace], null, null, false) :
            [];
        $event = new LogEditResourceMkpptEvent($mkppt->getResourceNode(), $usersToNotify);
        $this->eventDispatcher->dispatch('log', $event);

        return $rvmkppt;
    }

   
     /**
     * Get mkppt by its ID or UUID.
     *
     * @param int
     *
     * @return Mkppt
     */
    public function getMkpptById($id)
    {   
        
       if (preg_match('/^\d+$/', $id)) {
           
            $node = $this->om->getRepository("ClarolineCoreBundle:Resource\ResourceNode")->findOneBy(['id' => $id]);
        } else{
           
            $node = $this->om->getRepository("ClarolineCoreBundle:Resource\ResourceNode")->findOneBy([
                'uuid' => $id,
            ]);
        }

        $mkppt = $this->om->getRepository("MindmecnMarkdownBundle:Mkppt")->findOneBy(['resourceNode' => $node]);
        
        return $mkppt;
    }

}
