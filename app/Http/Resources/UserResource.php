<?php

namespace App\Http\Resources;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $school = School::query()->get()->where('id', $this->school_id);
        return [
            'id' => $this->id,
            'name' => $this->firstName . ' '. $this->lastName,
            'school'=> $school,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
