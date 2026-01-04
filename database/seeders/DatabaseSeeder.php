<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Hod;
use App\Models\Warden;
use App\Models\Gatepass;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Departments
        $departments = [
            ['name' => 'Computer Science and Engineering', 'code' => 'CSE', 'head_name' => 'Dr. Ramesh Kumar'],
            ['name' => 'Electronics and Communication Engineering', 'code' => 'ECE', 'head_name' => 'Dr. Priya Sharma'],
            ['name' => 'Mechanical Engineering', 'code' => 'MECH', 'head_name' => 'Dr. Anand Patel'],
            ['name' => 'Civil Engineering', 'code' => 'CIVIL', 'head_name' => 'Dr. Sunita Reddy'],
            ['name' => 'Electrical and Electronics Engineering', 'code' => 'EEE', 'head_name' => 'Dr. Vijay Kumar'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Create Admin User
        $admin = User::create([
            'name' => 'System Administrator',
            'username' => 'admin',
            'email' => 'admin@college.edu',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '9876543210',
            'is_active' => true,
        ]);

        // Create HOD Users
        $hodUsers = [];
        foreach (Department::all() as $dept) {
            $hodUser = User::create([
                'name' => $dept->head_name,
                'username' => 'hod_' . strtolower($dept->code),
                'email' => 'hod.' . strtolower($dept->code) . '@college.edu',
                'password' => Hash::make('password'),
                'role' => 'hod',
                'phone' => '987654321' . $dept->id,
                'is_active' => true,
            ]);

            Hod::create([
                'user_id' => $hodUser->id,
                'department_id' => $dept->id,
                'employee_id' => 'HOD' . str_pad($dept->id, 4, '0', STR_PAD_LEFT),
                'appointment_date' => now()->subYears(2),
            ]);

            $hodUsers[$dept->id] = $hodUser;
        }

        // Create Warden User
        $wardenUser = User::create([
            'name' => 'Dr. Satish Kumar',
            'username' => 'warden_boys',
            'email' => 'warden.boys@college.edu',
            'password' => Hash::make('password'),
            'role' => 'warden',
            'phone' => '9876543220',
            'is_active' => true,
        ]);

        Warden::create([
            'user_id' => $wardenUser->id,
            'employee_id' => 'WRD0001',
            'hostel_type' => 'boys',
            'appointment_date' => now()->subYears(1),
        ]);

        // Create Staff Users
        $staffUsers = [];
        foreach (Department::all() as $dept) {
            for ($i = 1; $i <= 3; $i++) {
                $staffUser = User::create([
                    'name' => 'Staff ' . $i . ' - ' . $dept->name,
                    'username' => 'staff_' . strtolower($dept->code) . '_' . $i,
                    'email' => 'staff.' . strtolower($dept->code) . '.' . $i . '@college.edu',
                    'password' => Hash::make('password'),
                    'role' => 'staff',
                    'phone' => '987654323' . $dept->id . $i,
                    'is_active' => true,
                ]);

                Staff::create([
                    'user_id' => $staffUser->id,
                    'department_id' => $dept->id,
                    'employee_id' => 'STF' . str_pad($dept->id * 100 + $i, 6, '0', STR_PAD_LEFT),
                    'designation' => $i == 1 ? 'Senior Lecturer' : 'Lecturer',
                    'type' => 'teaching',
                    'joining_date' => now()->subMonths(rand(6, 24)),
                ]);

                $staffUsers[$dept->id][] = $staffUser;
            }
        }

        // Create Student Users
        $studentUsers = [];
        foreach (Department::all() as $dept) {
            for ($i = 1; $i <= 10; $i++) {
                $isHosteller = $i <= 4; // First 4 students are hostellers
                $studentUser = User::create([
                    'name' => 'Student ' . $i . ' - ' . $dept->name,
                    'username' => 'student_' . strtolower($dept->code) . '_' . $i,
                    'email' => 'student.' . strtolower($dept->code) . '.' . $i . '@college.edu',
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'phone' => '987654324' . $dept->id . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'is_active' => true,
                ]);

                $student = Student::create([
                    'user_id' => $studentUser->id,
                    'department_id' => $dept->id,
                    'register_number' => strtoupper($dept->code) . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'semester' => rand(1, 8),
                    'section' => chr(65 + ($i % 3)), // A, B, C
                    'hosteller' => $isHosteller ? 'yes' : 'no',
                    'parent_name' => 'Parent of Student ' . $i,
                    'parent_phone' => '987654325' . $dept->id . str_pad($i, 2, '0', STR_PAD_LEFT),
                ]);

                $studentUsers[] = $student;

                // Create some sample gatepasses for each student
                $this->createSampleGatepasses($student);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Login Credentials:');
        $this->command->info('Admin: admin@college.edu / password');
        $this->command->info('HODs: hod.{department}@college.edu / password');
        $this->command->info('Staff: staff.{department}.{1-3}@college.edu / password');
        $this->command->info('Students: student.{department}.{1-10}@college.edu / password');
        $this->command->info('Warden: warden.boys@college.edu / password');
    }

    private function createSampleGatepasses($student)
    {
        $statuses = ['pending', 'staff_approved', 'hod_approved', 'final_approved', 'staff_rejected', 'hod_rejected'];
        $reasons = [
            'Medical appointment',
            'Family function',
            'Personal work',
            'Interview',
            'Competition participation',
            'Project work',
            'Library research',
            'Document submission',
        ];

        // Create 2-5 gatepasses per student
        $numGatepasses = rand(2, 5);
        
        for ($i = 0; $i < $numGatepasses; $i++) {
            $date = now()->subDays(rand(1, 30));
            $status = $statuses[array_rand($statuses)];
            
            // Set approval timestamps based on status
            $staffApprovedAt = null;
            $hodApprovedAt = null;
            $wardenApprovedAt = null;
            $finalApprovedAt = null;
            $staffApprovedBy = null;
            $hodApprovedBy = null;
            $wardenApprovedBy = null;
            $qrCode = null;

            if (in_array($status, ['staff_approved', 'hod_approved', 'final_approved', 'staff_rejected', 'hod_rejected'])) {
                $staffApprovedAt = $date->copy()->addHours(rand(1, 3));
                $staffApprovedBy = User::where('role', 'staff')->whereHas('staff', function($q) use ($student) {
                    $q->where('department_id', $student->department_id);
                })->inRandomOrder()->first()->id;
            }

            if (in_array($status, ['hod_approved', 'final_approved', 'hod_rejected'])) {
                $hodApprovedAt = $staffApprovedAt->copy()->addHours(rand(1, 3));
                $hodApprovedBy = User::where('role', 'hod')->whereHas('hod', function($q) use ($student) {
                    $q->where('department_id', $student->department_id);
                })->first()->id;
            }

            if ($status === 'final_approved' && $student->hosteller === 'yes') {
                $wardenApprovedAt = $hodApprovedAt->copy()->addHours(rand(1, 3));
                $wardenApprovedBy = User::where('role', 'warden')->first()->id;
                $finalApprovedAt = $wardenApprovedAt;
                $qrCode = 'GP-' . strtoupper(uniqid());
            } elseif ($status === 'final_approved') {
                $finalApprovedAt = $hodApprovedAt;
                $qrCode = 'GP-' . strtoupper(uniqid());
            }

            Gatepass::create([
                'student_id' => $student->id,
                'gatepass_date' => $date,
                'out_time' => $date->copy()->setTime(rand(8, 11), rand(0, 59)),
                'in_time' => $date->copy()->setTime(rand(16, 19), rand(0, 59)),
                'reason' => $reasons[array_rand($reasons)],
                'status' => $status,
                'staff_remarks' => in_array($status, ['staff_rejected', 'hod_rejected']) ? 'Remarks from staff' : null,
                'hod_remarks' => $status === 'hod_rejected' ? 'Remarks from HOD' : null,
                'warden_remarks' => $status === 'warden_rejected' ? 'Remarks from Warden' : null,
                'staff_approved_at' => $staffApprovedAt,
                'hod_approved_at' => $hodApprovedAt,
                'warden_approved_at' => $wardenApprovedAt,
                'final_approved_at' => $finalApprovedAt,
                'staff_approved_by' => $staffApprovedBy,
                'hod_approved_by' => $hodApprovedBy,
                'warden_approved_by' => $wardenApprovedBy,
                'qr_code' => $qrCode,
            ]);
        }
    }
}
