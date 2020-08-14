<?php

/**
 * COLOR SCHEME
 * -----------------------------------------------
 * Use aliases to globally access color schemes. 
 * You can add your own color aliases below.
 */

namespace Raccoon\UI {

    Scheme::id('default')->set(function() {

        Color::id('primary')
            ->default(33, 150, 243)
            ->hover(43, 160, 253)
            ->active(33, 140, 233);

        Color::id('secondary')
            ->default(255, 255, 255)
            ->hover(255, 255, 255)
            ->active(255, 255, 255);
        
        Color::id('dark')
            ->default(255, 255, 255)
            ->hover(255, 255, 255)
            ->active(255, 255, 255);

        Color::id('light')
            ->default(255, 255, 255)
            ->hover(255, 255, 255)
            ->active(255, 255, 255);

        Color::id('success')
            ->default(76, 175, 80)
            ->hover(86, 185, 90)
            ->active(66, 165, 70);

        Color::id('info')
            ->default(255, 255, 255)
            ->hover(255, 255, 255)
            ->active(255, 255, 255);

        Color::id('warning')
            ->default(255, 255, 255)
            ->hover(255, 255, 255)
            ->active(255, 255, 255);

        Color::id('error')
            ->default(255, 82, 82)
            ->hover(255, 102, 102)
            ->active(245, 72, 72);

    });

}