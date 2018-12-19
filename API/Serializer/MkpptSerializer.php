<?php

namespace Mindmecn\MarkdownBundle\API\Serializer;

use Claroline\AppBundle\API\Serializer\SerializerTrait;
use Mindmecn\MarkdownBundle\Entity\Mkppt;
use Mindmecn\MarkdownBundle\Manager\MkpptManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @DI\Service("claroline.serializer.resource_mkppt")
 * @DI\Tag("claroline.serializer")
 */
class MkpptSerializer
{
    use SerializerTrait;

    /** @var MkpptManager */
    private $manager;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * MkpptSerializer constructor.
     *
     * @DI\InjectParams({
     *     "manager"      = @DI\Inject("claroline.manager.mkppt_manager"),
     *     "tokenStorage" = @DI\Inject("security.token_storage")
     * })
     *
     * @param MkpptManager           $manager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(MkpptManager $manager, TokenStorageInterface $tokenStorage)
    {
        $this->manager = $manager;
	$this->tokenStorage = $tokenStorage;

    }

    public function getSchema()
    {
        return '#/mindmecn/markdown-bundle/mkppt.json';
    }

    /**
     * Serializes a Mkppt resource entity for the JSON api.
     *
     * @param Mkppt $mkppt
     */
    public function serialize(Mkppt $mkppt)
    {
        return [
            'id' => $mkppt->getId(),  
             'defaultMode' => $mkppt->getDefaultMode(),
	    'content' => $mkppt->getContent(),
	    'htmlcontent' => $mkppt->getHtmlcontent(),
            'meta' => [
                'version' => $mkppt->getVersion(),
            ],
        ];
    }

    /**
     * @param array $data
     * @param Mkppt  $mkppt
     *
     * @return Mkppt
     */
    public function deserialize($data, Mkppt $mkppt)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $rvmkppt = $this->manager->createRevision($mkppt, $data['content'],$data['htmlcontent'], $user === 'anon.' ? null : $user);

        return $rvmkppt->getMkppt();
    }
}
