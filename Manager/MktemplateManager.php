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
use Mindmecn\MarkdownBundle\Entity\Rvmktemplate;
use Mindmecn\MarkdownBundle\Entity\Mktemplate;
//use Mindmecn\MarkdownBundle\Entity\Widget\MarkdownDisplayConfig;
use Claroline\CoreBundle\Manager\UserManager;
use Mindmecn\MarkdownBundle\Event\Log\LogEditResourceMktemplateEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Claroline\CoreBundle\Entity\Widget\WidgetInstance;
use Claroline\CoreBundle\Entity\User;

/**
 * @DI\Service("claroline.manager.mktemplate_manager")
 */
class MktemplateManager
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
        $rvmktemplate = new Rvmktemplate();
	$rvmktemplate->setContent($content);
	$rvmktemplate->setHtmlcontent($htmlcontent);
        $rvmktemplate->setUser($user);
        $mktemplate = new Mktemplate();
        $mktemplate->setName($title);
        $rvmktemplate->setMktemplate($mktemplate);
        $this->om->persist($mktemplate);
        $this->om->persist($rvmktemplate);
        $this->om->flush();

        return $mktemplate;
    }

    public function getLastContentRevision(Mktemplate $mktemplate)
    {
        $rvmktemplateRepo = $this->om->getRepository('MindmecnMarkdownBundle:Rvmktemplate');

        return $rvmktemplateRepo->getLastRevision($mktemplate)->getContent();
    }

    public function createRevision(Mktemplate $mktemplate, $content, $htmlcontent, User $user = null)
    {
      
        $version = $mktemplate->getVersion() + 1;

        $rvmktemplate = new Rvmktemplate();
	$rvmktemplate->setContent($content);
	$rvmktemplate->setHtmlcontent($htmlcontent);
        $rvmktemplate->setUser($user);
        $rvmktemplate->setMktemplate($mktemplate);
        $rvmktemplate->setVersion($version);
        $mktemplate->setVersion($version);
        $this->om->persist($rvmktemplate);
        $this->om->persist($mktemplate);
        $this->om->flush();
         

        $workspace = $mktemplate->getResourceNode()->getWorkspace();
        $usersToNotify = $workspace ?
            $this->userManager->getUsersByWorkspaces([$workspace], null, null, false) :
            [];
        $event = new LogEditResourceMktemplateEventEvent($mktemplate->getResourceNode(), $usersToNotify);
        $this->eventDispatcher->dispatch('log', $event);

        return $rvmktemplate;
    }

   




}
