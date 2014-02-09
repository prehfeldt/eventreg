<?php

namespace EventReg\EventBundle\Twig;

use dflydev\markdown\MarkdownExtraParser;

class EventExtension extends \Twig_Extension {

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'event_extension';
    }

    public function getFilters() {
        return array(
            'markdown' => new \Twig_Filter_Method($this, 'markdownFilter', array('is_safe' => array('html')))
        );
    }

    public function markdownFilter($string) {
        $markdownParser = new MarkdownExtraParser();
        $markdown = $markdownParser->transformMarkdown($string);

        return $markdown;
    }
}
