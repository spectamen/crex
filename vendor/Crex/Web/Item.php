<?php

namespace Crex\Web;

use Crex\CrexObject;
use Crex\Web\Exception\WebItemException;
use Crex\Helper\HTML;
use Crex\Helper\GenHelper;
use Crex\Helper\TextHelper;

class Item extends CrexObject {
    
    protected $name;
    protected $attributes = array();
    protected $content = array();
    
    private $ansiOnlyAttributes = array(
        'id',
        'name'
    );
    
    public function __toString() {
        return HTML::toHTML($this);
    }
    
    public function addAttribute($name, $value = NULL) {
        if(in_array(strtolower($name), $this->ansiOnlyAttributes)) {
            $this->checkAnsi($value, $name);
        }
        $this->attributes[$name] = $value;
        return $this;
    }
    
    public function addContent($content, $name = NULL, $pre = 0, $shifted = 0) {
        (!isset($name)) ? $name = GenHelper::RandomString(8): $name = $name;
        $newArray = array('content' => $content, 'pre' => $pre);
        if($shifted == 1) {
            $this->content = array($name => $newArray) + $this->content;
        } else {
            $this->content = $this->content + array($name => $newArray);
        }        
        return $this->content[$name]['content'];
    }
    
    public function getName() {
        return $this->name;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getContent() {
        return $this->content;
    }
    
    public function getContentItem($name) {
        return $this->content[$name]['content'];
    }

    public function getNonpairTags() {
        return $this->nonpairTags;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setAttributes($attributes) {
        $this->attributes = $attributes;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setNonpairTags($nonpairTags) {
        $this->nonpairTags = $nonpairTags;
        return $this;
    }
    
    private function checkAnsi($value, $name) {
        if(!TextHelper::isASCII($value) OR TextHelper::hasWhitespace($value)) {
            throw new WebItemException("Bad value " . $value . " for attribute " . $name . " on element " . $this->name . " - attribute must not contain whitespace or non-ASCII characters.", 0, NULL, 4);
        }
    }
    
}
