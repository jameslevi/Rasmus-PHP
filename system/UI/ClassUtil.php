<?php

namespace Rasmus\UI;

use Rasmus\App\Config;
use Rasmus\Util\String\Str;

abstract class ClassUtil
{

    /**
     * Allowed color names.
     */

    protected $colors = [
        'aqua',
        'black',
        'blue',
        'brown',
        'cyan',
        'fuschia',
        'gold',
        'gray',
        'green',
        'ivory',
        'lavender',
        'lime',
        'magenta',
        'maroon',
        'navy',
        'olive',
        'orange',
        'pink',
        'purple',
        'red',
        'silver',
        'teal',
        'violet',
        'white',
        'yellow',
        'transparent',
    ];

    /**
     * Border width values.
     */

    protected $border_width = [
        'medium',
        'thin',
        'thick',
        'initial',
        'inherit',           
    ];

    /**
     * Border style values.
     */

    protected $border_style = [
        'none',
        'hidden',
        'dotted',
        'dashed',
        'solid',
        'double',
        'groove',
        'ridge',
        'inset',
        'outset',
        'initial',
        'inherit',
    ];

    /**
     * Display values.
     */

    protected $display = [
        'none',
        'block',
        'inline',
        'initial',
        'inherit',
    ];

    /**
     * Float values.
     */

    protected $float = [
        'left',
        'right',
        'none',
        'initial',
        'inherit',
    ];

    /**
     * Clear values.
     */

    protected $clear = [
        'left',
        'right',
        'none',
        'both',
        'initial',
        'inherit',
    ];

    /**
     * Position values.
     */

    protected $position = [
        'static',
        'absolute',
        'fixed',
        'relative',
        'sticky',
        'initial',
        'inherit',
    ];

    /**
     * Text transform values.
     */

    protected $transform = [
        'none',
        'capitalize',
        'uppercase',
        'lowercase',
        'initial',
        'inherit',
    ];

    /**
     * Font weight.
     */

    protected $font_weight = [
        'bold',
        'normal',
        'bolder',
        'lighter',
        '100',
        '200',
        '300',
        '400',
        '500',
        '600',
        '700',
        '800',
        '900',
    ];

    /**
     * Font style.
     */

    protected $font_style = [
        'normal',
        'italic',
        'oblique',
        'initial',
        'inherit',
    ];

    /**
     * Text decoration.
     */

    protected $text_decoration = [
        'none',
        'underline',
        'overline',
        'line-through',
        'initial',
        'inherit',
    ];

    /**
     * Text decoration style.
     */

    protected $decor_style = [
        'solid',
        'double',
        'dotted',
        'dashed',
        'wavy',
        'initial',
        'inherit',
    ];

    /**
     * Text align.
     */

    protected $text_align = [
        'left',
        'right',
        'center',
        'justify',
        'initial',
        'inherit',
    ];

    /**
     * Vertical align.
     */

    protected $valign = [
        'baseline',
        'sub',
        'super',
        'top',
        'text-top',
        'middle',
        'bottom',
        'text-bottom',
        'initial',
        'inherit',
    ];

    /**
     * Container overflow.
     */

    protected $overflow = [
        'auto',
        'visible',
        'hidden',
        'scroll',
        'initial',
        'inherit',
    ];

    /**
     * Element visibility.
     */

    protected $visibility = [
        'visible',
        'hidden',
        'collapse',
        'initial',
        'inherit',           
    ];

    /**
     * Word break.
     */

    protected $word_break = [
        'normal',
        'break-all',
        'keep-all',
        'break-word',
        'initial',
        'inherit',
    ];

    /**
     * White space.
     */

    protected $white_space = [
        'normal',
        'nowrap',
        'pre',
        'initial',
        'inherit',
    ];

    /**
     * Resize.
     */

    protected $resize = [
        'none',
        'both',
        'horizontal',
        'vertical',
        'initial',
        'inherit',
    ];

    protected $auto = [
        'auto',
        'initial',
        'inherit',
    ];

