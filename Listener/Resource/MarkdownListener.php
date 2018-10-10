<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindmecn\MarkdownBundle\Listener\Resource;

use Claroline\AppBundle\API\SerializerProvider;
use Claroline\AppBundle\Persistence\ObjectManager;
use Mindmecn\MarkdownBundle\Entity\Revision;
use Mindmecn\MarkdownBundle\Entity\Markdown;
use Claroline\CoreBundle\Event\Resource\CopyResourceEvent;
use Claroline\CoreBundle\Event\Resource\DeleteResourceEvent;
use Claroline\CoreBundle\Event\Resource\LoadResourceEvent;
use Claroline\CoreBundle\Event\Resource\OpenResourceEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Response;

/**
 * @DI\Service
 */
class MarkdownListener
{
    /** @var ObjectManager */
    private $om;

    /** @var TwigEngine */
    private $templating;

    /** @var SerializerProvider */
    private $serializer;

    /**
     * MarkdownListener constructor.
     *
     * @DI\InjectParams({
     *     "om"         = @DI\Inject("claroline.persistence.object_manager"),
     *     "templating" = @DI\Inject("templating"),
     *     "serializer" = @DI\Inject("claroline.api.serializer")
     * })
     *
     * @param ObjectManager      $om
     * @param TwigEngine         $templating
     * @param SerializerProvider $serializer
     */
    public function __construct(
        ObjectManager $om,
        TwigEngine $templating,
        SerializerProvider $serializer)
    {
        $this->om = $om;
        $this->templating = $templating;
        $this->serializer = $serializer;
    }

    /**
     * Loads a Markdown resource.
     *
     * @DI\Observe("resource.markdown.load")
     *
     * @param LoadResourceEvent $event
     */
    public function load(LoadResourceEvent $event)
    {
        $event->setData([
            'markdown' => $this->serializer->serialize($event->getResource()),
        ]);
        
         $event->stopPropagation();
    }

    /**
     * @DI\Observe("open_markdown")
     *
     * @param OpenResourceEvent $event
     */
    public function open(OpenResourceEvent $event)
    {
        $markdown = $event->getResource();
        
        
        $content = $this->templating->render(
            'MindmecnMarkdownBundle:markdown:index.html.twig',
            [
                'markdown' => $markdown,
                '_resource' => $markdown,
            ]
        );

        $event->setResponse(new Response($content));
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("copy_markdown")
     *
     * @param CopyResourceEvent $event
     */
    public function copy(CopyResourceEvent $event)
    {
        /** @var Markdown $resource */
        $resource = $event->getResource();
        $revisions = $resource->getRevisions();
        $copy = new Markdown();
        $copy->setVersion($resource->getVersion());

        /** @var Revision $revision */
        foreach ($revisions as $revision) {
            $rev = new Revision();
            $rev->setVersion($revision->getVersion());
            $rev->setContent($revision->getContent());
            $rev->setUser($revision->getUser());
            $rev->setMarkdown($copy);

            $this->om->persist($rev);
        }

        $event->setCopy($copy);
    }

    /**
     * @DI\Observe("delete_markdown")
     *
     * @param DeleteResourceEvent $event
     */
    public function delete(DeleteResourceEvent $event)
    {
        $event->stopPropagation();
    }
}
