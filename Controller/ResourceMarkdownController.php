<?php

namespace Mindmecn\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Claroline\CoreBundle\Entity\Resource\ResourceNode;

use Mindmecn\MarkdownBundle\Entity\Markdown;
use Mindmecn\MarkdownBundle\Manager\MarkdownManager;

class ResourceMarkdownController extends Controller
{
    /**
     * @EXT\Route("/index", name="mindmecn_markdown_index")
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
       $markdown = $this->manager->getMarkdownById($id);  
       $user = $this->tokenStorage->getToken()->getUser(); 
       $workspace = $markdown->getResourceNode()->getWorkspace();
        
       if (empty($markdown)) { 
            throw new NotFoundHttpException();
        }
        
 
            $content = $this->renderView(
            'MindmecnMarkdownBundle:mkppt:index_reveal.html.twig', [
            'workspace' => $workspace,
            '_resource' => $resource,
            'mkppt' => $markdown,
            'mode' => $mode]
            );

        return new Response($content);
    }
    
}