    protected $normal = [
        'normal',
        'initial',
        'inherit',
    ];

    /**
     * Mouse cursor.
     */

    protected $cursor = [
        'alias',
        'auto',
        'cell',
        'copy',
        'crosshair',
        'default',
        'grab',
        'grabbing',
        'help',
        'move',
        'none',
        'pointer',
        'progress',
        'text',
        'URL',
        'wait',
        'initial',
        'inherit',
    ];

    /**
     * Border collapse.
     */

    protected $border_collapse = [
        'separate',
        'collapse',
        'initial',
        'inherit',
    ];

    /**
     * Available font groups.
     */

    protected $families = [
        'sans' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Halvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
        'serif' => 'Georgia, Cambria, "Times New Roman", Times, serif',
        'mono' => 'Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
    ];

    /**
     * Make new css rule.
     */

    public function make(string $method, string $value, string $pseudo = null)
    {
        if(method_exists($this, $method))
        {
            $is_important = false;
            if(Str::endWith($value, '!'))
            {
                $is_important = true;
                $value = Str::move($value, 0, 1);
            }
            
            $data = $this->{$method}($value);
            
            if(!is_null($data))
            {
                if($is_important)
                {
                    $rules = '';
                    foreach(explode(';', $data[1]) as $rule)
                    {
                        $rules .= $rule . ' !important;';
                    }

                    return $this->template($data[0], $rules, $pseudo);
                }   
                else
                {
                    return $this->template($data[0], $data[1], $pseudo);
                }
            }
        }
    }

    /**
     * Make new css rule from methods without parameters.
     */

    public function makeDirectCall(string $method, string $pseudo = null)
    {
        $method = str_replace('-', '_', $method);

        if(method_exists($this, $method))
        {
            $is_important = false;
            if(Str::endWith($method, '!'))
            {
                $is_important = true;
                $method = Str::move($method, 0, 1);
            }

            $data = $this->{$method}();
            
            if(!is_null($data))
            {
                if($is_important)
                {
                    $rules = '';
                    foreach(explode(';', $data[1]) as $rule)
                    {
                        $rules .= $rule . ' !important';
                    }

                    return $this->template($data[0], $rules, $pseudo);
                }
                else
                {
                    return $this->template($data[0], $data[1], $pseudo);
                }
            }
        }
    }

    /**
     * Test if method requires no parameter value.
     */

    public function hasDirectMethod(string $method)
    {
        $method = str_replace('-', '_', $method);

        if(Str::endWith($method, '!'))
        {
            $method = Str::move($method, 0, 1);
        }

        return method_exists($this, $method);
    }

    /**
     * CSS Rule template.
     */

    private function template(string $class, string $rules, string $pseudo = null)
    {
        if(!is_null($pseudo) && !Str::startWith($pseudo, 'media-'))
        {
            return '.v-' . $class . ':' . $pseudo . '{' . $rules . '}';
        }
        else
        {
            return '.v-' . $class . '{' . $rules . '}';
        }
    }

    /**
     * Test if string is hex color.
     */

    protected function isHex(string $hex)
    {
        return Str::startWith($hex, '#') && strlen($hex) === 7;
    }

    /**
     * Test if value is a valid pixel.
     */

    protected function isPX(string $px)
    {
        return Str::endWith($px, 'px');
    }

    /**
     * Test if value is valid border width.
     */

    protected function validBorderWidth(string $width)
    {
        return in_array($width, $this->border_width) || $this->isPX($width);
    }

    /**
     * Test if value is a valid border style.
     */

    protected function isBorderStyle(string $style)
    {
        return in_array($style, $this->border_style);
    }

    /**
     * Test if value is color scheme alias.
     */

    protected function isSchemeColor(string $color)
    {
        return !is_null($this->toRGB($color));
    }

    /**
     * Return RGB value of color scheme alias.
     */

    protected function toRGB(string $color)
    {
        return Config::scheme()->{$color} ?? null;
    }

    /**
     * Return border color css rule.
     */

