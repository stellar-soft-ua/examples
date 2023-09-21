<?php

namespace THEME\Theme;

use THEME\Framework\Templating\BladeDirectives as BladeDirectivesBase;

class BladeDirectives extends BladeDirectivesBase
{
    /**
     * @param string $expression
     * @return string
     */
    public function hello($expression)
    {
        return "<?php echo 'Hello ' . {$expression}; ?>";
    }
}
