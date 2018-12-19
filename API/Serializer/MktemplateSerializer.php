<?php

namespace Mindmecn\MarkdownBundle\API\Serializer;

use Claroline\AppBundle\API\Serializer\SerializerTrait;
use Mindmecn\MarkdownBundle\Entity\Mktemplate;
use Mindmecn\MarkdownBundle\Manager\MktemplateManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @DI\Service("claroline.serializer.resource_mktemplate")
 * @DI\Tag("claroline.serializer")
 */
class MktemplateSerializer
{
    use SerializerTrait;

    /** @var MktemplateManager */
    private $manager;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * MktemplateSerializer constructor.
     *
     * @DI\InjectParams({
     *     "manager"      = @DI\Inject("claroline.manager.mktemplate_manager"),
     *     "tokenStorage" = @DI\Inject("security.token_storage")
     * })
     *
     * @param MktemplateManager           $manager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(MktemplateManager $manager, TokenStorageInterface $tokenStorage)
    {
        $this->manager = $manager;
	$this->tokenStorage = $tokenStorage;

    }

    public function getSchema()
    {
        return '#/mindmecn/markdown-bundle/mktemplate.json';
    }

    /**
     * Serializes a Mktemplate resource entity for the JSON api.
     *
     * @param Mktemplate $mktemplate
     */
    public function serialize(Mktemplate $mktemplate)
    {
        return [
            'id' => $mktemplate->getId(),  
             'defaultMode' => $mktemplate->getDefaultMode(),
	    'content' => $mktemplate->getContent(),
	    'htmlcontent' => $mktemplate->getHtmlcontent(),
            'meta' => [
                'version' => $mktemplate->getVersion(),
            ],
        ];
    }

    /**
     * @param array $data
     * @param Mktemplate  $mktemplate
     *
     * @return Mktemplate
     */
    public function deserialize($data, Mktemplate $mktemplate)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $rvmktemplate = $this->manager->createRevision($mktemplate, $data['content'],$data['htmlcontent'], $user === 'anon.' ? null : $user);

        return $rvmktemplate->getMktemplate();
    }
}
