<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindmecn\MarkdownBundle\Controller\API;

use Claroline\AppBundle\Annotations\ApiMeta;
use Claroline\AppBundle\Controller\AbstractCrudController;
use Claroline\CoreBundle\Entity\Resource\ResourceNode;
use Mindmecn\MarkdownBundle\Entity\Markdown;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @ApiMeta(
 *     class="Mindmecn\MarkdownBundle\Entity\Markdown",
 *     ignore={"create", "exist", "list", "copyBulk", "deleteBulk", "schema", "find", "get"}
 * )
 * @EXT\Route("resource_markdown")
 */
class MarkdownController extends AbstractCrudController
{
    /**
     * @EXT\Route(
     *     "/{id}/content",
     *     name="apiv2_resource_markdown_content"
     * )
     *
     * @param ResourceNode $resourceNode
     *
     * @return string
     */
    public function getContentAction(ResourceNode $resourceNode)
    {
        /** @var Markdown $markdown */
         file_put_contents('/tmp/mylogrrrr.log', 111);
        $markdown = $this->om->getRepository($resourceNode->getClass())->findOneBy([
            'resourceNode' => $resourceNode,
        ]);

        if (empty($markdown)) {
            throw new NotFoundHttpException();
        }

        return new Response(
            $markdown->getContent()
        );
    }

    public function getName()
    {
        return 'resource_markdown';
    }
}
