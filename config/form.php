<?php

namespace Rasmus\Validation {

    /**
     * DEFAULT TEXT VALIDATION
     * -----------------------------------------------
     * Only requires unempty field.
     */

    Form::text();

    /**
     * DEFAULT NUMBER VALIDATION
     * -----------------------------------------------
     * Accepts all positive or negative integers. 
     */

    Form::number()
        ->numeric(true)
    ;

    /**
     * DEFAULT BOOLEAN VALIDATION
     * ----------------------------------------------- 
     * Accepts 0 for off value and 1 for on value.
     */

    Form::boolean()
        ->numeric(true)
        ->maxLength(1)
        ->minValue(0)
        ->maxValue(1)
    ;

    /**
     * EMAIL VALIDATION
     * -----------------------------------------------
     * You can add more email service provider in endWith
     * property to accept other email extensions.
     */

    Form::email()
        ->maxLength(320)
        ->maxWord(1)
        ->maxLine(1)
        ->endWith(['yahoo.com', 'gmail.com'])
        ->pattern('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/')
    ;

    /**
     * USERNAME VALIDATION
     * ----------------------------------------------- 
     * Common username configuration.
     */

    Form::username()
        ->minLength(6)
        ->maxLength(24)
        ->maxWord(1)
        ->maxLine(1)
        ->maxSpecialCharacters(0)
    ;

    /**
     * PASSWORD VALIDATION
     * ----------------------------------------------- 
     * You can set the minimum letters and numbers to
     * -1 to disable requiring minimum number of specific
     * characters in password or you can just delete it. 
     */

    Form::password()
        ->minLength(8)
        ->maxLength(31)
        ->maxWord(1)
        ->maxLine(1)
        ->maxSpecialCharacters(0)
        ->minLetter(4)
        ->minNumber(2)
        ->minUppercase(2)
        ->minLowercase(2)
        ->mustNot(['password'])
    ;

    /**
     * MOBILE NUMBER
     * ----------------------------------------------- 
     * We provided a basic mobile number configuration
     * of the philippines but you can configure based
     * on your country.
     */

    Form::mobile()
        ->maxLine(1)
        ->maxWord(1)
        ->maxSpecialCharacters(1)
        ->maxLetter(0)
        ->startWith(['+639'])
    ;

    /**
     * ZIPCODE VALIDATION
     * -----------------------------------------------
     * Accept zipcodes with 4 or 5 digit values. 
     */

    Form::zipcode()
        ->numeric(true)    
        ->minValue(1000)
        ->maxValue(99999)
    ;

    /**
     * MONTH VALIDATION
     * -----------------------------------------------
     * Month with numeric values. 
     */

    Form::month()
        ->numeric(true)
        ->minValue(1)
        ->maxValue(12)    
    ;

    /**
     * DAY VALIDATION
     * -----------------------------------------------
     * Basic day numeric values. 
     */

    Form::day()
        ->numeric(true)
        ->minValue(1)
        ->maxValue(31)    
    ;

    /**
     * YEAR VALIDATION
     * ----------------------------------------------- 
     */

    Form::year()
        ->numeric(true)
        ->minValue(1920)
        ->maxValue((int)date('Y'))
    ;    

    /**
     * COMMON NAME VALIDATION
     * -----------------------------------------------
     * You can still configure your own name configuration.
     */

    Form::name()
        ->maxLength(255)
        ->maxWord(4)
        ->maxLine(1)
        ->maxNumber(0)
        ->prohibit(['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '=', '{', '}', '[', ']', ':', ';', '"', '\'', '<', ',', '>', '.', '?', '/'])
    ;   

}