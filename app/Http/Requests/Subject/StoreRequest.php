<?php

declare(strict_types=1);

namespace App\Http\Requests\Subject;

use App\Http\Requests\Request;
use App\Repositories\SubjectRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\Rule;

class StoreRequest extends Request
{
    private SubjectRepository $subjectRepository;

    /**
     * @throws BindingResolutionException
     */
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->subjectRepository = app()->make(SubjectRepository::class);
    }

    public function rules(): array
    {
        return [
            'caption' => [
                'required',
                'string',
                Rule::unique(
                    $this->subjectRepository->getModelInstance()->getTable(),
                    'caption'
                )
            ],
        ];
    }
}
