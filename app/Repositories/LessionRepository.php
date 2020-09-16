<?php

namespace App\Repositories;

use App\Models\Lession;
use Exception;
use Illuminate\Support\Facades\Auth;

class LessionRepository extends EloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Lession::class;
    }

    public function attachLesionLatest($course, $lesion)
    {
        // them thong tin video duoc xem moi nhat
        try {
            if (!$lesion->users()->get()->contains(Auth::user())) {
                $lesion->users()->attach(Auth::id(), [
                    'course' => $course->id
                ]);
            }
            return true;
        } catch (Exception $exception) {
            logger($exception);
        }
        return false;
    }


}
