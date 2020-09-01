<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Faculty\CreateRequest;
use App\Repositories\FacultyRepository;
use App\Resources\DefaultResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FacultyController
{
    private FacultyRepository $facultyRepository;

    public function __construct(FacultyRepository $facultyRepository)
    {
        $this->facultyRepository = $facultyRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $result = $request->get('caption', false)
            ? $this->facultyRepository->findByCaption($request->get('caption'))
            : $this->facultyRepository->all();

        return DefaultResource::make($result)
            ->response($request);
    }

    public function store(CreateRequest $request): JsonResponse
    {
        $entity = $this->facultyRepository->findByCaption(
            $request->get('caption')
        );

        if (!is_null($entity)) {
            return new JsonResponse('Такой факультет уже существует', Response::HTTP_CONFLICT);
        }

        $entity = $this->facultyRepository->createModel(
            $request->all()
        );
        $this->facultyRepository->save($entity);

        return DefaultResource::make($entity)
            ->response($request);
    }
}
