<?php

namespace App\Repositories;

use App\Models\School;

class SchoolRepository
{
    // Super Admin
    public function getAll(array $fields)
    {
        return School::select($fields)->latest()->with(['user'])->paginate(10);
    }

    public function getByUuid(string $uuid, array $fields){
        return School::select($fields)
        ->with('student')
        ->withCount('student')
        ->where('uuid', $uuid)
        ->paginate(10);
    }

    public function filterByRegionForSuperAdmin(string $region, array $fields) {
        return School::select($fields)
        ->when($region, fn($q) => $q->where('region', $region))
        ->withCount('student')
        ->orderBy('name')
        ->paginate(10);
    }

    public function filterByCityForSuperAdmin(string $city, array $fields)
    {
        return School::select($fields)
            ->when($city, fn($q) => $q->where('region', $city))
            ->withCount('student')
            ->orderBy('name')
            ->paginate(10);
    }

    public function filterByTypeSchoolForSuperAdmin(string $typeSchool, array $fields)
    {
        return School::select($fields)
            ->when($typeSchool, fn($q) => $q->where('region', $typeSchool))
            ->withCount('student')
            ->orderBy('name')
            ->paginate(10);
    }

    public function updateSchoollIsVerified(string $uuid)
    {
        $school = School::findOrFail($uuid);
        $school->update(['isVerified' => true]);
        return $school;
    }

    // User / School Admin & Super Admin
    public function create(array $data) {
        return School::create($data);
    }

    public function update(string $uuid, array $data){
        $school = School::findOrFail($uuid);
        $school->update($data);
        return $school;
    }

    public function delete(string $uuid) {
        $school = School::findOrFail($uuid);
        $school->delete();
    }
    
}
