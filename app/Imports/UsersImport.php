<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Hod;
use App\Models\Warden;
use App\Models\Department;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersImport implements ToCollection, WithHeadingRow
{
    protected $userType;
    protected $results = [];

    public function __construct($userType)
    {
        $this->userType = $userType;
    }

    public function collection(Collection $rows)
    {
        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            try {
                $rowIndex = $index + 2; // +2 because of header and 0-based index
                
                // Skip empty rows
                if (empty($row['name']) || empty($row['username'])) {
                    continue;
                }

                // Create user
                $userData = [
                    'name' => $row['name'],
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'password' => Hash::make($row['password'] ?? 'password'),
                    'role' => $this->mapRoleToEnum($this->userType),
                    'phone' => $row['phone'] ?? null,
                    'gender' => $row['gender'] ?? null,
                    'college_id' => $row['college_id'] ?? null,
                    'is_active' => 1,
                ];

                // Check for unique constraints
                if (User::where('username', $row['username'])->exists()) {
                    $errors[] = "Row {$rowIndex}: Username '{$row['username']}' already exists";
                    $errorCount++;
                    continue;
                }

                if (User::where('email', $row['email'])->exists()) {
                    $errors[] = "Row {$rowIndex}: Email '{$row['email']}' already exists";
                    $errorCount++;
                    continue;
                }

                $user = User::create($userData);

                // Create role-specific data
                switch ($this->userType) {
                    case 'student':
                        $this->createStudent($user, $row, $rowIndex);
                        break;
                    case 'staff':
                        $this->createStaff($user, $row, $rowIndex);
                        break;
                    case 'hod':
                        $this->createHod($user, $row, $rowIndex);
                        break;
                    case 'warden':
                        $this->createWarden($user, $row, $rowIndex);
                        break;
                }

                $successCount++;

            } catch (\Exception $e) {
                $errors[] = "Row {$rowIndex}: " . $e->getMessage();
                $errorCount++;
                Log::error("Bulk upload error at row {$rowIndex}: " . $e->getMessage());
            }
        }

        $this->results = [
            'success' => $successCount,
            'errors' => $errorCount,
            'error_details' => $errors,
        ];
    }

    private function createStudent($user, $row, $rowIndex)
    {
        // Validate department exists
        if (!empty($row['department_id'])) {
            if (!Department::where('id', $row['department_id'])->exists()) {
                throw new \Exception("Department ID {$row['department_id']} does not exist");
            }
        }

        // Check for unique register number
        if (!empty($row['register_number'])) {
            if (Student::where('register_number', $row['register_number'])->exists()) {
                throw new \Exception("Register number '{$row['register_number']}' already exists");
            }
        }

        Student::create([
            'user_id' => $user->id,
            'college_id' => $row['college_id'] ?? null,
            'department_id' => $row['department_id'] ?? null,
            'register_number' => $row['register_number'] ?? null,
            'semester' => $row['semester'] ?? null,
            'section' => $row['section'] ?? null,
            'hosteller' => $row['hosteller'] ?? 'no',
            'parent_name' => $row['parent_name'] ?? null,
            'parent_phone' => $row['parent_phone'] ?? null,
            'address' => $row['address'] ?? null,
            'class_id' => $row['class_id'] ?? null,
        ]);
    }

    private function createStaff($user, $row, $rowIndex)
    {
        // Validate department exists
        if (!empty($row['department_id'])) {
            if (!Department::where('id', $row['department_id'])->exists()) {
                throw new \Exception("Department ID {$row['department_id']} does not exist");
            }
        }

        // Check for unique employee ID
        if (!empty($row['employee_id'])) {
            if (Staff::where('employee_id', $row['employee_id'])->exists()) {
                throw new \Exception("Employee ID '{$row['employee_id']}' already exists");
            }
        }

        Staff::create([
            'user_id' => $user->id,
            'college_id' => $row['college_id'] ?? null,
            'department_id' => $row['department_id'] ?? null,
            'employee_id' => $row['employee_id'] ?? null,
            'designation' => $row['designation'] ?? null,
            'type' => $row['type'] ?? 'teaching',
            'qualifications' => $row['qualifications'] ?? null,
            'joining_date' => $row['joining_date'] ?? now(),
            'is_class_incharge_a' => $row['is_class_incharge_a'] ?? 0,
            'is_class_incharge_b' => $row['is_class_incharge_b'] ?? 0,
            'is_class_incharge_2nd_a' => $row['is_class_incharge_2nd_a'] ?? 0,
            'is_class_incharge_2nd_b' => $row['is_class_incharge_2nd_b'] ?? 0,
        ]);
    }

    private function createHod($user, $row, $rowIndex)
    {
        // Validate department exists
        if (!empty($row['department_id'])) {
            if (!Department::where('id', $row['department_id'])->exists()) {
                throw new \Exception("Department ID {$row['department_id']} does not exist");
            }
        }

        // Check for unique employee ID
        if (!empty($row['employee_id'])) {
            if (Hod::where('employee_id', $row['employee_id'])->exists()) {
                throw new \Exception("Employee ID '{$row['employee_id']}' already exists");
            }
        }

        Hod::create([
            'user_id' => $user->id,
            'college_id' => $row['college_id'] ?? null,
            'department_id' => $row['department_id'] ?? null,
            'employee_id' => $row['employee_id'] ?? null,
            'qualifications' => $row['qualifications'] ?? null,
            'appointment_date' => $row['appointment_date'] ?? now(),
            'class_id_1st_a' => $row['class_id_1st_a'] ?? null,
            'class_id_1st_b' => $row['class_id_1st_b'] ?? null,
            'class_id_2nd_a' => $row['class_id_2nd_a'] ?? null,
            'class_id_2nd_b' => $row['class_id_2nd_b'] ?? null,
        ]);
    }

    private function createWarden($user, $row, $rowIndex)
    {
        // Check for unique employee ID
        if (!empty($row['employee_id'])) {
            if (Warden::where('employee_id', $row['employee_id'])->exists()) {
                throw new \Exception("Employee ID '{$row['employee_id']}' already exists");
            }
        }

        Warden::create([
            'user_id' => $user->id,
            'college_id' => $row['college_id'] ?? null,
            'employee_id' => $row['employee_id'] ?? null,
            'hostel_type' => $row['hostel_type'] ?? 'boys',
            'appointment_date' => $row['appointment_date'] ?? now(),
        ]);
    }

    private function mapRoleToEnum($userType)
    {
        // Convert plural form to singular enum values
        $roleMapping = [
            'students' => 'student',
            'staff' => 'staff',
            'hods' => 'hod',
            'wardens' => 'warden',
            'admins' => 'admin'
        ];

        return $roleMapping[$userType] ?? $userType;
    }

    public function getResults()
    {
        return $this->results;
    }
}
