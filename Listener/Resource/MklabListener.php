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
use Mindmecn\MarkdownBundle\Entity\Rvmklab;
use Mindmecn\MarkdownBundle\Entity\Mklab;
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
class MklabListener
{
    /** @var ObjectManager */
    private $om;

    /** @var TwigEngine */
    private $templating;

    /** @var SerializerProvider */
    private $serializer;

    /**
     * MklabListener constructor.
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
     * Loads a Mklab resource.
     *
     * @DI\Observe("resource.mklab.load")
     *
     * @param LoadResourceEvent $event
     */
    public function load(LoadResourceEvent $event)
    {
        $event->setData([
            'mklab' => $this->serializer->serialize($event->getResource()),
        ]);
        
         $event->stopPropagation();
    }

    /**
     * @DI\Observe("open_mklab")
     *
     * @param OpenResourceEvent $event
     */
    public function open(OpenResourceEvent $event)
    {
        $mklab = $event->getResource();
        
        
        $content = $this->templating->render(
            'MindmecnMarkdownBundle:mklab:index.html.twig',
            [
                'mklab' => $mklab,
                '_resource' => $mklab,
            ]
        );

        $event->setResponse(new Response($content));
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("copy_mklab")
     *
     * @param CopyResourceEvent $event
     */
    public function copy(CopyResourceEvent $event)
    {
        /** @var Mklab $resource */
        $resource = $event->getResource();
        $rvmklabs = $resource->getRevisions();
        $copy = new Mklab();
        $copy->setVersion($resource->getVersion());

        /** @var Revision $rvmklab */
        foreach ($rvmklabs as $rvmklab) {
            $rev = new Revision();
            $rev->setVersion($rvmklab->getVersion());
            $rev->setContent($rvmklab->getContent());
            $rev->setUser($rvmklab->getUser());
            $rev->setMklab($copy);

            $this->om->persist($rev);
        }

        $event->setCopy($copy);
    }

    /**
     * @DI\Observe("delete_mklab")
     *
     * @param DeleteResourceEvent $event
     */
    public function delete(DeleteResourceEvent $event)
    {
        $event->stopPropagation();
    }
}
