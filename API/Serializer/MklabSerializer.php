<?php

namespace Mindmecn\MarkdownBundle\API\Serializer;

use Claroline\AppBundle\API\Serializer\SerializerTrait;
use Mindmecn\MarkdownBundle\Entity\Mklab;
use Mindmecn\MarkdownBundle\Manager\MklabManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Yaml\Yaml;
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
        return '#/mindmecn/markdown-bundle/mklab.json';
    }

    /**
     * Serializes a Mklab resource entity for the JSON api.
     *
     * @param Mklab $mklab
     */
    public function serialize(Mklab $mklab)
    {
        /**
         * content为Markdown文本 htmlcontent为json字符串，处理逻辑在JS代码中
         * json[0]为ymal串，解析后为工作流调用信息
         * 
         * 正则表达式
         * var str="<div data-markdown><textarea data-text>***<tr>kjk</tr></div></textarea>";
         *
         * 单元格例：<section data-markdown><textarea data-template>
         * ## Page title
         * A paragraph with some text and a [link](http://hakim.se).
         * </textarea></section>
         *
         * js:str.match(/<section data-markdown><textarea data-template>([\s\S]*)<\/textarea><\/section>/)[1]);
         *
         *
         * 行例：<section class='md-markdown-row'>
         * <section data-markdown class='md-markdown-cell'><textarea data-template>
         * ## Page title
         * A paragraph with some text and a [link](http://hakim.se).
         * </textarea></section>
         * <section data-markdown class='md-markdown-cell'><textarea data-template>
         * ## Page title
         * A paragraph with some text and a [link](http://hakim.se).
         * </textarea></section></section>
         * ps: 最后一行结束为行和单元格结尾之和
         *
         *  js:str.match(/<section class=\'md-markdown-cell\'>([\s\S]*)<\/textarea><\/section><\/section>/)[1]);
         *  var str="121\n21312\n```yaml\ntestphp();\n```\n121321";
         *  alert(str.match(/\n```yaml\n([\S\s]+;)\n```\n/)[1])
         *   
         *   php:
         *   $str="121\n21312\n```yaml\ntestphp();\n```\n121321";
         *   preg_match_all('/\n```yaml\n([\S\s]+;)\n```\n/',$str, $pat_array);
         *   print_r($pat_array[1]);
         * * */
        
         $mkmeta = null;
         $mkArray = array();
        
         //取json串的第一个元素
         $jsonStr = json_decode($mklab->getHtmlcontent(),true)[0]['content'];
         if (!empty($jsonStr)){
          //取元素
             preg_match_all('/```yaml\n([\S\s]*)\n```/',$jsonStr,$mkArray);             
             if (!empty($mkArray[1][0])){
             $mkmeta = Yaml::parse($mkArray[1][0]);
             }
         }
       
        return [
            'id' => $mklab->getId(),  
            'defaultMode' => $mklab->getDefaultMode(),
	    'content' => $mklab->getContent(),
	    'htmlcontent' => $mklab->getHtmlcontent(),
            'mkmeta' => $mkmeta,
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
