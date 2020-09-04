<?php

declare(strict_types=1);

namespace App\Http\Requests\SubjectGroup;

use App\Http\Requests\Request;
use App\Repositories\SubjectGroupRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\Rule;

class StoreRequest extends Request
{
    private SubjectGroupRepository $subjectGroupRepository;

    /**
     * @throws BindingResolutionException
     */
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->subjectGroupRepository = app()->make(SubjectGroupRepository::class);
    }

    public function rules(): array
    {
        return [
            'caption' => [
                'required',
                'string',
                Rule::unique(
                    $this->subjectGroupRepository->getModelInstance()->getTable(),
                    'caption'
                ),
            ],
        ];
    }
}
