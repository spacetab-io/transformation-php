<?php

declare(strict_types=1);

namespace Spacetab\Transformation\Misc;

use Spacetab\Transformation\TransformInterface;
use Spacetab\Transformation\WalkAwareInterface;
use Spacetab\Transformation\WalkAwareTrait;

final class PaginateTransformer implements TransformInterface, WalkAwareInterface
{
    use WalkAwareTrait;

    public const CAMEL_CASE = 0;
    public const SNAKE_CASE = 1;

    private PaginationViewInterface $paginationView;
    private TransformInterface $itemsTransformer;
    private int $style;
    private array $values = [];

    public function __construct(
        PaginationViewInterface $view,
        TransformInterface      $itemsTransformer,
        int                     $style = self::CAMEL_CASE
    ) {
        $this->paginationView = $view;
        $this->itemsTransformer = $itemsTransformer;
        $this->style = $style;
    }

    public function withValues(array $values): void
    {
        $this->values = $values;
    }

    public function transform(mixed $value = null): array
    {
        if ($this->style === self::CAMEL_CASE) {
            $array = [
                'data' => $this->walker->collection($this->itemsTransformer, $value),
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

            return array_merge_recursive($array, $this->values);
        }

        $array = [
            'data' => $this->walker->collection($this->itemsTransformer, $value),
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

        return array_merge_recursive($array, $this->values);
    }
}
