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
use Mindmecn\MarkdownBundle\Entity\Rvmklab;
use Mindmecn\MarkdownBundle\Entity\Mklab;
//use Mindmecn\MarkdownBundle\Entity\Widget\MarkdownDisplayConfig;
use Claroline\CoreBundle\Manager\UserManager;
use Mindmecn\MarkdownBundle\Event\Log\LogEditResourceMklabEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Claroline\CoreBundle\Entity\Widget\WidgetInstance;
use Claroline\CoreBundle\Entity\User;

/**
 * @DI\Service("claroline.manager.mklab_manager")
 */
class MklabManager
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
        $rvmklab = new Rvmklab();
	$rvmklab->setContent($content);
	$rvmklab->setHtmlcontent($htmlcontent);
        $rvmklab->setUser($user);
        $mklab = new Mkppt();
        $mklab->setName($title);
        $rvmklab->setMkppt($mklab);
        $this->om->persist($mklab);
        $this->om->persist($rvmklab);
        $this->om->flush();

        return $mklab;
    }

    public function getLastContentRevision( Mklab $mklab)
    {
        $rvmklabRepo = $this->om->getRepository('MindmecnMarkdownBundle:Revision');

        return $rvmklabRepo->getLastRevision($mklab)->getContent();
    }

    public function createRevision(Mklab $mklab, $content, $htmlcontent, User $user = null)
    {
      
        $version = $mklab->getVersion() + 1;

        $rvmklab = new Rvmklab();
	$rvmklab->setContent($content);
	$rvmklab->setHtmlcontent($htmlcontent);
        $rvmklab->setUser($user);
        $rvmklab->setMarkdown($mklab);
        $rvmklab->setVersion($version);
        $mklab->setVersion($version);
        $this->om->persist($rvmklab);
        $this->om->persist($mklab);
        $this->om->flush();
         

        $workspace = $mklab->getResourceNode()->getWorkspace();
        $usersToNotify = $workspace ?
            $this->userManager->getUsersByWorkspaces([$workspace], null, null, false) :
            [];
        $event = new LogEditResourceMarkdownEvent($mklab->getResourceNode(), $usersToNotify);
        $this->eventDispatcher->dispatch('log', $event);

        return $rvmklab;
    }

   




}
