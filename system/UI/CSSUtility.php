<?php

namespace Rasmus\UI;

use Rasmus\Util\String\Str;

class CSSUtility extends ClassUtil
{
    /**
     * Make element visible.
     */

    protected function show()
    {
        return ['show', 'display:block'];
    }

    /**
     * Make element invisible.
     */

    protected function hide()
    {
        return ['hide', 'display:none'];
    }

    /**
     * Make element inline.
     */

    protected function inline()
    {
        return ['inline', 'display:inline'];
    }

    /**
     * Set element display.
     */

    protected function display(string $display)
    {
        if(in_array($display, $this->display))
        {
            return ['display-' . $display, 'display:' . $display];
        }
    }

    /**
     * Set element display to inline block.
     */

    protected function display_inline_block()
    {
        return ['display-inline-block', 'display:inline-block'];
    }

    /**
     * Set element float.
     */

    protected function f(string $float)
    {
        if(in_array($float, $this->float))
        {
            return ['f-' . $float, 'float:' . $float];
        }
    }

    /**
     * Set element clear.
     */

    protected function clear(string $clear)
    {
        if(in_array($clear, $this->clear))
        {
            return ['clear-' . $clear, 'clear:' . $clear];
        }
    }

    /**
     * Set left positioning of element.
     */

    protected function left(string $left)
    {
        if(Str::endWith($left, 'px') || in_array($left, $this->auto))
        {
            return ['left-' . $left, 'left:' . $left];
        }
    }

    /**
     * Set right positioning of element.
     */

    protected function right(string $right)
    {
        if(Str::endWith($right, 'px') || in_array($right, $this->auto))
        {
            return ['right-' . $right, 'right:' . $right];
        }
    }

    /**
     * Set top positioning of element.
     */

    protected function top(string $top)
    {
        if(Str::endWith($top, 'px') || in_array($top, $this->auto))
        {
            return ['top-' . $top, 'top:' . $top];
        }
    }

    /**
     * Set bottom positioning of element.
     */

    protected function bottom(string $bottom)
    {
        if(Str::endWith($bottom, 'px') || in_array($bottom, $this->auto))
        {
            return ['bottom-' . $bottom, 'bottom:' . $bottom];
        }
    }

    /**
     * Set element position.
     */

    protected function pos(string $position)
    {
        if(in_array($position, $this->position))
        {
            return ['pos-' . $position, 'position:' . $position];
        }
    }

    /**
     * Set element z-index position.
     */

    protected function z_index(string $index)
    {
        if(in_array($index, [
            'auto',
            'initial',
            'inherit',
        ]) || is_numeric($index))
        {
            return ['z-index-' . $index, 'z-index:' . $index];
        }
    }

    /**
     * Transform text to uppercase.
     */

    protected function uc()
    {
        return ['uc', 'text-transform:uppercase'];
    }

    /**
     * Transform text to lowercase.
     */

    protected function lc()
    {
        return ['lc', 'text-transform:lowercase'];
    }

    /**
     * Set text-transform.
     */

    protected function transform(string $type)
    {
        if(in_array($type, $this->transform))
        {
            return ['transform-' . $type, 'text-transform:' . $type];
        }
    }

    /**
     * Bold text.
     */

    protected function bold()
    {
        return ['bold', 'font-weight:bold'];
    }

    /**
     * Set text weight.
     */

    protected function weight(string $type)
    {
        if(in_array($type, $this->font_weight))
        {
            return ['weight-' . $type, 'font-weight:' . $type];
        }
    }

    /**
     * Italic text.
     */

    protected function italic()
    {
        return ['italic', 'font-style:italic'];
    }

    /**
     * Set font style.
     */

    protected function style(string $style)
    {
        if(in_array($style, $this->font_style))
        {
            return ['style-' . $style, 'font-style:' . $style];
        }
    }

    /**
     * Set text decoration line.
     */

    protected function decor_line(string $decor)
    {
        if(in_array($decor, $this->text_decoration))
        {
            return ['decor-line-' . $decor, 'text-decoration-line:' . $decor];
        }
    }

    /**
     * Set text decoration color.
     */

    protected function decor_color(string $color)
    {
        return ['decor-color-' . $color, 'text-decoration-color:' . $color];
    }

    /**
     * Set text decoration style.
     */

    protected function decor_style(string $style)
    {
        if(in_array($style, $this->decor_style))
        {
            return ['decor-style-' . $style, 'text-decoration-style:' . $style];
        }
    }

    /**
     * Underline text.
     */

    protected function underline()
    {
        return ['underline', 'text-decoration:underline'];
    }

    /**
     * Set text-decoration to none.
     */

    protected function decor_none()
    {
        return ['decor-none', 'text-decoration:none'];
    }

    /**
     * Set text align.
     */

    protected function align(string $align)
    {
        if(in_array($align, $this->text_align))
        {
            return ['align-' . $align, 'text-align:' . $align];
        }
    }

    /**
     * Set vertical align of element.
     */

    protected function valign(string $valign)
    {
        if(in_array($valign, $this->valign))
        {
            return ['valign-' . $valign, 'vertical-align:' . $valign];
        }
    }

    /**
     * Align center elements.
     */

    protected function center()
    {
        return ['center', 'margin-left:auto;margin-right:auto'];
    }

    /**
     * Set font size.
     */

    protected function size(string $size)
    {
        if((Str::endWith($size, 'px') || Str::endWith($size, 'cm') || Str::endWith($size, 'em')) || in_array($size, [
            'initial',
            'inherit',
        ]))
        {
            return ['size-' . $size, 'font-size:' . $size];
        }
    }

    /**
     * Set font family.
     */

