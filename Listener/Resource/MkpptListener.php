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
use Mindmecn\MarkdownBundle\Entity\Rvmkppt;
use Mindmecn\MarkdownBundle\Entity\Mkppt;
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
class MkpptListener
{
    /** @var ObjectManager */
    private $om;

    /** @var TwigEngine */
    private $templating;

    /** @var SerializerProvider */
    private $serializer;

    /**
     * MkpptListener constructor.
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
     * Loads a Mkppt resource.
     *
     * @DI\Observe("resource.mkppt.load")
     *
     * @param LoadResourceEvent $event
     */
    public function load(LoadResourceEvent $event)
    {
        $event->setData([
            'mkppt' => $this->serializer->serialize($event->getResource()),
        ]);
        
         $event->stopPropagation();
    }

    /**
     * @DI\Observe("open_mkppt")
     *
     * @param OpenResourceEvent $event
     */
    public function open(OpenResourceEvent $event)
    {
        $mkppt = $event->getResource();
        
        
        $content = $this->templating->render(
            'MindmecnMarkdownBundle:mkppt:index.html.twig',
            [
                'mkppt' => $mkppt,
                '_resource' => $mkppt,
            ]
        );

        $event->setResponse(new Response($content));
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("copy_mkppt")
     *
     * @param CopyResourceEvent $event
     */
    public function copy(CopyResourceEvent $event)
    {
        /** @var Mkppt $resource */
        $resource = $event->getResource();
        $rvmkppts = $resource->getRevisions();
        $copy = new Mkppt();
        $copy->setVersion($resource->getVersion());

        /** @var Revision $rvmkppt */
        foreach ($rvmkppts as $rvmkppt) {
            $rev = new Revision();
            $rev->setVersion($rvmkppt->getVersion());
            $rev->setContent($rvmkppt->getContent());
            $rev->setUser($rvmkppt->getUser());
            $rev->setMkppt($copy);

            $this->om->persist($rev);
        }

        $event->setCopy($copy);
    }

    /**
     * @DI\Observe("delete_mkppt")
     *
     * @param DeleteResourceEvent $event
     */
    public function delete(DeleteResourceEvent $event)
    {
        $event->stopPropagation();
    }
}
