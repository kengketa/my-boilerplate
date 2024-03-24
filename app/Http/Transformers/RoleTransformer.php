<?php

namespace App\Http\Transformers;


use App\Models\Role;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Phattarachai\ThaiDate\ThaiDate;

class RoleTransformer extends TransformerAbstract
{
    protected array $availableIncludes = ['image'];

    public function transform(Role $role): array
    {
        $medias = $role->getMedia(Role::MEDIA_COLLECTION_IMAGE);
        $data = [
            'id' => $role->id,
            'name' => $role->name,
            'image' => $medias[0]->getFullUrl()
        ];
        return $data;
    }

//    public function includeDocuments(Announcement $announcement)
//    {
//        $documents = $announcement->getMedia(Announcement::MEDIA_COLLECTION_DOCUMENTS);
//        return $this->collection($documents, new AnnouncementDocumentTransformer());
//    }
}
