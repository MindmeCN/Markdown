<?php

namespace Mindmecn\MarkdownBundle\API\Serializer;

use Claroline\AppBundle\API\Serializer\SerializerTrait;
use Mindmecn\MarkdownBundle\Entity\Mklab;
use Mindmecn\MarkdownBundle\Manager\MklabManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @DI\Service("claroline.serializer.resource_mklab")
 * @DI\Tag("claroline.serializer")
 */
class MklabSerializer
{
    use SerializerTrait;

    /** @var MklabManager */
    private $manager;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * MklabSerializer constructor.
     *
     * @DI\InjectParams({
     *     "manager"      = @DI\Inject("claroline.manager.mklab_manager"),
     *     "tokenStorage" = @DI\Inject("security.token_storage")
     * })
     *
     * @param MklabManager           $manager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(MklabManager $manager, TokenStorageInterface $tokenStorage)
    {
        $this->manager = $manager;
	$this->tokenStorage = $tokenStorage;

    }

    public function getSchema()
    {
        return '#/mindme/markdown-bundle/mklabdown.json';
    }

    /**
     * Serializes a Mklab resource entity for the JSON api.
     *
     * @param Mklab $mklab
     */
    public function serialize(Mklab $mklab)
    {
        return [
            'id' => $mklab->getId(),  
             'defaultMode' => $mklab->getDefaultMode(),
	    'content' => $mklab->getContent(),
	    'htmlcontent' => $mklab->getHtmlcontent(),
            'meta' => [
                'version' => $mklab->getVersion(),
            ],
        ];
    }

    /**
     * @param array $data
     * @param Mklab  $mklab
     *
     * @return Mklab
     */
    public function deserialize($data, Mklab $mklab)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $rvmklab = $this->manager->createRevision($mklab, $data['content'],$data['htmlcontent'], $user === 'anon.' ? null : $user);

        return $rvmklab->getMklab();
    }
}
