<?php

if (!function_exists('renderStars')) {
    function renderStars($averageRating) {
        $output = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= floor($averageRating)) {
                $output .= '<i class="fa fa-star" style="color: gold;"></i>';
            } elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5) {
                $output .= '<i class="fa fa-star-half-alt" style="color: gold;"></i>';
            } else {
                $output .= '<i class="fa fa-star-o" style="color: gold;"></i>';
            }
        }
        return $output;
    }
}