    protected function family(string $family)
    {
        if(array_key_exists($family, $this->families))
        {
            return ['family-' . $family, 'font-family:' . $this->families[$family]];
        }
    }

    /**
     * Set letter spacing.
     */
    
    protected function spacing(string $spacing)
    {
        if(Str::endWith($spacing, 'px') || in_array($spacing, $this->normal))
        {
            return ['spacing-' . $spacing, 'letter-spacing:' . $spacing];
        }
    }

    /**
     * Set text line height.
     */

    protected function lh(string $height)
    {
        if($this->isPX($height) || in_array($height, $this->normal))
        {
            return ['lh-' . $height, 'line-height:' . $height];
        }
    }

    /**
     * Set text color.
     */

    protected function color(string $color)
    {
        if(in_array($color, $this->colors))
        {
            return ['color-' . $color, 'color:' . $color];
        }
        else
        {
            if($this->isHex($color))
            {
                return ['color-' . $color, 'color:#' . Str::move($color, 1)];
            }
            else if($this->isSchemeColor($color))
            {
                $rgb = $this->toRGB(Str::break($color, '_')[0]);

                if(Str::has($color, '_'))
                {
                    $rgb = $rgb[Str::break($color, '_')[1]];
                }
                else
                {
                    $rgb = $rgb['default'];
                }

                return ['color-' . $color, 'color:rgb(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ')'];
            }
        }
    }

    /**
     * Set fixed width.
     */

    protected function w(string $width)
    {
        if(Str::endWith($width, 'px'))
        {
            return ['w-' . $width, 'width:' . $width];
        }
        else
        {
            if(in_array($width, [
                'auto',
                'initial',
                'inherit',
                'fill',
            ]))
            {
                if(strtolower($width) === 'fill')
                {
                    return ['w-fill', 'width:100%'];
                }
                else
                {
                    return ['w-' . $width, 'width:' . $width];
                }
            }
            else
            {
                return ['w-' . $width, 'width:' . $width . '%'];
            }
        }
    }

    /**
     * Dynamically subtract inherited width by offset width.
     */

    protected function w_offset(string $width)
    {
        if(Str::endWith($width, 'px'))
        {
            return ['w-offset-' . $width, 'width: calc(100% - ' . $width . ')'];
        }
    }

    /**
     * Dynamically subtract inherited height by offset height.
     */

    protected function h_offset(string $height)
    {
        if(Str::endWith($height, 'px'))
        {
            return ['h-offset-' . $height, 'height: calc(100% - ' . $height . ')'];
        }
    }

    /**
     * Set fixed height.
     */

    protected function h(string $height)
    {
        if(Str::endWith($height, 'px') || Str::endWith($height, 'vh'))
        {
            return ['h-' . $height, 'height:' . $height];
        }
        else
        {
            if(in_array($height, $this->auto))
            {
                return ['h-' . $height, 'height:' . $height];
            }
            else
            {
                return ['h-' . $height, 'height:' . $height . '%'];
            }
        }
    }

    /**
     * Set fixed width and height.
     */

    protected function square(string $side)
    {
        if(Str::endWith($side, 'px'))
        {
            return ['square-' . $side, 'width:' . $side . ';height:' . $side];
        }
        else
        {
            return ['square-' . $side, 'width:' . $side, '%;height:' . $side . '%'];
        }
    }

    /**
     * Set min-width.
     */

    protected function min_w(string $width)
    {
        if(Str::endWith($width, 'px'))
        {
            return ['min-w-' . $width, 'min-width:' . $width];
        }   
        else
        {
            if(in_array($width, [
                'initial',
                'inherit',
            ]))
            {
                return ['min-w-' . $width, 'min-width:' . $width];
            }
            else
            {
                return ['min-w-' . $width, 'min-widt:' . $width . '%'];
            }
        }     
    }

    /**
     * Set maximum width.
     */

    protected function max_w(string $width)
    {
        if(Str::endWith($width, 'px'))
        {
            return ['max-w-' . $width, 'max-width:' . $width];
        }
        else
        {
            if(in_array($width, [
                'none',
                'initial',
                'inherit',
            ]))
            {
                return ['max-w-' . $width, 'max-width:' . $width];
            }
            else
            {
                return ['max-w-' . $width, 'max-width:' . $width . '%'];
            }
        }
    }

    /**
     * Set minimum height.
     */

    protected function min_h(string $height)
    {
        if(Str::endWith($height, 'px'))
        {
            return ['min-h-' . $height, 'min-height:' . $height];
        }
        else
        {
            if(in_array($height, [
                'none',
                'initial',
                'inherit',
            ]))
            {
                return ['min-h-' . $height, 'min-height:' . $height];
            }
            else
            {
                return ['min-h-' . $height, 'min-height:' . $height . '%'];
            }
        }
    }

    /**
     * Set maximum height.
     */

    protected function max_h(string $height)
    {
        if(Str::endWith($height, 'px'))
        {
            return ['max-h-' . $height, 'max-height:' . $height];
        }
        else
        {
            if(in_array($height, []))
            {
                return ['max-h-' . $height, 'max-height:' . $height];
            }
            else
            {
                return ['max-h-' . $height, 'max-height:' . $height . '%'];
            }
        }
    }

    /**
     * Set content overflow.
     */

    protected function ov(string $overflow)
    {
        if(in_array($overflow, $this->overflow))
        {
            return ['ov-' . $overflow, 'overflow:' . $overflow];
        }
    }

    /**
     * Set content horizontal overflow.
     */

    protected function ov_x(string $overflow)
    {
        if(in_array($overflow, $this->overflow))
        {
            return ['ov-x-' . $overflow, 'overflow-x:' . $overflow];
        }
    }

