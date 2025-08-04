<?php
namespace src\core\repositories;

use src\core\entities\Person;
use src\core\repositories\requests\PersonSearchRequest;

interface PersonsRepositoryInterface
{
    public function find(PersonSearchRequest $request): ?Person;
    /**
     * @return Person[]
     */
    public function list(PersonSearchRequest $request): array;
    public function create(Person $person): void;
    public function update(Person $person): void;
    public function delete(string $id): void;
}
