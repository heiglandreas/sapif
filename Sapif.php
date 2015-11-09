<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Org_Heigl\Wordpress;

use jlawrence\eos\Parser;

class Sapif
{
    protected $currentPost;

    protected $items;

    public function __construct()
    {
        $this->currentPost = 0;
        $this->items = [get_option('sapif_items')];
//        $this->items = [
//            array(
//                'equation' => 'x',
//                'results'   => [2],
//                'content'  => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
//<!-- Leaderboard -->
//<ins class="adsbygoogle"
//     style="display:inline-block;width:728px;height:90px"
//     data-ad-client="ca-pub-6068436026173561"
//     data-ad-slot="9605148135"></ins>
//<script>
//(adsbygoogle = window.adsbygoogle || []).push({});
//</script>',
//            ),
//        ];
    }

    public function addContent($content, $query)
    {
        $this->currentPost ++;

        foreach ($this->items as $item) {
            $result = in_array(
                Parser::solve($item['equation'],
                    array('x' => $this->currentPost)),
                $item['results']
            );

            if ($result === true) {
                echo $item['content'];
            }
        }
    }
}