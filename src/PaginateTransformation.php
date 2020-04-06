<?php

declare(strict_types=1);

namespace Spacetab\Transformation;

final class PaginateTransformation implements TransformationInterface
{
    /**
     * @var \Spacetab\Transformation\PaginationViewInterface
     */
    private PaginationViewInterface $paginationView;

    /**
     * PaginateTransformation constructor.
     *
     * @param \Spacetab\Transformation\PaginationViewInterface $paginationView
     */
    public function __construct(PaginationViewInterface $paginationView)
    {
        $this->paginationView = $paginationView;
    }

    /**
     * @return array
     */
    public function doTransform(): array
    {
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