    /**
     * Set content vertical overflow.
     */

    protected function ov_y(string $overflow)
    {
        if(in_array($overflow, $this->overflow))
        {
            return ['ov-y-' . $overflow, 'overflow-y:' . $overflow];
        }
    }   

    /**
     * Set element background color.
     */

    protected function bgcolor(string $color)
    {
        if(in_array($color, $this->colors))
        {
            return ['bgcolor-' . $color, 'background-color:' . $color];
        }
        else if(strtolower($color) === 'transparent')
        {
            return ['bgcolor-transparent', 'background-color:transparent'];           
        }
        else if(strtolower($color) === 'none')
        {
            return ['bgcolor-none', 'background-color:none'];
        } 
        else
        {
            if($this->isHex($color))
            {
                return ['bgcolor-' . $color, 'background-color:' . $color];
            }
            else if($this->isSchemeColor($color))
            {
                $rgb = $this->toRGB(Str::break($color, '_')[0]);
                
                if(Str::has($color, '_'))
                {
                    $break = Str::break($color, '_');
                    $rgb = $rgb[$break[1]];
                }
                else
                {
                    $rgb = $rgb['default'];
                }

                return ['bgcolor-' . $color, 'background-color:rgb(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ')'];
            }
        }
    }

    /**
     * Set element visibility.
     */

    protected function visibility(string $visibility)
    {
        if(in_array($visibility, $this->visibility))
        {
            return ['visibility-' . $visibility, 'visibility:' . $visibility];
        }
    }

    /**
     * Justify text.
     */

    protected function justify(string $justify)
    {
        if(in_array($justify, [
            'auto',
            'none',
            'initial',
            'inherit',
        ]))
        {
            return ['justify-' . $justify, 'text-justify:' . $justify];
        }
    }

    /**
     * Set justify-content of element.
     */

    protected function justify_content(string $prop)
    {
        if(in_array($prop, [
            'center',
            'initial',
            'inherit',
        ]))
        {
            return ['justify-content-' . $prop, 'justify-content:' . $prop];
        }
    }

    /**
     * Set justify-content to flex-start.
     */

    protected function justify_content_flex_start()
    {
        return ['justify-content-flex-start', 'justify-content:flex-start'];
    }

    /**
     * Set justify-content to flex-end.
     */

    protected function justify_content_flex_end()
    {
        return ['justify-content-flex-end', 'justify-content:flex-end'];
    }

    /**
     * Set justify-content to space between.
     */

    protected function justify_content_space_between()
    {
        return ['justify-content-space-between', 'justify-content:space-between'];
    }

    /**
     * Set justify-content to space around.
     */

    protected function justify_content_space_around()
    {
        return ['justify-content-space-around', 'justify-content:space-around'];
    }

    /**
     * Set text-justify to inter-word.
     */

    protected function justify_inter_word()
    {
        return ['justify-inter-word', 'text-justify:inter-word'];
    }

    /**
     * Set text-justify to inter-character.
     */

    protected function justify_inter_character()
    {
        return ['justify-inter-character', 'text-justify:inter-character'];
    }

    /**
     * Set text word wrap.
     */

    protected function wrap(string $wrap)
    {
        if(in_array($wrap, $this->normal))
        {
            return ['wrap-' . $wrap, 'word-wrap:' . $wrap];
        }
    }   

    /**
     * Set text word wrap to break word.
     */

    protected function wrap_break_word()
    {
        return ['wrap-break-word', 'word-wrap:break-word'];
    }   

    /**
     * Set word break.
     */

    protected function wb(string $break)
    {
        if(in_array($break, $this->word_break))
        {
            return ['wb-' . $break, 'word-break:' . $break];
        }
    }

    /**
     * Set white space.
     */

    protected function ws(string $space)
    {
        if(in_array($space, $this->white_space))
        {
            return ['ws-' . $space, 'white-space:' . $space];
        }
    }

    /**
     * Set white space to pre-line.
     */

    protected function ws_pre_line()
    {
        return ['ws-pre-line', 'white-space:pre-line'];
    }   

    /**
     * Set white space to pre-wrap.
     */

    protected function ws_pre_wrap()
    {
        return ['ws-pre-wrap', 'white-space:pre-wrap'];
    }   

    /**
     * Set element resize.
     */

    protected function rz(string $resize)
    {
        if(in_array($resize, $this->resize))
        {
            return ['rz-' . $resize, 'resize:' . $resize];
        }
    }   

    /**
     * Set element margin in all sides.
     */

    protected function mg(string $margin)
    {
        if(in_array($margin, $this->auto))
        {
            return ['mg-' . $margin, 'margin:' . $margin];
        }
        else if(strtolower($margin) === 'none')
        {
            return ['mg-none', 'margin: 0px 0px 0px 0px'];
        }
        else
        {
            if($this->isPX($margin))
            {
                return ['mg-' . $margin, 'margin: ' . $margin . ' ' . $margin . ' ' . $margin . ' ' . $margin];                
            }
        }
    }

    /**
     * Set element horizontal margins.
     */

    protected function mg_x(string $margin)
    {
        if($this->isPX($margin) || in_array($margin, $this->auto))
        {
            return ['mg-x-' . $margin, 'margin-left:' . $margin . ';margin-right:' . $margin];
        }
        else if(strtolower($margin) === 'none')
        {
            return ['mg-x-none', 'margin-left:0px;margin-right:0px'];
        }
    }

    /**
     * Set element vertical margins.
     */

    protected function mg_y(string $margin)
    {
        if($this->isPX($margin) || in_array($margin, $this->auto))
        {
            return ['mg-y-' . $margin, 'margin-top:' . $margin . ';margin-bottom:' . $margin];
        }
        else if(strtolower($margin) === 'none')
        {
            return ['mg-y-none', 'margin-top:0px;margin-bottom:0px'];
        }
    }

