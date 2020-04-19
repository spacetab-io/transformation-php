<?php

declare(strict_types=1);

namespace Spacetab\Tests\Transformation;

use PHPUnit\Framework\TestCase;
use Spacetab\Transformation\DefaultTransformation;
use Spacetab\Transformation\ErrorTransformation;
use Spacetab\Transformation\PaginateTransformation;
use Spacetab\Transformation\PaginationViewInterface;
use Spacetab\Transformation\ValidationError;
use Spacetab\Transformation\ValidationTransformation;

class TransformationTest extends TestCase
{
    public function testDefaultTransformation()
    {
        $transform = new DefaultTransformation([1, 2, 3]);

        $this->assertSame(['data' => [1, 2, 3]], $transform->doTransform());
    }

    public function testErrorTransformation()
    {
        $transform = new ErrorTransformation('Message');

        $truth = [
            'error' => [
                'message' => 'Message',
                'code' => ErrorTransformation::DEFAULT_ERROR_CODE,
            ]
        ];

        $this->assertSame($truth, $transform->doTransform());

        $transform = new ErrorTransformation(null);
        $truth['error']['message'] = ErrorTransformation::ERROR_OCCURRED_IN_APP;

        $this->assertSame($truth, $transform->doTransform());
    }

    public function testPaginateTransformation()
    {
        $paginate = $this->createMock(PaginationViewInterface::class);
        $paginate->expects($this->once())
            ->method('getItems')
            ->willReturn([1, 2, 3]);

        $paginate->expects($this->once())
            ->method('getCount')
            ->willReturn(3);

        $paginate->expects($this->once())
            ->method('getPerPage')
            ->willReturn(1);

        $paginate->expects($this->once())
            ->method('getPage')
            ->willReturn(1);

        $paginate->expects($this->once())
            ->method('getTotal')
            ->willReturn(3);

        $paginate->expects($this->once())
            ->method('getNext')
            ->willReturn(null);

        $paginate->expects($this->once())
            ->method('getPrev')
            ->willReturn(null);

        $transform = new PaginateTransformation($paginate);

        $truth = [
            'data' => [1, 2, 3],
            'meta' => [
                'pagination' => [
                    'total' => 3,
                    'per_page' => 1,
                    'current_page' => 1,
                    'total_pages' => 3,
                    'prev_page' => null,
                    'next_page' => null,
                ]
            ]
        ];

        $this->assertSame($truth, $transform->doTransform());
    }

    public function testValidationTransformation()
    {
        $error = new ValidationError();
        $error->addError('user.first_name', 'Minimal length allowed is 2 symbols.');
        $error->addError('user.first_name', 'Must be like regular expression /[a-zA-Z]+/.');

        $transform = new ValidationTransformation($error);

        $truth = [
            'error' => [
                'message' => ValidationTransformation::VALIDATION_MESSAGE,
                'code' => ValidationTransformation::VALIDATION_CODE,
                'validation' => [
                    'user.first_name' => [
                        'Minimal length allowed is 2 symbols.',
                        'Must be like regular expression /[a-zA-Z]+/.',
                    ]
                ],
            ]
        ];

        $this->assertSame($truth, $transform->doTransform());

        $transform = new ValidationTransformation($error, 'Custom message');
        $truth['error']['message'] = 'Custom message';

        $this->assertSame($truth, $transform->doTransform());

        $error->clean();
        $this->assertSame([], $error->getErrors());
    }
}
