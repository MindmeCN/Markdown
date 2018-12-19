<?php

namespace Mindmecn\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Claroline\CoreBundle\Entity\Resource\ResourceNode;

use Mindmecn\MarkdownBundle\Entity\Mklab;
use Mindmecn\MarkdownBundle\Manager\MklabManager;

class ResourceMklabController extends Controller
{
    private $manager;
    
    /** @var TokenStorageInterface */
    private $tokenStorage;


    /**
     * @DI\InjectParams({
     *     "manager" = @DI\Inject("claroline.manager.mklab_manager"),
     *     "tokenStorage" = @DI\Inject("security.token_storage")
     * })
     *
     * @param MklabManager $manager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        MklabManager $manager,
        TokenStorageInterface $tokenStorage
    ) {
        $this->manager = $manager;
        $this->tokenStorage = $tokenStorage;
    }  
    /**
     * @EXT\Route("/index", name="mindmecn_mklab_index")
     * @EXT\Template
     *
     * @return Response
     */
    public function indexAction()
    {
        throw new \Exception('hello');
    }
    
    /**
     * @EXT\Route("/slide/{id}/{mode}", name="mindmecn_mklab_slide")
     *
     * @return Response
     */
      public function slideAction(Request $request,$id,$mode)
    {    
       $mklab = $this->manager->getMklabById($id);  
       $user = $this->tokenStorage->getToken()->getUser(); 
       $workspace = $mklab->getResourceNode()->getWorkspace();
        
       if (empty($mklab)) { 
            throw new NotFoundHttpException();
        }
        

            $content = $this->renderView(
            'MindmecnMarkdownBundle:mkppt:index_reveal.html.twig', [
            'workspace' => $workspace,
            //'_resource' => $resource,
            'mkppt' => $mklab,
            'mode' => $mode]
            );
        

        return new Response($content);
    }
}