    /**
     * Set element left margin.
     */

    protected function mg_l(string $margin)
    {
        if($this->isPX($margin) || in_array($margin, $this->auto))
        {
            return ['mg-l-' . $margin, 'margin-left:' . $margin];
        }
        else if(strtolower($margin) === 'none')
        {
            return ['mg-l-none', 'margin-left:0px'];           
        }
    }

    /**
     * Set element right margin.
     */

    protected function mg_r(string $margin)
    {
        if($this->isPX($margin) || in_array($margin, $this->auto))
        {
            return ['mg-r-' . $margin, 'margin-right:' . $margin];
        }
        else if(strtolower($margin) === 'none')
        {
            return ['mg-r-none', 'margin-right:0px'];
        }
    }

    /**
     * Set element top margin.
     */

    protected function mg_t(string $margin)
    {
        if($this->isPX($margin) || in_array($margin, $this->auto))
        {
            return ['mg-t-' . $margin, 'margin-top:' . $margin];
        }
        else if(strtolower($margin) === 'none')
        {
            return ['mg-t-none', 'margin-top:0px'];
        }
    }

    /**
     * Set element bottom margin.
     */

    protected function mg_b(string $margin)
    {
        if($this->isPX($margin) || in_array($margin, $this->auto))
        {
            return ['mg-b-' . $margin, 'margin-bottom:' . $margin];
        }
        else if(strtolower($margin) === 'none')
        {
            return ['mg-b-none', 'margin-bottom:0px'];           
        }
    }

    /**
     * Set element padding.
     */

    protected function pd(string $padding)
    {
        if(in_array($padding, [
            'initial',
            'inherit',
        ]))
        {
            return ['pd-' . $padding, 'padding:' . $padding];
        }
        else if(strtolower($padding) === 'none')
        {
            return ['pd-none', 'padding:0px 0px 0px 0px'];
        }
        else
        {
            if($this->isPX($padding))
            {
                return ['pd-' . $padding, 'padding:' . $padding . ' ' . $padding . ' ' . $padding . ' ' . $padding];
            }
        }
    }

    /**
     * Set element horizontal padding.
     */

    protected function pd_x(string $padding)
    {
        if($this->isPX($padding) || in_array($padding, [
            'initial',
            'inherit',
        ]))
        {
            return ['pd-x-' . $padding, 'padding-left:' . $padding . ';padding-right:' . $padding];
        }
        else if(strtolower($padding) === 'none')
        {
            return ['pd-x-none', 'padding-left:0px;padding-right:0px'];
        }
    }   

    /**
     * Set element vertical padding.
     */

    protected function pd_y(string $padding)
    {
        if($this->isPX($padding) || in_array($padding, [
            'initial',
            'inherit',
        ]))
        {
            return ['pd-y-' . $padding, 'padding-top:' . $padding . ';padding-bottom:' . $padding];
        }
        else if(strtolower($padding) === 'none')
        {
            return ['pd-y-none', 'padding-top:0px;padding-bottom:0px'];           
        }
    }

    /**
     * Set element left padding.
     */

    protected function pd_l(string $padding)
    {
        if($this->isPX($padding) || in_array($padding, [
            'initial',
            'inherit',
        ]))
        {
            return ['pd-l-' . $padding, 'padding-left:' . $padding];
        }
        else if(strtolower($padding) === 'none')
        {
            return ['pd-l-none', 'padding-left:0px'];
        }
    }

    /**
     * Set element right padding.
     */

    protected function pd_r(string $padding)
    {
        if($this->isPX($padding) || in_array($padding, [
            'initial',
            'inherit',
        ]))
        {
            return ['pd-r-' . $padding, 'padding-right:' . $padding];
        }
        else if(strtolower($padding) === 'none')
        {
            return ['pd-r-none', 'padding-right:0px'];           
        }
    }

    /**
     * Set element top padding.
     */

    protected function pd_t(string $padding)
    {
        if($this->isPX($padding) || in_array($padding, [
            'initial',
            'inherit',
        ]))
        {
            return ['pd-t-' . $padding, 'padding-top:' . $padding];
        }
        else if(strtolower($padding) === 'none')
        {
            return ['pd-t-none', 'padding-top:0px'];           
        }
    }   

    /**
     * Set element bottom padding.
     */

    protected function pd_b(string $padding)
    {
        if($this->isPX($padding) || in_array($padding, [
            'initial',
            'inherit',
        ]))
        {
            return ['pd-b-' . $padding, 'padding-bottom:' . $padding];
        }
        else if(strtolower($padding) === 'none')
        {
            return  ['pd-b-none', 'padding-bottom:0px'];
        }
    }

    /**
     * Set element cursor.
     */

    protected function cur(string $cursor)
    {
        if(in_array($cursor, $this->cursor))
        {
            return ['cur-' . $cursor, 'cursor:' . $cursor];
        }
    }   

    /**
     * Set element scroll to all-scroll.
     */

    protected function cur_all_scroll()
    {
        return ['cur-all-scroll', 'cursor:all-scroll'];
    }

    /**
     * Set element scroll to context-menu.
     */

    protected function cur_context_menu()
    {
        return ['cur-context-menu', 'cursor:context-menu'];
    }

    /**
     * Set element cursor to col-resize.
     */

    protected function cur_col_resize()
    {
        return ['cur-col-resize', 'cursor:col-resize'];
    }

    /**
     * Set element cursor to e-resize.
     */

    protected function cur_e_resize()
    {
        return ['cur-e-resize', 'cursor:e-resize'];
    }

