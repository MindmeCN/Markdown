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
use Mindmecn\MarkdownBundle\Entity\Rvmktemplate;
use Mindmecn\MarkdownBundle\Entity\Mktemplate;
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
class MktemplateListener
{
    /** @var ObjectManager */
    private $om;

    /** @var TwigEngine */
    private $templating;

    /** @var SerializerProvider */
    private $serializer;

    /**
     * MktemplateListener constructor.
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
     * Loads a Mktemplate resource.
     *
     * @DI\Observe("resource.mktemplate.load")
     *
     * @param LoadResourceEvent $event
     */
    public function load(LoadResourceEvent $event)
    {
        $event->setData([
            'mktemplate' => $this->serializer->serialize($event->getResource()),
        ]);
        
         $event->stopPropagation();
    }

    /**
     * @DI\Observe("open_mktemplate")
     *
     * @param OpenResourceEvent $event
     */
    public function open(OpenResourceEvent $event)
    {
        $mktemplate = $event->getResource();
        
        
        $content = $this->templating->render(
            'MindmecnMarkdownBundle:mktemplate:index.html.twig',
            [
                'mktemplate' => $mktemplate,
                '_resource' => $mktemplate,
            ]
        );

        $event->setResponse(new Response($content));
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("copy_mktemplate")
     *
     * @param CopyResourceEvent $event
     */
    public function copy(CopyResourceEvent $event)
    {
        /** @var Mktemplate $resource */
        $resource = $event->getResource();
        $rvmktemplates = $resource->getRevisions();
        $copy = new Mktemplate();
        $copy->setVersion($resource->getVersion());

        /** @var Revision $rvmktemplate */
        foreach ($rvmktemplates as $rvmktemplate) {
            $rev = new Revision();
            $rev->setVersion($rvmktemplate->getVersion());
            $rev->setContent($rvmktemplate->getContent());
            $rev->setUser($rvmktemplate->getUser());
            $rev->setMktemplate($copy);

            $this->om->persist($rev);
        }

        $event->setCopy($copy);
    }

    /**
     * @DI\Observe("delete_mktemplate")
     *
     * @param DeleteResourceEvent $event
     */
    public function delete(DeleteResourceEvent $event)
    {
        $event->stopPropagation();
    }
}
