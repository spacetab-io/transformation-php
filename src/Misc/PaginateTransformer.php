<?php

declare(strict_types=1);

namespace Spacetab\Transformation\Misc;

use Spacetab\Transformation\TransformInterface;

final class PaginateTransformer implements TransformInterface
{
    public const CAMEL_CASE = 0;
    public const SNAKE_CASE = 1;

    private PaginationViewInterface $paginationView;
    private int $style;

    public function __construct(PaginationViewInterface $view, int $style = self::CAMEL_CASE)
    {
        $this->paginationView = $view;
        $this->style = $style;
    }

    public function transform(mixed $value = null): array
    {
        if ($this->style === self::CAMEL_CASE) {
            return [
                'data' => $this->paginationView->getItems(),
                'meta' => [
                    'pagination' => [
                        'total'       => $this->paginationView->getCount(),
                        'perPage'     => $this->paginationView->getPerPage(),
                        'currentPage' => $this->paginationView->getPage(),
                        'totalPages'  => $this->paginationView->getTotal(),
                        'prevPage'    => $this->paginationView->getPrev(),
                        'nextPage'    => $this->paginationView->getNext(),
                    ]
                ]
            ];
        }

        return [
            'data' => $this->paginationView->getItems(),
            'meta' => [
                'pagination' => [
                    'total'        => $this->paginationView->getCount(),
                    'per_page'     => $this->paginationView->getPerPage(),
                    'current_page' => $this->paginationView->getPage(),
                    'total_pages'  => $this->paginationView->getTotal(),
                    'prev_page'    => $this->paginationView->getPrev(),
                    'next_page'    => $this->paginationView->getNext(),
                ]
            ]
        ];
    }
}
