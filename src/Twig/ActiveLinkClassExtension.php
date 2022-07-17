<?php

/*
 * This file is part of the Symfony package.
 * (c) Fabien Potencier <fabien@symfony.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use Symfony\Component\HttpFoundation\Request;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ActiveLinkClassExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_active_route', [$this, 'isActiveRoute']),
        ];
    }

    /**
     * @param array|string|string[] $routeName
     */
    public function isActiveRoute(Request $request, array|string $routeName): bool
    {
        $currentRouteName = $request->attributes->get('_route');

        foreach ((array) $routeName as $route) {
            if ($this->match($currentRouteName, $route)) {
                return true;
            }
        }

        return false;
    }

    private function match(string $currentRoute, string $expectedRoute): bool
    {
        if ('*' === mb_substr($expectedRoute, -1)) {
            return false !== mb_strpos($currentRoute, rtrim($expectedRoute, '*'));
        }

        return $currentRoute === $expectedRoute;
    }
}