    /**
     * Set element cursor to ew-resize.
     */

    protected function cur_ew_resize()
    {
        return ['cur-ew-resize', 'cursor:ew-resize'];       
    }

    /**
     * Set element cursor to n-resize.
     */

    protected function cur_n_resize()
    {
        return ['cur-n-resize', 'cursor:n-resize'];
    }

    /**
     * Set element cursor to nw-resize.
     */

    protected function cur_nw_resize()
    {
        return ['cur-nw-resize', 'cursor:nw-resize'];
    }

    /**
     * Set element cursor to nwse-resize.
     */

    protected function cur_nwse_resize()
    {
        return ['cur-nwse-resize', 'cursor:nwse-resize'];
    }

    /**
     * Set element cursor to no-drop.
     */

    protected function cur_no_drop()
    {
        return ['cur-no-drop', 'cursor:no-drop'];
    }

    /**
     * Set element cursor to no-allowed.
     */

    protected function cur_not_allowed()
    {
        return ['cur-not-allowed', 'cursor:not-allowed'];       
    }

    /**
     * Set element cursor to s-resize.
     */

    protected function cur_s_resize()
    {
        return ['cur-s-resize', 'cursor:s-resize'];       
    }

    /**
     * Set element cursor to se-resize.
     */

    protected function cur_se_resize()
    {
        return ['cur-se-resize', 'cursor:se-resize'];
    }
    
    /**
     * Set element cursor to sw-resize.
     */

    protected function cur_sw_resize()
    {
        return ['cur-sw-resize', 'cursor:sw-resize'];
    }

    /**
     * Set element cursor to vertical-text.
     */

    protected function cur_vertical_text()
    {
        return ['cur-vertical-text', 'cursor:vertical-text'];       
    }

    /**
     * Set element cursor to w-resize.
     */

    protected function cur_w_resize()
    {
        return ['cur-w-resize', 'cursor:w-resize'];
    }

    /**
     * Set element cursor to zoom-in.
     */

    protected function cur_zoom_in()
    {
        return ['cur-zoom-in', 'cursor:zoom-in'];
    }

    /**
     * Set element cursor to zoom-out.
     */

    protected function cur_zoom_out()
    {
        return ['cur-zoom-out', 'cursor:zoom-out'];
    }

    /**
     * Remove border.
     */

    protected function brd_none()
    {
        return ['brd-none', 'border:0px'];
    }

    /**
     * Set element border-width.
     */