    protected function getBorderColor(string $color)
    {
        $rgb = $this->toRGB($color);
        
        return 'rgb(' . $rgb['R'] . ',' . $rgb['G'] . ',' . $rgb['B'] . ')';
    }

    /**
     * Test if value is valid degree.
     */

    protected function isDeg(string $degree)
    {
        return Str::endWith($degree, 'deg');
    }

    /**
     * Make 2d or 3d transformation to element.
     */

    protected function trans(string $transform)
    {
        if(in_array($transform, [
            'none',
            'initial',
            'inherit',
        ]))
        {
            return ['trans-' . $transform, 'transform:' . $transform];
        }
    }

    /**
     * X axis translation.
     */

    protected function trans_tx(string $translation)
    {
        if($this->isPX($translation))
        {
            return ['trans-tx-' . $translation, 'transform:translateX(' . $translation . ')'];
        }
    }   

    /**
     * Y axis translation.
     */

    protected function trans_ty(string $translation)
    {
        if($this->isPX($translation))
        {
            return ['trans-ty-' . $translation, 'transform:translateY(' . $translation . ')'];
        }
    }   

    /**
     * Z axis translation.
     */

    protected function trans_tz(string $translation)
    {
        if($this->isPX($translation))
        {
            return ['trans-tz-' . $translation, 'transform:translateZ(' . $translation . ')'];
        }
    }

    /**
     * Transform x axis by scaling.
     */

    protected function trans_sx(string $scale)
    {
        return ['trans-sx-' . $scale, 'transform:scaleX(' . $scale . ')'];
    }

    /**
     * Transform y axis by scaling.
     */

    protected function trans_sy(string $scale)
    {
        return ['trans-sy-' . $scale, 'transform:scaleY(' . $scale . ')'];
    }

    /**
     * Transform z axis by scaling.
     */

    protected function trans_sz(string $scale)
    {
        return ['trans-sz-' . $scale, 'transform:scaleZ(' . $scale . ')'];
    }   

    /**
     * Rotate element in x axis.
     */

    protected function trans_rx(string $rotate)
    {
        if($this->isDeg($rotate))
        {
            return ['trans-rx-' . $rotate, 'transform:rotateX(' . $rotate . ')'];
        }
    }   

    /**
     * Rotate element in y axis.
     */

    protected function trans_ry(string $rotate)
    {
        if($this->isDeg($rotate))
        {
            return ['trans-ry-' . $rotate, 'transform:rotateY(' . $rotate . ')'];
        }
    }

    /**
     * Rotate element in z axis.
     */

    protected function trans_rz(string $rotate)
    {
        if($this->isDeg($rotate))
        {
            return ['trans-rz-' . $rotate, 'transform:rotateZ(' . $rotate . ')'];
        }
    }

    /**
     * Skew transform element in x axis.
     */

    protected function trans_skx(string $skew)
    {
        if($this->isDeg($skew))
        {
            return ['trans-skx-' . $skew, 'transform:skewX(' . $skew . ')'];
        }
    }

    /**
     * Skew transform element in y axis.
     */

    protected function trans_sky(string $skew)
    {
        if($this->isDeg($skew))
        {
            return ['trans-sky-' . $skew, 'transform:skewY(' . $skew . ')'];
        }
    }

    /**
     * Element transformation style.
     */

    protected function trans_style(string $style)
    {
        if(in_array($style, [
            'flat',
            'initial',
            'inherit',
        ]))       
        {
            return ['trans-style-' . $style, 'transform-style:' . $style];
        }
    }

    /**
     * Element transformation style preserve 3d.
     */

    protected function trans_style_preserve_3d()
    {
        return ['trans-style-preserve-3d', 'transform-style:preserve-3d'];
    }

    /**
     * Make element unselectable.
     */

    protected function unselectable()
    {
        return ['unselectable', 'user-select:none;-moz-user-select: none;-khtml-user-select: none;-webkit-user-select: none;-o-user-select: none'];
    }

}