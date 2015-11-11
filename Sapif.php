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