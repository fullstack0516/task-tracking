<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasBadge
{
    abstract public function getInitialsIdentifier(): string;

    public function getInitialsAttribute(): string
    {
        $letters = Str::of($this->getInitialsIdentifier())
            ->explode(' ')
            ->map(fn ($word) => $word[0]);

        $filteredLetters = $letters->filter(fn ($letter) => preg_match('/[A-Z]/', $letter));

        return $filteredLetters->count() > 1
            ? $filteredLetters->take(2)->join('')
            : $letters->join('');
    }

    public function getColourBrightnessAttribute(): int
    {
        // Luminosity Contrast Ratio Algorithm
        $hexColour = $this->colour;

        if (strlen(substr($hexColour, 1)) === 3) {
            $hexColour = $hexColour.substr($hexColour, 1);
        }

        $r1 = hexdec(substr($hexColour, 1, 2));
        $g1 = hexdec(substr($hexColour, 3, 2));
        $b1 = hexdec(substr($hexColour, 5, 2));

        // Black RGB
        $blackColor = '#000000';
        $r2c = hexdec(substr($blackColor, 1, 2));
        $g2c = hexdec(substr($blackColor, 3, 2));
        $b2c = hexdec(substr($blackColor, 5, 2));

        // Calculate contrast ratio
        $l1 = 0.2126 * pow($r1 / 255, 2.2) + 0.7152 * pow($g1 / 255, 2.2) + 0.0722 * pow($b1 / 255, 2.2);
        $l2 = 0.2126 * pow($r2c / 255, 2.2) + 0.7152 * pow($g2c / 255, 2.2) + 0.0722 * pow($b2c / 255, 2.2);

        $contrastRatio = 0;

        if ($l1 > $l2) {
            $contrastRatio = (int) (($l1 + 0.05) / ($l2 + 0.05));
        } else {
            $contrastRatio = (int) (($l2 + 0.05) / ($l1 + 0.05));
        }

        return $contrastRatio;
    }
}
