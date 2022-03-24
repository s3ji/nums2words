<?php

class NumbersToWords
{
    public function convert($number = null): ?string
    {
        //Up to 99 Trillions are supported
        if ( is_null($number) || $number > 99999999999999 ){
            return null;
        }

        // Round off the given number to 2 decimal places
        $number = number_format($number, 2, ".", "");
        $number = explode(".", $number);

        [$wholeNumber, $decimalNumber] = $number;

        $wholeNumber = round($wholeNumber, 0);
        $decimalNumber = round($decimalNumber, 2);

        if( $wholeNumber && $decimalNumber ){
            return "{$this->toWords($wholeNumber)} DOLLAR(S) AND {$this->toWords(round($decimalNumber, 2))} CENT(S)";
        }

        if( !$wholeNumber ){
            return $decimalNumber ? "{$this->toWords(round($decimalNumber, 2))} CENT(S)" : "ZERO DOLLAR(S)";
        }

        if( !$decimalNumber ){
            return "{$this->toWords($wholeNumber)} DOLLAR(S)";
        }

        return null;
    }

    public function toWords($number = null): ?string
    {
        if ( is_null($number) ){
            return null;
        }

        $forOnes = [
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
            9 => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        ];

        $forTens = [
            20 => "Twenty",
            30 => "Thirty",
            40 => "Forty",
            50 => "Fifty",
            60 => "Sixty",
            70 => "Seventy",
            80 => "Eighty",
            90 => "Ninety"
        ];

        $forPlaces = [
            1000000000000 => "Trillion",
            1000000000 => "Billion",
            1000000 => "Million",
            1000 => "Thousand",
            100 => "Hundred"
        ];

        $result = '';

        // Get results for Ones
        if( $number < 20 ){
            $result = $forOnes[$number];
            return strtoupper($result);
        }

        // Get results for Tens
        if( $number < 100 ){
            $tens = floor($number / 10) * 10;
            $result = $forTens[$tens];
            $result .= ($number % 10) ? "-{$this->toWords($number % 10)}" : '';
            return strtoupper($result);
        }

        // Get results for Hundreds
        if( $number < 1000 ){
            $hundreds = floor($number / 100);
            $result = "$forOnes[$hundreds] $forPlaces[100]";
            $result .= ($number % 100) ? " AND {$this->toWords($number % 100)}" : '';
            return strtoupper($result);
        }

        // Get results for Thousands and above
        if( $number > 1000 ){
            $base = 1000;
            $pow = floor(log($number, $base));
            $power = pow($base, $pow);
            $newNumber = floor($number / $power);
            $result = "{$this->toWords($newNumber)} $forPlaces[$power]";
            $result .= ($number % $power) ? " {$this->toWords($number % $power)}" : '';
            return strtoupper($result);
        }

        if (empty($result)){
            $result = null;
        }

        return strtoupper($result);
    }
}