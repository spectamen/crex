<?php

namespace Crex\Helper;

use Crex\Porzana\Porzana;

abstract class HTML {

    private static $nonpairTags = array(
        'area',
        'base',
        'basefont',
        'br',
        'col',
        'embed',
        'frame',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
        'track'
    );
    private static $notSupported = array(
        'dir',
        'tt'
    );
    private static $nonDivedTags = array(
        'a',
        'legend',
        'option'
    );
    private static $booleanAttributes = array(
        'async',
        'autocomplete',
        'autofocus',
        'autoplay',
        'border',
        'challenge',
        'checked',
        'compact',
        'contenteditable',
        'controls',
        'default',
        'defer',
        'disabled',
        'formNoValidate',
        'frameborder',
        'hidden',
        'indeterminate',
        'ismap',
        'loop',
        'multiple',
        'muted',
        'nohref',
        'noresize',
        'noshade',
        'novalidate',
        'nowrap',
        'open',
        'readonly',
        'required',
        'reversed',
        'scoped',
        'scrolling',
        'seamless',
        'selected',
        'sortable',
        'spellcheck',
        'translate'
    );
    
    private static $multipleclassTags = array(
	'input'
    );

    public static function toHTML($object) {
        $string = '';
        (!in_array(strtolower($object->name), self::$nonpairTags)) ? $isPair = 1 : $isPair = 0;
        
        $objectContentCount = 0;
        
        foreach($object->content as $content) {
            if(is_object($content['content'])) {
                $objectContentCount++;
            }
        }
                
        
        if($objectContentCount > 0 and $isPair == 0) {
            $string = $string . '<div class="crex-' . strtolower($object->name) . '-outer">' . "\n";
        }         
        
        foreach($object->content as $content) {
            if($content['pre'] == 1) {
                $string = $string . $content['content'] . "\n";
            }            
        }
        
        if(!in_array(strtolower($object->name), self::$nonDivedTags)) {
            $string = $string . '<div class="crex-' . strtolower($object->name);
	    if(in_array(strtolower($object->name), self::$multipleclassTags) and isset($object->attributes['type'])) {
		$string = $string . ' crex-' . $object->name . '-' . $object->attributes['type'];
	    }
	    $string = $string .  '">' . "\n";
        }        
        
        $string = $string . '<' . strtolower($object->name) . self::parseAttributes($object) . '>' . "\n";
        
        foreach($object->content as $content) {
            if($content['pre'] == 0) {
                $string = $string . $content['content'] . "\n";
            }            
        }
        
        if ($isPair == 1) {
            $string = $string . '</' . strtolower($object->name) . '>' . "\n";
        }
        
        if($objectContentCount > 0 and $isPair == 0) {
            $string = $string . '</div>' . "\n";
        }
        
        if(!in_array(strtolower($object->name), self::$nonDivedTags)) {
            $string = $string . '</div>' . "\n";
        }        
        $string = Porzana::replaceShortcuts($string, NULL, 1);
	//$string = Porzana::returnSortedHtml($string);
        return $string;
    }

    private static function parseAttributes($object) {
        $string = ' ';
        foreach ($object->attributes as $attribute => $value) {
            if(in_array($attribute, self::$booleanAttributes)) {
                $string = $string . $attribute;
            } else {
                $string = $string . strtolower($attribute) . '="' . $value . '"';
            }            
            $string = $string . ' ';
        }
        return substr($string, 0, -1);
    }

}
