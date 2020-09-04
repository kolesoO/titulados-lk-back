<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\SubjectGroup\StoreRequest;
use App\Repositories\SubjectGroupRepository;
use App\Resources\SubjectGroupResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectGroupController
{
    private SubjectGroupRepository $subjectGroupRepository;

    public function __construct(SubjectGroupRepository $subjectGroupRepository)
    {
        $this->subjectGroupRepository = $subjectGroupRepository;
    }

    public function index(Request $request): JsonResponse
    {
        return SubjectGroupResource::collection(
            $this->subjectGroupRepository->all()
        )
            ->response($request);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $entity = $this->subjectGroupRepository->createModel(
            $request->all()
        );
        $this->subjectGroupRepository->save($entity);

        return SubjectGroupResource::make($entity)
            ->response($request);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function show(string $groupId, Request $request): JsonResponse
    {
        $group = $this->subjectGroupRepository->getById((int) $groupId);

        return SubjectGroupResource::make($group)
            ->response($request);
    }
}