    protected function brd_width(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-width-' . $width, 'border-width:' . $width];
        }
    }

    /**
     * Set element horizontal border-width.
     */

    protected function brd_x_width(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-x-width-' . $width, 'border-right-width:' . $width . ';border-left-width:' . $width];
        }
    }

    /**
     * Set element vertical border-width.
     */

    protected function brd_y_width(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-y-width-' . $width, 'border-top:' . $width . 'px;border-bottom:' . $width . 'px'];
        }
    }

    /**
     * Set element top border width.
     */

    protected function brd_t_width(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-width-' . $width, 'border-top-width:' . $width];
        }
    }

    /**
     * Set element bottom border width.
     */

    protected function brd_b_width(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-width-' . $width, 'border-bottom-width:' . $width];
        }
    }   

    /**
     * Set element left border width.
     */

    protected function brd_l_width(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-width-' . $width, 'border-left-width:' . $width];
        }
    }

    /**
     * Set element right border width.
     */

    protected function brd_r_width(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-width' . $width, 'border-right-width:' . $width];
        }
    }

    /**
     * Set element border color.
     */

    protected function brd_color(string $color)
    {
        if(in_array($color, $this->colors) || $this->isHex($color))
        {
            return ['brd-color-' . $color, 'border-color:' . $color];
        }
        else if($this->isSchemeColor($color))
        {
            return ['brd-color-' . $color, 'border-color:' . $this->getBorderColor($color)];
        }
    }

    /**
     * Set element horizontal border-color.
     */

    protected function brd_x_color(string $color)
    {
        if(in_array($color, $this->colors) || $this->isHex($color))
        {
            return ['brd-x-color-' . $color, 'border-left-color:' . $color . ';border-right-color:' . $color];
        }
        else if($this->isSchemeColor($color))
        {
            return ['brd-x-color-' . $color, 'border-left-color:' . $this->getBorderColor($color) . ';border-right-color:' . $this->getBorderColor($color)];
        }
    }

    /**
     * Set element vertical border-color.
     */

    protected function brd_y_color(string $color)
    {
        if(in_array($color, $this->colors) || $this->isHex($color))
        {
            return ['brd-y-color-' . $color, 'border-top-color:' . $color . ';border-bottom-color:' . $color];
        }
        else if($this->isSchemeColor($color))
        {
            return ['brd-y-color-' . $color, 'border-top-color:' . $this->getBorderColor($color) . ';border-bottom-color:' . $this->getBorderColor($color)];
        }
    }

    /**
     * Set element left border-color.
     */

    protected function brd_l_color(string $color)
    {
        if(in_array($color, $this->colors) || $this->isHex($color))
        {
            return ['brd-l-color-' . $color, 'border-left-color:' . $color];
        }
        else if($this->isSchemeColor($color))
        {
            return ['brd-l-color-' . $color, 'border-left-color:' . $this->getBorderColor($color)];
        }
    } 

    /**
     * Set element right border-color.
     */

    protected function brd_r_color(string $color)
    {
        if(in_array($color, $this->colors) || $this->isHex($color))
        {
            return ['brd-r-color-' . $color, 'border-right-color:' . $color];
        }
        else if($this->isSchemeColor($color))
        {
            return ['brd-r-color-' . $color, 'border-right-color:' . $this->getBorderColor($color)];
        }
    }

    /**
     * Set element top border-color.
     */

    protected function brd_t_color(string $color)
    {
        if(in_array($color, $this->colors) || $this->isHex($color))
        {
            return ['brd-t-color-' . $color, 'border-top-color:' . $color];
        }
        else if($this->isSchemeColor($color))
        {
            return ['brd-t-color-' . $color, 'border-top-color:' . $this->getBorderColor($color)];
        }
    }

    /**
     * Set element bottom border-color.
     */

    protected function brd_b_color(string $color)
    {
        if(in_array($color, $this->colors) || $this->isHex($color))
        {
            return ['brd-b-color' . $color, 'border-bottom-color:' . $color];
        }
        else if($this->isSchemeColor($color))
        {
            return ['brd-b-color-' . $color, 'border-bottom-color:' . $this->getBorderColor($color)];
        }
    }

    /**
     * Set element border-style.
     */

    protected function brd_style(string $style)
    {
        if($this->isBorderStyle($style))
        {
            return ['brd-style-' . $style, 'border-style:' . $style];
        }
    }

    /**
     * Set element horizontal border-style.
     */

    protected function brd_x_style(string $style)
    {
        if($this->isBorderStyle($style))
        {
            return ['brd-x-style-' . $style, 'border-left-style:' . $style . ';border-right-style:' . $style];
        }
    }

    /**
     * Set element vertical border-style.
     */

    protected function brd_y_style(string $style)
    {
        if($this->isBorderStyle($style))
        {
            return ['brd-y-style-' . $style, 'border-top-style:' . $style . ';border-bottom-style:' . $style];    
        }
    }

    /**
     * Set element top border-style.
     */

    protected function brd_t_style(string $style)
    {
        if($this->isBorderStyle($style))
        {
            return ['brd-t-style-' . $style, 'border-top-style:' . $style];
        }
    }

    /**
     * Set element bottom border-style.
     */

    protected function brd_b_style(string $style)
    {
        if($this->isBorderStyle($style))
        {
            return ['brd-b-style-' . $style, 'border-bottom-style:' . $style];           
        }
    }

    /**
     * Set element left border-style.
     */

    protected function brd_l_style(string $style)
    {
        if($this->isBorderStyle($style))
        {
            return ['brd-l-style-' . $style, 'border-left-style:' . $style];           
        }
    }

    /**
     * Set element right border-style.
     */

    protected function brd_r_style(string $style)
    {
        if($this->isBorderStyle($style))
        {
            return ['brd-r-style-' . $style, 'border-right-style:' . $style];           
        }
    }   

    /**
     * Set element border-collapse.
     */

    protected function brd_collapse(string $collapse)
    {
        if(in_array($collapse, $this->border_collapse))
        {
            return ['brd-collapse-' . $collapse, 'border-collapse:' . $collapse];
        }
    }

    /**
     * Set element border-spacing.
     */

    protected function brd_spacing(string $spacing)
    {
        if(in_array($spacing, [
            'initial',
            'inherit',
        ]) || $this->isPX($spacing))
        {
            return ['brd-spacing-' . $spacing, 'border-spacing:' . $spacing];
        }
    }

    /**
     * Set element border width and style to solid.
     */

    protected function brd_solid(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-solid-' . $width, 'border-style:solid;border-width:' . $width];
        }
    }

    /**
     * Set element left border width and style to solid.
     */

    protected function brd_l_solid(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-solid-' . $width, 'border-left-style:solid;border-left-width:' . $width];
        }
    }

    /**
     * Set element right border width and style to solid.
     */

    protected function brd_r_solid(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-solid-' . $width, 'border-right-style:solid;border-right-width:' . $width];
        }
    }

    /**
     * Set element top border width and style to solid.
     */

    protected function brd_t_solid(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-solid-' . $width, 'border-top-style:solid;border-top-width:' . $width];
        }
    }

    /**
     * Set element bottom border width and style to solid.
     */

    protected function brd_b_solid(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-solid-' . $width, 'border-bottom-style:solid;border-bottom-width:' . $width];
        }
    }

    /**
     * Set element border width and style to dotted.
     */

    protected function brd_dotted(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-dotted-' . $width, 'border-style:dotted;border-width:' . $width];
        }
    }

    /**
     * Set element left border width and style to dotted. 
     */

    protected function brd_l_dotted(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-dotted-' . $width, 'border-left-style:dotted;border-left-width:' . $width];
        }
    }

    /**
     * Set element right border width and style to dotted.
     */

    protected function brd_r_dotted(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-dotted-' . $width, 'border-right-style:dotted;border-right-width:' . $width];
        }
    }

    /**
     * Set element top border width and style to dotted.
     */

    protected function brd_t_dotted(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-dotted-' . $width, 'border-top-style:dotted;border-top-width:' . $width];
        }
    }   

    /**
     * Set element bottom border width and style to dotted.
     */

    protected function brd_b_dotted(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-dotted-' . $width, 'border-bottom-style:dotted;border-bottom-width:' . $width];
        }
    }

    /**
     * Set element border width and style to dashed.
     */

    protected function brd_dashed(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-dashed-' . $width, 'border-style:dashed;border-width:' . $width];
        }
    }

    /**
     * Set element left width and style to dashed.
     */

    protected function brd_l_dashed(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-dashed-' . $width, 'border-left-style:dashed;border-left-width:' . $width];
        }
    }

    /**
     * Set element right width and style to dashed.
     */

    protected function brd_r_dashed(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-dashed-' . $width, 'border-right-style:dashed;border-right-width:' . $width];
        }       
    }

    /**
     * Set element top width and style to dashed.
     */

    protected function brd_t_dashed(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-dashed-' . $width, 'border-top-style:dashed;border-top-width:' . $width];
        }
    }

    /**
     * Set element bottom width and style to dashed.
     */

    protected function brd_b_dashed(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-dashed-' . $width, 'border-bottom-style:dashed;border-bottom-width:' . $width];
        }
    }

    /**
     * Set element border width and style to double.
     */

    protected function brd_double(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-double-' . $width, 'border-style:double;border-width:' . $width];
        }
    }

    /**
     * Set element left border width and style to double.
     */

    protected function brd_l_double(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-double-' . $width, 'border-left-style:double;border-left-width:' . $width];
        }
    }

    /**
     * Set element right border width and style to double.
     */

    protected function brd_r_double(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-double-' . $width, 'border-right-style:double;border-right-width:' . $width];           
        }
    }

    /**
     * Set element top border width and style to double.
     */

    protected function brd_t_double(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-double-' . $width, 'border-top-style:double;border-top-width:' . $width];
        }
    }

    /**
     * Set element bottom border width and style to double.
     */

    protected function brd_b_double(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-double-' . $width, 'border-bottom-style:double;border-bottom-width:' . $width];
        }
    }

    /**
     * Set element border width and style to groove.
     */

    protected function brd_groove(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-groove-' . $width, 'border-style:groove;border-width:' . $width];
        }
    }

    /**
     * Set element left border width and style to groove.
     */

    protected function brd_l_groove(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-groove-' . $width, 'border-left-style:groove;border-left-width:' . $width];           
        }
    }

    /**
     * Set element right border width and style to groove.
     */

    protected function brd_r_groove(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-groove-' . $width, 'border-right-style:groove;border-right-width:' . $width];
        }
    }

    /**
     * Set element top border width and style to groove.
     */

    protected function brd_t_groove(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-groove-' . $width, 'border-top-style:groove;border-top-width:' . $width];
        }
    }

    /**
     * Set element bottom border width and style to groove.
     */

    protected function brd_b_groove(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-groove-' . $width, 'border-bottom-style:groove;border-bottom-width:' . $width];
        }
    }

    /**
     * Set element border width and style to ridge.
     */

    protected function brd_ridge(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-ridge-' . $width, 'border-style:ridge;border-width:' . $width];
        }
    }

    /**
     * Set element left border width and style to ridge.
     */

    protected function brd_l_ridge(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-ridge-' . $width, 'border-left-style:ridge;border-left-width:' . $width];
        }
    }

    /**
     * Set element right border width and style to ridge.
     */

    protected function brd_r_ridge(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-ridge-' . $width, 'border-right-style:ridge;border-right-width:' . $width];
        }
    }

    /**
     * Set element top border width and style to ridge.
     */

    protected function brd_t_ridge(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-ridge-' . $width, 'border-top-style:ridge;border-top-width:' . $width];
        }
    }

    /**
     * Set element bottom border width and style to ridge.
     */

    protected function brd_b_ridge(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-ridge-' . $width, 'border-bottom-style:ridge;border-bottom-width:' . $width];
        }
    }

    /**
     * Set element border width and style to inset.
     */

    protected function brd_inset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-inset-' . $width, 'border-style:inset;border-width:' . $width];
        }
    }

    /**
     * Set element left border width and style to inset.
     */

    protected function brd_l_inset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-inset-' . $width, 'border-left-style:inset;border-left-width:' . $width];
        }
    }

    /**
     * Set element right border width and style to inset.
     */

    protected function brd_r_inset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-inset-' . $width, 'border-right-style:inset;border-right-width:' . $width];
        }
    }

    /**
     * Set element top border width and style to inset.
     */

    protected function brd_t_inset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-inset-' . $width, 'border-top-style:inset;border-top-width:' . $width];
        }
    }

    /**
     * Set element bottom border width and style to inset.
     */

    protected function brd_b_inset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-inset-' . $width, 'border-bottom-style:inset;border-bottom-width:' . $width];           
        }
    }

    /**
     * Set element border width and style to outset.
     */

    protected function brd_outset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-outset-' . $width, 'border-style:outset;border-width:' . $width];
        }
    }

    /**
     * Set element left border width and style to outset.
     */

    protected function brd_l_outset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-outset-' . $width, 'border-left-style:outset;border-left-width:' . $width];
        }
    }

    /**
     * Set element right border width and style to outset.
     */

    protected function brd_r_outset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-outset-' . $width, 'border-right-style:outset;border-right-width:'  . $width];           
        }
    }

    /**
     * Set element top border width and style to outset.
     */

    protected function brd_t_outset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-outset-' . $width, 'border-top-style:outset;border-top-width:' . $width];
        }
    }
    
    /**
     * Set element bottom border width and style to outset.
     */

    protected function brd_b_outset(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-outset-' . $width, 'border-bottom-style:outset;border-bottom-width:' . $width];
        }
    }
    
    /**
     * Set element border width and style inherited from parent.
     */

    protected function brd_inherit(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-inherit-' . $width, 'border-style:inherit;border-width:' . $width];
        }
    }

    /**
     * Set element left border width and style to inherit.
     */

    protected function brd_l_inherit(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-l-inherit-' . $width, 'border-left-style:inherit;border-left-width:' . $width];           
        }
    }

    /**
     * Set element right border width and style to inherit.
     */

    protected function brd_r_inherit(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-r-inherit-' . $width, 'border-right-style:inherit;border-right-width:' . $width];
        }
    }

    /**
     * Set element top border width and style to inherit.
     */

    protected function brd_t_inherit(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-t-inherit-' . $width, 'border-top-style:inherit;border-top-width:' . $width];
        }
    }   

    /**
     * Set element bottom border width and style to inherit.
     */

    protected function brd_b_inherit(string $width)
    {
        if($this->validBorderWidth($width))
        {
            return ['brd-b-inherit-' . $width, 'border-bottom-style:inherit;border-bottom-width:' . $width];
        }
    }

    /**
     * Set element border radius.
     */

    protected function brd_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['brd-radius-' . $name, '-webkit-border-radius:' . $radius . ';-moz-border-radius:' . $radius . ';border-radius:' . $radius];
        }
    }

    /**
     * Set element top border radius.
     */

    protected function brd_t_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['brd-t-radius-' . $name, '-webkit-border-top-left-radius:' . $radius . ';-webkit-border-top-right-radius:' . $radius . ';-moz-border-radius-topleft:' . $radius . ';-moz-border-radius-topright:' . $radius . ';border-top-left-radius:' . $radius . ';border-top-right-radius:' . $radius];
        }
    }

    /**
     * Set element bottom border radius.
     */

    protected function brd_b_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['brd-b-radius-' . $name, '-webkit-border-bottom-right-radius:' . $radius . ';-webkit-border-bottom-left-radius:' . $radius . ';-moz-border-radius-bottomright:' . $radius . ';-moz-border-radius-bottomleft:' . $radius . ';border-bottom-right-radius:' . $radius . ';border-bottom-left-radius:' . $radius];
        }
    }

    /**
     * Set element left border radius.
     */

    protected function brd_l_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['brd-l-radius-' . $name, '-webkit-border-top-left-radius:' . $radius . ';-webkit-border-bottom-left-radius:' . $radius . ';-moz-border-radius-topleft:' . $radius . ';-moz-border-radius-bottomleft:' . $radius . ';border-top-left-radius:' . $radius . ';border-bottom-left-radius:' . $radius];
        }
    }

    /**
     * Set element right border radius.
     */

    protected function brd_r_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['brd-r-radius-' . $radius, '-webkit-border-top-right-radius:' . $radius . ';-webkit-border-bottom-right-radius:' . $radius . ';-moz-border-radius-topright:' . $radius . ';-moz-border-radius-bottomright:' . $radius . ';border-top-right-radius:' . $radius . ';border-bottom-right-radius:' . $radius];
        }
    }   

    /**
     * Set element top left border radius.
     */

    protected function border_t_l_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['border-top-left-radius-' . $name, '-webkit-border-top-left-radius:' . $radius . ';-moz-border-radius-topleft:' . $radius . ';border-top-left-radius:' . $radius];
        }
    }

    /**
     * Set element bottom left border radius. 
     */

    protected function brd_b_l_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['brd-b-l-radius-' . $name, '-webkit-border-bottom-left-radius:' . $radius . ';-moz-border-radius-bottomleft:' . $radius . ';border-bottom-left-radius:' . $radius];
        }       
    }

    /**
     * Set element top right border radius.
     */

    protected function brd_t_r_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['brd-t-r-radius-' . $name, '-webkit-border-top-right-radius:' . $radius . ';-moz-border-radius-topright:' . $radius . ';border-top-right-radius:' . $radius];
        }
    }   

    /**
     * Set element bottom right border radius.
     */

    protected function brd_b_r_radius(string $radius)
    {
        $name = $radius;
        if(strtolower($radius) === 'none')
        {
            $radius = '0px';
        }

        if($this->isPX($radius))
        {
            return ['brd-b-r-radius-' . $name, '-webkit-border-bottom-right-radius:' . $radius . ';-moz-border-radius-bottomright:' . $radius . ';border-bottom-right-radius:' . $radius];
        }
    }   

    /**
     * Element opacity.
     */

    protected function opa(string $opacity)
    {
        if(is_numeric($opacity))
        {
            $n = (int)$opacity;

            if($n >= 0 && $n <= 100)
            {
                $div = $n / 100.00;
                
                return ['opa-' . $opacity, 'opacity:' . $div];
            }
        }
        else if(in_array($opacity, [
            'initial',
            'inherit',
        ]))
        {
            return ['opa-' . $opacity, 'opacity:' . $opacity];
        }
    }

    /**
     * Element outline.
     */

    protected function outline(string $outline)
    {
        if(in_array($outline, [
            'none',
            'initial',
            'inherit',
        ]))
        {
            return ['outline-' . $outline, 'outline:' . $outline];
        }
    }

    /**
     * Element outline color.
     */

    protected function outline_color(string $color)
    {
        if(in_array($color, [
            'invert',
            'initial',
            'inherit',
        ]))
        {
            return ['outl-color-' . $color, 'outline-color:' . $color];
        }
        else if($this->isSchemeColor($color))
        {
            $rgb = $this->toRGB($color);
            return ['outline-color-' . $color, 'outline-color:rgb(' . $rgb['R'] . ',' . $rgb['G'] . ',' . $rgb['B'] . ')'];
        }
    }

    /**
     * Element outline offset.
     */

    protected function outline_offset(string $offset)
    {
        if($this->isPX($offset) || in_array($offset, [
            'initial',
            'inherit',
        ]))
        {
            return ['outline-offset-' . $offset, 'outline-offset:' . $offset];
        }
    }

    /**
     * Element outline style.
     */

    protected function outline_style(string $style)
    {
        if(in_array($style, $this->border_style))
        {
            return ['outline-style-' . $style, 'outline-style:' . $style];           
        }
    }

    /**
     * Element outline width.
     */

    protected function outline_width(string $width)
    {
        if($this->isPX($width) || in_array($width, $this->border_width))
        {
            return ['outline-width-' . $width, 'outline-width:' . $width];
        }       
    }

}