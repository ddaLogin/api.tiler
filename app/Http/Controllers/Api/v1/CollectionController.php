<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CreateCollectionRequest;
use App\Interfaces\CollectionRepositoryInterface;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CollectionController extends ApiController
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
     *   security={{"passport":{}}},
     * )
     * @param CreateCollectionRequest $createCollectionRequest
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateCollectionRequest $createCollectionRequest, User $user)
    {
        if (Auth::id() != $user->id){
            throw new AccessDeniedHttpException();
        }

        $data = $createCollectionRequest->all();
        $data['user_id'] = $user->id;
        $collection = $this->collectionRepository->store($data);

        return response()->json($collection->toArray(), 201);
    }

    /**
     * @SWG\Get(
     *   path="/users/{user_id}/collections",
     *   summary="Get user's collections",
     *   tags={"Collections"},
     *   produces={"application/json"},
     *   @SWG\Parameter( name="user_id", description="User id", required=true, type="string", in="path"),
     *   @SWG\Response( response=200, description="Success get post detail"),
     * )
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function byUser(User $user)
    {
        $collections = $this->collectionRepository->byUser($user->id);

        return response()->json($collections->toArray(), 200);
    }

    /**
     * @SWG\Put(
     *   path="/users/{user_id}/collections/{collection_id}",
     *   summary="Update collection",
     *   tags={"Collections"},
     *   produces={"application/json"},
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter( name="user_id", description="Collection owner", required=true, type="string", in="path"),
     *   @SWG\Parameter( name="collection_id", description="Collection id", required=true, type="string", in="path"),
     *   @SWG\Parameter( name="name", description="New collection's name", required=true, type="string", in="query"),
     *   @SWG\Response( response=200, description="Success update collection"),
     *   @SWG\Response( response=403, description="Access denied"),
     *   @SWG\Response( response=422, description="Validation errors"),
     *   security={{"passport":{}}},
     * )
     * @param CreateCollectionRequest $createCollectionRequest
     * @param User $user
     * @param Collection $collection
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateCollectionRequest $createCollectionRequest, User $user, Collection $collection)
    {
        if (Auth::id() != $user->id || $collection->user_id != $user->id){
            throw new AccessDeniedHttpException();
        }

        $data = $createCollectionRequest->all();
        $data['user_id'] = $user->id;
        $collection = $this->collectionRepository->store($data, $collection->id);

        return response()->json($collection->toArray(), 200);
    }
}
