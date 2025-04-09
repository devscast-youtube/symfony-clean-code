<?php

namespace Classroom\StudentManagement\Domain\Model\Repository;

use Classroom\SharedContext\Domain\Model\ValueObject\Email;
use Classroom\StudentManagement\Domain\Model\Entity\Student;

interface StudentRepository
{
    public function add(Student $student): void;

    public function remove(Student $student): void;

    public function getById(int $studentId): Student;

    public function getByEmail(Email $email): ?Student;
}
