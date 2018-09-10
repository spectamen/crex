<?php

namespace Crex\Web\Form\Fieldset;

use Crex\Web\Form\AFormBlock;

class Fieldset extends AFormBlock {
    
    public function setLegend($legend) {
        $contentItem = $this->returnNewContentItem('legend');
        $contentItem->addContent($legend);
        $this->addContent($contentItem, 'legend');
        return $this;
    }
    
}
