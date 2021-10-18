<?php

declare(strict_types=1);

namespace Spacetab\Transformation\Misc;

interface PaginationViewInterface
{
    public function getCount(): int;
    public function getPerPage(): int;
    public function getPage(): int;
    public function getTotal(): int;
    public function getPrev(): ?int;
    public function getNext(): ?int;
}
