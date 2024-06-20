<?php

namespace App\Http\Transformers;


use App\Models\Role;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Phattarachai\ThaiDate\ThaiDate;

class RoleTransformer extends TransformerAbstract
{
    protected array $availableIncludes = ['images'];

    public function transform(Role $role): array
    {
        $medias = $role->getMedia(Role::MEDIA_COLLECTION_IMAGE);
        $data = [
            'id' => $role->id,
            'name' => $role->name,
        ];
        return $data;
    }

    public function includeImages(Role $role)
    {
        $images = $role->getMedia(Role::MEDIA_COLLECTION_IMAGE);
        return $this->collection($images, new RoleImageTransformer());
    }
}
