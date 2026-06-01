<?php

namespace Database\Seeders;

use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the Roles we created in RoleAndPermissionSeeder
        $supervisorRole = Role::where('name', 'Supervisor')->first();
        $managerRole = Role::where('name', 'Manager')->first();

        // 1. Workflow: Pengajuan Cuti
        $cuti = Workflow::firstOrCreate(
            ['name' => 'Pengajuan Cuti'],
            ['description' => 'Alur pengajuan cuti tahunan atau cuti khusus pegawai.']
        );

        WorkflowStep::firstOrCreate(
            [
                'workflow_id' => $cuti->id,
                'role_id' => $supervisorRole->id,
                'order' => 1,
            ]
        );

        WorkflowStep::firstOrCreate(
            [
                'workflow_id' => $cuti->id,
                'role_id' => $managerRole->id,
                'order' => 2,
            ]
        );

        // 2. Workflow: Pengadaan Barang
        $pengadaan = Workflow::firstOrCreate(
            ['name' => 'Pengadaan Barang'],
            ['description' => 'Alur pengajuan pembelian barang operasional kantor.']
        );

        WorkflowStep::firstOrCreate(
            [
                'workflow_id' => $pengadaan->id,
                'role_id' => $supervisorRole->id,
                'order' => 1,
            ]
        );

        WorkflowStep::firstOrCreate(
            [
                'workflow_id' => $pengadaan->id,
                'role_id' => $managerRole->id,
                'order' => 2,
            ]
        );
    }
}
