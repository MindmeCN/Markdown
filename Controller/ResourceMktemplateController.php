<?php

namespace Mindmecn\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;

class ResourceMktemplateController extends Controller
{
    /**
     * @EXT\Route("/index", name="mindmecn_mktemplate_index")
     * @EXT\Template
     *
     * @return Response
     */
    public function indexAction()
    {
        throw new \Exception('hello');
    }
}
