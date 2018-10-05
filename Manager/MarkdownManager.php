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
use Mindmecn\MarkdownBundle\Entity\Revision;
use Mindmecn\MarkdownBundle\Entity\Markdown;
//use Mindmecn\MarkdownBundle\Entity\Widget\MarkdownDisplayConfig;
use Claroline\CoreBundle\Manager\UserManager;
use Mindmecn\MarkdownBundle\Event\Log\LogEditResourceMarkdownEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Claroline\CoreBundle\Entity\Widget\WidgetInstance;

/**
 * @DI\Service("claroline.manager.markdown_manager")
 */
class MarkdownManager
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var ObjectManager */
    private $om;

    /** @var UserManager */
    private $userManager;

    ///** @var markdownDisplayConfigRepo */
    //private $markdownDisplayConfigRepo;

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

	//$this->markdownDisplayConfigRepo = $om->getRepository('MindmecnMarkdownBundle:Widget\MarkdownDisplayConfig');
    }

    public function create($content, $htmlcontent, $title, User $user = null)
    {
        $revision = new Revision();
	$revision->setContent($content);
	$revision->setHtmlcontent($htmlcontent);
        $revision->setUser($user);
        $markdown = new Markdown();
        $markdown->setName($title);
        $revision->setMarkdown($Markdown);
        $this->om->persist($Markdown);
        $this->om->persist($revision);
        $this->om->flush();

        return $markdown;
    }

    public function getLastContentRevision(Markdown $markdown)
    {
        $revisionRepo = $this->om->getRepository('MindmecnMarkdownBundle:Revision');

        return $revisionRepo->getLastRevision($markdown)->getContent();
    }

    public function createRevision(Markdown $markdown, $content, $htmlcontent, User $user = null)
    {
        $version = $markdown->getVersion() + 1;

        $revision = new Revision();
	$revision->setContent($content);
	$revision->setHtmlcontent($htmlcontent);
        $revision->setUser($user);
        $revision->setMarkdown($markdown);
        $revision->setVersion($version);
        $markdown->setVersion($version);
        $this->om->persist($revision);
        $this->om->persist($markdown);
        $this->om->flush();

        $workspace = $markdown->getResourceNode()->getWorkspace();
        $usersToNotify = $workspace ?
            $this->userManager->getUsersByWorkspaces([$workspace], null, null, false) :
            [];
        $event = new LogEditResourceMarkdownEvent($Markdown->getResourceNode(), $usersToNotify);
        $this->eventDispatcher->dispatch('log', $event);

        return $revision;
    }

   




}
