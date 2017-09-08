<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.08.2017
 * Time: 19:38
 */

namespace App\Services;


use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostService
{
    private $postRepository;

    /**
     * PostService constructor.
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * publish new post
     *
     * @param array $data
     * @return Post
     */
    public function publish(array $data):Post
    {
        return $this->postRepository->store($data);
    }

    public function storePreview(UploadedFile $preview):string
    {
        $filePath = Storage::putFile(config('upload.preview'), $preview);
        $path_parts = pathinfo($filePath);

        return $path_parts['filename'].'.'.$path_parts['extension'];
    }
}