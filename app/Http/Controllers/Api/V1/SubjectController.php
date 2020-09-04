<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Subject\StoreRequest;
use App\Models\SubjectGroup;
use App\Repositories\SubjectGroupRepository;
use App\Repositories\SubjectRepository;
use App\Resources\DefaultResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController
{
    private SubjectRepository $subjectRepository;

    private SubjectGroupRepository $subjectGroupRepository;

    public function __construct(
        SubjectRepository $subjectRepository,
        SubjectGroupRepository $subjectGroupRepository
    ) {
        $this->subjectRepository = $subjectRepository;
        $this->subjectGroupRepository = $subjectGroupRepository;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function index(string $groupId, Request $request): JsonResponse
    {
        /** @var SubjectGroup $group */
        $group = $this->subjectGroupRepository->getById((int) $groupId);

        return DefaultResource::collection(
            $this->subjectRepository->getByGroup($group)
        )
            ->response($request);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function store(string $groupId, StoreRequest $request): JsonResponse
    {
        /** @var SubjectGroup $group */
        $group = $this->subjectGroupRepository->getById((int) $groupId);

        $entity = $this->subjectRepository->createModel(
            $group,
            $request->all()
        );
        $this->subjectRepository->save($entity);

        return DefaultResource::make($entity)
            ->response($request);
    }
}
