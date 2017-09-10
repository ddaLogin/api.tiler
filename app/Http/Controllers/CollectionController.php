<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCollectionRequest;
use App\Interfaces\CollectionRepositoryInterface;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CollectionController extends Controller
{
    private $collectionRepository;

    /**
     * CollectionController constructor.
     * @param CollectionRepositoryInterface $collectionRepository
     */
    public function __construct(CollectionRepositoryInterface $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * @SWG\Post(
     *   path="/users/{user_id}/collections",
     *   summary="Create new collection",
     *   tags={"Collections"},
     *   produces={"application/json"},
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter( name="user_id", description="User id", required=true, type="string", in="path"),
     *   @SWG\Parameter( name="name", description="Collection's name", required=true, type="string", in="query"),
     *   @SWG\Response( response=201, description="Success create new collection"),
     *   @SWG\Response( response=403, description="Access denied"),
     *   @SWG\Response( response=422, description="Validation errors"),
     *   security={{"jwt_auth":{}}},
     * )
     * @param CreateCollectionRequest $createCollectionRequest
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateCollectionRequest $createCollectionRequest, User $user)
    {
        if (JWTAuth::parseToken()->authenticate()->id != $user->id){
            throw new AccessDeniedHttpException();
        }

        $data = $createCollectionRequest->all();
        $data['user_id'] = $user->id;
        $collection = $this->collectionRepository->store($data);

        return response()->json($collection->toArray(), 201);
    }
}
