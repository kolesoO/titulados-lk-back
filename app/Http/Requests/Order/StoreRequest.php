<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

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
            'deadline' => 'required|string',
            'name' => 'required|string',
            'subject_id' => [
                'required',
                Rule::exists(
                    $this->subjectRepository->getModelInstance()->getTable(),
                    'id'
                ),
            ],
            'course' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'attachment' => 'max:5',
            'attachment.*' => 'max:3024',
        ];
    }
}
