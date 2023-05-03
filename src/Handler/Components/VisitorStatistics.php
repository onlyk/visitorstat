<?php
declare(strict_types=1);

namespace App\Handler\Components;


final class VisitorStatistics
{
    public function __construct(
        /**
         * @param array<string, int> $statistics
         */
        public array $statistics
    ) {}
}