<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\AppExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('isActive', [$this, 'getActiveClass']),
        ];
    }

    public function getActiveClass($currentCategoryId, $categoryId): string
    {
        return (int) $currentCategoryId === $categoryId ? 'active' : '';
    }
}
