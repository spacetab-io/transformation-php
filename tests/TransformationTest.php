<?php

declare(strict_types=1);

namespace Spacetab\Tests\Transformation;

use PHPUnit\Framework\TestCase;
use Spacetab\Transformation\Defaults;
use Spacetab\Transformation\Misc\ErrorTransformer;
use Spacetab\Transformation\Paginate;
use Spacetab\Transformation\Misc\PaginationViewInterface;
use Spacetab\Transformation\Misc\ValidationError;
use Spacetab\Transformation\Misc\Validation;

class TransformationTest extends TestCase
{
    public function testDefaultTransformation()
    {
        $transform = new Defaults([1, 2, 3]);

        $this->assertSame(['data' => [1, 2, 3]], $transform->doTransform());
    }

    public function testErrorTransformation()
    {
        $transform = new \Spacetab\Transformation\Misc\ErrorTransformer('Message');

        $truth = [
            'error' => [
                'message' => 'Message',
                'code' => \Spacetab\Transformation\Misc\ErrorTransformer::DEFAULT_ERROR_CODE,
            ]
        ];

        $this->assertSame($truth, $transform->doTransform());

        $transform = new \Spacetab\Transformation\Misc\ErrorTransformer(null);
        $truth['error']['message'] = \Spacetab\Transformation\Misc\ErrorTransformer::ERROR_OCCURRED_IN_APP;

        $this->assertSame($truth, $transform->doTransform());
    }

    public function testPaginateTransformation()
    {
        $paginate = $this->createMock(\Spacetab\Transformation\Misc\PaginationViewInterface::class);
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

        $transform = new Paginate($paginate);

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

        $transform = new Validation($error);

        $truth = [
            'error' => [
                'message' => Validation::VALIDATION_MESSAGE,
                'code' => \Spacetab\Transformation\Misc\Validation::VALIDATION_CODE,
                'validation' => [
                    'user.first_name' => [
                        'Minimal length allowed is 2 symbols.',
                        'Must be like regular expression /[a-zA-Z]+/.',
                    ]
                ],
            ]
        ];

        $this->assertSame($truth, $transform->doTransform());

        $transform = new Validation($error, 'Custom message');
        $truth['error']['message'] = 'Custom message';

        $this->assertSame($truth, $transform->doTransform());

        $error->clean();
        $this->assertSame([], $error->getErrors());
    }
}
