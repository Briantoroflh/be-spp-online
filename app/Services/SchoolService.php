<?php

namespace App\Services;

use App\Repositories\SchoolRepository;

class SchoolService
{
    private $schoolRepository;

    public function __construct(SchoolRepository $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;
    }

    // ================================
    // Super Admin
    // ================================

    public function getAll(array $fields = ['*'])
    {
        return $this->schoolRepository->getAll($fields);
    }

    public function getByUuid(string $uuid, array $fields = ['*'])
    {
        return $this->schoolRepository->getByUuid($uuid, $fields);
    }

    public function filterByRegionForSuperAdmin(string $region, array $fields = ['*'])
    {
        return $this->schoolRepository->filterByRegionForSuperAdmin($region, $fields);
    }

    public function filterByCityForSuperAdmin(string $city, array $fields = ['*'])
    {
        return $this->schoolRepository->filterByCityForSuperAdmin($city, $fields);
    }

    public function filterByTypeSchoolForSuperAdmin(string $typeSchool, array $fields = ['*'])
    {
        return $this->schoolRepository->filterByTypeSchoolForSuperAdmin($typeSchool, $fields);
    }

    public function updateSchoolIsVerified(string $uuid)
    {
        return $this->schoolRepository->updateSchoollIsVerified($uuid);
    }

    // ================================
    // School Admin / User
    // ================================

    public function create(array $data)
    {
        return $this->schoolRepository->create($data);
    }

    public function update(string $uuid, array $data)
    {
        return $this->schoolRepository->update($uuid, $data);
    }

    public function delete(string $uuid)
    {
        return $this->schoolRepository->delete($uuid);
    }
}
