<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.10.2017
 * Time: 20:00
 */

namespace App\Services;


use App\Interfaces\LikeRepositoryInterface;

class LikeService
{
    private $likeRepository;

    /**
     * LikeService constructor.
     * @param LikeRepositoryInterface $likeRepository
     */
    public function __construct(LikeRepositoryInterface $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    /**
     * toggle like status, delete if like status equals
     * @param array $data
     * @return mixed
     */
    public function toggle(array $data)
    {
        $like = $this->likeRepository->getByPostAndUser($data['post_id'], $data['user_id']);

        if($like && $like->status == $data['status']){
            return $this->likeRepository->delete($like->id);
        }
        return $this->likeRepository->store($data, $like);
    }
}