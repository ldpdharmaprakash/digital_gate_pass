<?php

if (!function_exists('getCurrentCollege')) {
    /**
     * Get current authenticated user's college
     */
    function getCurrentCollege()
    {
        return auth()->user()->college;
    }
}

if (!function_exists('getCurrentCollegeId')) {
    /**
     * Get current authenticated user's college ID
     */
    function getCurrentCollegeId()
    {
        return auth()->user()->college_id;
    }
}

if (!function_exists('getCollegeTheme')) {
    /**
     * Get current college theme colors
     */
    function getCollegeTheme()
    {
        $college = getCurrentCollege();
        return [
            'primary' => $college->primary_color ?? '#3B82F6',
            'secondary' => $college->secondary_color ?? '#8B5CF6',
        ];
    }
}

if (!function_exists('applyCollegeScope')) {
    /**
     * Apply college scope to query
     */
    function applyCollegeScope($query)
    {
        return $query->where('college_id', getCurrentCollegeId());
    }
}
