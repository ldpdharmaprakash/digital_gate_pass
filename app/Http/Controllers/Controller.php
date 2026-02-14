<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get current authenticated user's college ID
     */
    protected function getCurrentCollegeId()
    {
        return Auth::user()->college_id;
    }

    /**
     * Apply college scope to query
     */
    protected function applyCollegeScope($query)
    {
        return $query->where('college_id', $this->getCurrentCollegeId());
    }

    /**
     * Get current authenticated user's college
     */
    protected function getCurrentCollege()
    {
        return Auth::user()->college;
    }
}
