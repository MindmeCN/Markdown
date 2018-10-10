<?php

namespace Mindmecn\MarkdownBundle\API\Serializer;

use Claroline\AppBundle\API\Serializer\SerializerTrait;
use Mindmecn\MarkdownBundle\Entity\Mknote;
use Mindmecn\MarkdownBundle\Manager\MknoteManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @DI\Service("claroline.serializer.resource_mknote")
 * @DI\Tag("claroline.serializer")
 */
class MknoteSerializer
{
    use SerializerTrait;

    /** @var MknoteManager */
    private $manager;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * MknoteSerializer constructor.
     *
     * @DI\InjectParams({
     *     "manager"      = @DI\Inject("claroline.manager.mknote_manager"),
     *     "tokenStorage" = @DI\Inject("security.token_storage")
     * })
     *
     * @param MknoteManager           $manager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(MknoteManager $manager, TokenStorageInterface $tokenStorage)
    {
        $this->manager = $manager;
	$this->tokenStorage = $tokenStorage;

    }

    public function getSchema()
    {
        return '#/mindme/markdown-bundle/mknotedown.json';
    }

    /**
     * Serializes a Mknote resource entity for the JSON api.
     *
     * @param Mknote $mknote
     */
    public function serialize(Mknote $mknote)
    {
        return [
            'id' => $mknote->getId(),  
             'defaultMode' => $mknote->getDefaultMode(),
	    'content' => $mknote->getContent(),
	    'htmlcontent' => $mknote->getHtmlcontent(),
            'meta' => [
                'version' => $mknote->getVersion(),
            ],
        ];
    }

    /**
     * @param array $data
     * @param Mknote  $mknote
     *
     * @return Mknote
     */
    public function deserialize($data, Mknote $mknote)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $rvmknote = $this->manager->createRevision($mknote, $data['content'],$data['htmlcontent'], $user === 'anon.' ? null : $user);

        return $rvmknote->getMknote();
    }
}
