<?php

namespace Crex\Porzana;

use Crex\Service\Service as Service;

class Porzana extends Service {
    
    private static $block;
    
    public static function draw($mainTemplate, $templates = array(), $parameters = array(), $PHP = 0) {
        while(true) {
            $filename = "../cache/" . uniqid('porzana_temp', true) . '.php';
            if (!file_exists($filename)) break;
        }
        file_put_contents($filename, self::returnParsedTemplate($mainTemplate, $templates, $parameters, $PHP));
        include($filename);
        unlink($filename);
    }
        
    public static function returnParsedTemplate($mainTemplate, $templates = array(), $parameters = array(), $PHP = 0) {
        $t = self::returnLoadedTemplate($mainTemplate);
        $t = self::replaceTemplatesShortcuts($t, $templates);
        $t = self::replaceShortcuts($t, $parameters, $PHP);
        return $t;
    }
    
    public static function returnSortedHtml($string, $level = 0) {
        $string = preg_replace("~>\\s+<~m", '><', $string);
        $string = preg_replace('~<[^>]*>~', "\n" . '\0' . "\n", $string);
        $string = preg_replace("~\n\n~m", "\n", $string);
        self::$block = explode("\n", $string);
        self::$block = array_reverse(self::$block);
        self::returnParsedBlock();
        self::$block = array_reverse(self::$block);
        foreach(self::$block as $key => $line) {
            self::$block[$key] = self::returnTabs($level) . $line;
        }
        self::cutBlankRows();
        $string = implode("\n", self::$block);
        return $string;
    }
    
    private static function replaceShortcuts($string, $parameters = array(), $PHP = 0) {
        $matches = array();
        $keywords = array();
        preg_match_all('~\{[^{}]*\}~', $string, $matches);
        foreach($matches[0] as $key => $keyword) {
            $keywords[$keyword] = str_replace('}', '', str_replace('{' , '', $matches[0][$key]));
        }
        foreach($keywords as $key => $word) {
            $replacedString = self::returnReplacedString($word, $parameters, $PHP);
            $string = str_replace($key, $replacedString, $string);
        }
        return $string;
    }
        
    private static function replaceTemplatesShortcuts($string, $templates = array()) {
        while(true) {
            $keywords = array();
            $matches = array();
            preg_match_all('/\{\_[^{}]*\}/', $string, $matches);
            foreach($matches[0] as $key => $keyword) {
                $keywords[$keyword] = substr(str_replace('}', '', str_replace('{', '', $matches[0][$key])), 1);
            }
            foreach($keywords as $key => $word) {
                $string = str_replace($key, self::returnLoadedTemplate($templates[$word]), $string);
            }
            if(!preg_match_all('/\{\_[^{}]*\}/', $string, $matches)) {
                break;
            }
        }
        return $string;
    }
    
    private static function returnLoadedTemplate($template) {
        if(!file_exists($template)) {
            throw new \crex\Porzana\Exception\TemplateException('Can not load template ' . $template . '. File does not exists.');
        }
        return file_get_contents($template);
    }
    
    private static function returnReplacedString($word, $parameters = array(), $PHP = 0) {
        /* find declaration */
        $pos = strlen($word) - 1;
        if(strpos($word, ' ')) {
            $pos = strpos($word, ' ') - 1;
        } elseif(strpos($word, '|')) {
            $pos = strpos($word, '|') - 1;
        }
        /* parse params and modif */
        $params = '';
        $modif = '';
        $params = str_replace(substr($word, 0, $pos), '', $word);
        if(strpos($params, '|')) {
            $modif = substr($params, strpos($params, '|'));
            $params = substr($params, 0, strpos($params, '|') - 1);
        }
        $declaration = substr($word, 0, $pos + 1);
        
        return self::parseReturnForReplacedString($declaration, $params, $modif, $parameters, $PHP);
    }
    
    private static function parseReturnForReplacedString($declaration, $params, $modif, $parameters, $PHP = 0) {
        $return = '';
        switch(self::declarationType($declaration)) {
            case('const'):
                if($PHP == 1) {
                    $return = constant(strtoupper(substr($declaration, 1)));
                    break;
                } else {
                    $return = $return . 'constant("' . strtoupper(substr($declaration, 1)) . '")';
                    break;
                }
            case('var'):
                if($PHP == 1) {
                    $return = $parameters[substr($declaration, 1)];
                    break;
                } else {
                    $return = $return . $declaration;
                    break;
                }
            case('par_var'):
                if($PHP == 1) {
                    throw Exception\TemplateException('Could not use par_var with PHP switch on!');
                }
                $return = $return . '$parameters["' . substr($declaration, 1) . '"]';
                break;
            case('begin'):
                $return = $return . '\\Crex\\Porzana\\Functions\\Porzana' . ucfirst(substr($declaration, 0)) . '::begin()';
                break;
            case('end'):
                $return = $return . '\\Crex\\Porzana\\Functions\\Porzana' . ucfirst(substr($declaration, 1)) . '::end()';
                break;
            default:
                $return = $return;
                break;
        }
        if($PHP == 0) {
            $return = '<?php echo(' . $return . '); ?>';
        }
        return $return;
    }
    
    private static function declarationType($declaration) {
        $string = '';
        
        /* #word = CONST */
        if(preg_match('~\#(.*)~', $declaration)) {
            $string = 'const';
        } 
        /* $word = $word */
        elseif(preg_match('~\$(.*)~', $declaration)) {
            $string = 'var';
        } 
        /* @word = $this->parameters['word'] */
        elseif(preg_match('~\@(.*)~', $declaration)) {
            $string = 'par_var';
        } 
        /* /word = word::end(); */
        elseif(preg_match('~\/(.*)~', $declaration)) {
            $string = 'end';
        } 
        /* word = word::begin(); */
        else {
            $string = 'begin';
        }
        return $string;
    }
    
    private static function returnParsedBlock($startPos = 0) {
        $openedTag = str_replace('</', '', trim(self::$block[$startPos]));
        $openedTag = str_replace('>', '', $openedTag);
        $pos = strpos($openedTag, ' ');
        if($pos) {
            $openedTag = substr($openedTag, 0, $pos + 1);
        }
        
        for($i = $startPos + 1; $i < count(self::$block); $i++) {
            //is that closing tag?
            if(preg_match('~</.*>~', self::$block[$i])) {
                $i = self::returnParsedBlock($i);                
            } 
            //is that begining?
            elseif(preg_match('~<' . $openedTag . '.*>~', self::$block[$i])) {
                for($j = $i - 1; $j >= $startPos + 1; $j--) {
                    self::$block[$j] = "\t" . self::$block[$j];
                }
                break;
            }
            else {
                self::$block[$i] = trim(self::$block[$i]);
            }
        }        
        return $i;
    }
    
    private static function returnTabs($multiplier = 0) {
        $string = "";
        for($i = 0; $i < $multiplier; $i++) {
            $string = $string . "\t";
        }
        return $string;
    }
    
    private static function cutBlankRows() {
        foreach(self::$block as $rowNumber => $row) {
            if(strlen(preg_replace("~\s+~", "", $row)) == 0) {
                unset(self::$block[$rowNumber]);
            }
        }
    }
}
