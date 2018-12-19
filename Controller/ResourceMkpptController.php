<?php

namespace Mindmecn\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Claroline\CoreBundle\Entity\Resource\ResourceNode;

use Mindmecn\MarkdownBundle\Entity\Mkppt;
use Mindmecn\MarkdownBundle\Manager\MkpptManager;

class ResourceMkpptController extends Controller
{
    private $manager;
    
    /** @var TokenStorageInterface */
    private $tokenStorage;


    /**
     * @DI\InjectParams({
     *     "manager" = @DI\Inject("claroline.manager.mkppt_manager"),
     *     "tokenStorage" = @DI\Inject("security.token_storage")
     * })
     *
     * @param MkpptManager $manager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        MkpptManager $manager,
        TokenStorageInterface $tokenStorage
    ) {
        $this->manager = $manager;
        $this->tokenStorage = $tokenStorage;
    }  
    /**
     * @EXT\Route("/index", name="mindmecn_mkppt_index")
     * @EXT\Template
     *
     * @return Response
     */
    public function indexAction()
    {
        throw new \Exception('hello');
    }
    
      /**
     * @EXT\Route("/slide/{id}/{mode}", name="mindmecn_mkppt_slide")
     *
     * @return Response
     */
      public function slideAction(Request $request,$id,$mode)
    {    
       $mkppt = $this->manager->getMkpptById($id);  
       $user = $this->tokenStorage->getToken()->getUser(); 
       $workspace = $mkppt->getResourceNode()->getWorkspace();
        
       if (empty($mkppt)) { 
            throw new NotFoundHttpException();
        }
        

            $content = $this->renderView(
            'MindmecnMarkdownBundle:mkppt:index_reveal.html.twig', [
            'workspace' => $workspace,
            'mkppt' => $mkppt,
            'mode' => $mode]
            );

        return new Response($content);
    }
}
