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
use Mindmecn\MarkdownBundle\Entity\Rvmknote;
use Mindmecn\MarkdownBundle\Entity\Mknote;
//use Mindmecn\MarkdownBundle\Entity\Widget\MarkdownDisplayConfig;
use Claroline\CoreBundle\Manager\UserManager;
use Mindmecn\MarkdownBundle\Event\Log\LogEditResourceMknoteEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Claroline\CoreBundle\Entity\Widget\WidgetInstance;
use Claroline\CoreBundle\Entity\User;

/**
 * @DI\Service("claroline.manager.mknote_manager")
 */
class MknoteManager
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
        $rvmknote = new Rvmknote();
	$rvmknote->setContent($content);
	$rvmknote->setHtmlcontent($htmlcontent);
        $rvmknote->setUser($user);
        $mknote = new Mkppt();
        $mknote->setName($title);
        $rvmknote->setMkppt($mknote);
        $this->om->persist($mknote);
        $this->om->persist($rvmknote);
        $this->om->flush();

        return $mknote;
    }

    public function getLastContentRevision(Mknote $mknote)
    {
        $rvmknoteRepo = $this->om->getRepository('MindmecnMarkdownBundle:Rvmknote');

        return $rvmknoteRepo->getLastRevision($mknote)->getContent();
    }

    public function createRevision(Mknote $mknote, $content, $htmlcontent, User $user = null)
    {
      
        $version = $mknote->getVersion() + 1;

        $rvmknote = new Rvmknote();
	$rvmknote->setContent($content);
	$rvmknote->setHtmlcontent($htmlcontent);
        $rvmknote->setUser($user);
        $rvmknote->setMknote($mknote);
        $rvmknote->setVersion($version);
        $mknote->setVersion($version);
        $this->om->persist($rvmknote);
        $this->om->persist($mknote);
        $this->om->flush();
         

        $workspace = $mknote->getResourceNode()->getWorkspace();
        $usersToNotify = $workspace ?
            $this->userManager->getUsersByWorkspaces([$workspace], null, null, false) :
            [];
        $event = new LogEditResourceMknoteEvent($mknote->getResourceNode(), $usersToNotify);
        $this->eventDispatcher->dispatch('log', $event);

        return $rvmknote;
    }

}
