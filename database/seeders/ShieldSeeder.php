<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $tenants = '[]';
        $users = '[]';
        $userTenantPivot = '[]';
        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["ViewAny:Role","View:Role","Create:Role","Update:Role","Delete:Role","DeleteAny:Role","Restore:Role","ForceDelete:Role","ForceDeleteAny:Role","RestoreAny:Role","Replicate:Role","Reorder:Role","AccessPanelWhenLicenseExpired","ViewAny:Category","View:Category","Create:Category","Update:Category","Delete:Category","DeleteAny:Category","Restore:Category","ForceDelete:Category","ForceDeleteAny:Category","RestoreAny:Category","Replicate:Category","Reorder:Category","ViewAny:Contact","View:Contact","Create:Contact","Update:Contact","Delete:Contact","DeleteAny:Contact","Restore:Contact","ForceDelete:Contact","ForceDeleteAny:Contact","RestoreAny:Contact","Replicate:Contact","Reorder:Contact","ViewAny:Event","View:Event","Create:Event","Update:Event","Delete:Event","DeleteAny:Event","Restore:Event","ForceDelete:Event","ForceDeleteAny:Event","RestoreAny:Event","Replicate:Event","Reorder:Event","ViewAny:Member","View:Member","Create:Member","Update:Member","Delete:Member","DeleteAny:Member","Restore:Member","ForceDelete:Member","ForceDeleteAny:Member","RestoreAny:Member","Replicate:Member","Reorder:Member","Approve:Member","CancelSubscription:Member","ChangeSubscription:Member","RenewSubscription:Member","RenewCanceledSubscription:Member","SubscribeSubscription:Member","DeclarePaymentReceivedSubscription:Member","ViewAny:MenuItem","View:MenuItem","Create:MenuItem","Update:MenuItem","Delete:MenuItem","DeleteAny:MenuItem","Restore:MenuItem","ForceDelete:MenuItem","ForceDeleteAny:MenuItem","RestoreAny:MenuItem","Replicate:MenuItem","Reorder:MenuItem","ViewAny:Menu","View:Menu","Create:Menu","Update:Menu","Delete:Menu","DeleteAny:Menu","Restore:Menu","ForceDelete:Menu","ForceDeleteAny:Menu","RestoreAny:Menu","Replicate:Menu","Reorder:Menu","ViewAny:Plan","View:Plan","Create:Plan","Update:Plan","Delete:Plan","DeleteAny:Plan","Restore:Plan","ForceDelete:Plan","ForceDeleteAny:Plan","RestoreAny:Plan","Replicate:Plan","Reorder:Plan","ViewAny:Post","View:Post","Create:Post","Update:Post","Delete:Post","DeleteAny:Post","Restore:Post","ForceDelete:Post","ForceDeleteAny:Post","RestoreAny:Post","Replicate:Post","Reorder:Post","ViewAny:Subscription","View:Subscription","Create:Subscription","Update:Subscription","Delete:Subscription","DeleteAny:Subscription","Restore:Subscription","ForceDelete:Subscription","ForceDeleteAny:Subscription","RestoreAny:Subscription","Replicate:Subscription","Reorder:Subscription","ViewAny:User","View:User","Create:User","Update:User","Delete:User","DeleteAny:User","Restore:User","ForceDelete:User","ForceDeleteAny:User","RestoreAny:User","Replicate:User","Reorder:User","UpdateCustomPermission:User","InviteUser:User","RenewPassword:User","ChangeActive:User","ViewAny:Email","View:Email","Create:Email","Update:Email","Delete:Email","DeleteAny:Email","Restore:Email","ForceDelete:Email","ForceDeleteAny:Email","RestoreAny:Email","Replicate:Email","Reorder:Email","View:Backups","View:Communication","View:ManageGeneralSettings","View:ManageLicence","View:ManageSectionsSettings","View:MyCompany","View:MySubscription","View:PageContactSettings","View:PageDirectorySettings","View:PageEventSettings","View:PageFormMemberPublicSettings","View:PageHomeSettings","View:PageLegalSettings","View:PagePolicySettings","View:PagePostSettings","View:Support","View:CustomFilamentInfoWidget","View:CheckLicence"]},{"name":"admin","guard_name":"web","permissions":["ViewAny:Category","View:Category","Create:Category","Update:Category","Restore:Category","RestoreAny:Category","Replicate:Category","Reorder:Category","ViewAny:Contact","View:Contact","Create:Contact","Update:Contact","Delete:Contact","DeleteAny:Contact","Restore:Contact","ForceDelete:Contact","ForceDeleteAny:Contact","RestoreAny:Contact","Replicate:Contact","Reorder:Contact","ViewAny:Event","View:Event","Create:Event","Update:Event","Delete:Event","DeleteAny:Event","Restore:Event","ForceDelete:Event","ForceDeleteAny:Event","RestoreAny:Event","Replicate:Event","Reorder:Event","ViewAny:Member","View:Member","Create:Member","Update:Member","Delete:Member","DeleteAny:Member","Restore:Member","ForceDelete:Member","ForceDeleteAny:Member","RestoreAny:Member","Replicate:Member","Reorder:Member","Approve:Member","CancelSubscription:Member","ChangeSubscription:Member","RenewSubscription:Member","RenewCanceledSubscription:Member","SubscribeSubscription:Member","DeclarePaymentReceivedSubscription:Member","ViewAny:Post","View:Post","Create:Post","Update:Post","Delete:Post","DeleteAny:Post","Restore:Post","ForceDelete:Post","ForceDeleteAny:Post","RestoreAny:Post","Replicate:Post","Reorder:Post","View:Communication","View:ManageGeneralSettings","View:ManageSectionsSettings","View:PageContactSettings","View:PageDirectorySettings","View:PageEventSettings","View:PageHomeSettings","View:PageLegalSettings","View:PagePolicySettings","View:PagePostSettings","View:Support","View:CheckLicence"]},{"name":"member","guard_name":"web","permissions":["AccessPanelWhenLicenseExpired","View:MyCompany","View:MySubscription","View:Support"]}]';
        $directPermissions = '[]';

        // 1. Seed tenants first (if present)
        if (! blank($tenants) && $tenants !== '[]') {
            static::seedTenants($tenants);
        }

        // 2. Seed roles with permissions
        static::makeRolesWithPermissions($rolesWithPermissions);

        // 3. Seed direct permissions
        static::makeDirectPermissions($directPermissions);

        // 4. Seed users with their roles/permissions (if present)
        if (! blank($users) && $users !== '[]') {
            static::seedUsers($users);
        }

        // 5. Seed user-tenant pivot (if present)
        if (! blank($userTenantPivot) && $userTenantPivot !== '[]') {
            static::seedUserTenantPivot($userTenantPivot);
        }

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function seedTenants(string $tenants): void
    {
        if (blank($tenantData = json_decode($tenants, true))) {
            return;
        }

        $tenantModel = '';
        if (blank($tenantModel)) {
            return;
        }

        foreach ($tenantData as $tenant) {
            $tenantModel::firstOrCreate(
                ['id' => $tenant['id']],
                $tenant
            );
        }
    }

    protected static function seedUsers(string $users): void
    {
        if (blank($userData = json_decode($users, true))) {
            return;
        }

        $userModel = 'App\Models\User';
        $tenancyEnabled = false;

        foreach ($userData as $data) {
            // Extract role/permission data before creating user
            $roles = $data['roles'] ?? [];
            $permissions = $data['permissions'] ?? [];
            $tenantRoles = $data['tenant_roles'] ?? [];
            $tenantPermissions = $data['tenant_permissions'] ?? [];
            unset($data['roles'], $data['permissions'], $data['tenant_roles'], $data['tenant_permissions']);

            $user = $userModel::firstOrCreate(
                ['email' => $data['email']],
                $data
            );

            // Handle tenancy mode - sync roles/permissions per tenant
            if ($tenancyEnabled && (! empty($tenantRoles) || ! empty($tenantPermissions))) {
                foreach ($tenantRoles as $tenantId => $roleNames) {
                    $contextId = $tenantId === '_global' ? null : $tenantId;
                    setPermissionsTeamId($contextId);
                    $user->syncRoles($roleNames);
                }

                foreach ($tenantPermissions as $tenantId => $permissionNames) {
                    $contextId = $tenantId === '_global' ? null : $tenantId;
                    setPermissionsTeamId($contextId);
                    $user->syncPermissions($permissionNames);
                }
            } else {
                // Non-tenancy mode
                if (! empty($roles)) {
                    $user->syncRoles($roles);
                }

                if (! empty($permissions)) {
                    $user->syncPermissions($permissions);
                }
            }
        }
    }

    protected static function seedUserTenantPivot(string $pivot): void
    {
        if (blank($pivotData = json_decode($pivot, true))) {
            return;
        }

        $pivotTable = '';
        if (blank($pivotTable)) {
            return;
        }

        foreach ($pivotData as $row) {
            $uniqueKeys = [];

            if (isset($row['user_id'])) {
                $uniqueKeys['user_id'] = $row['user_id'];
            }

            $tenantForeignKey = 'team_id';
            if (! blank($tenantForeignKey) && isset($row[$tenantForeignKey])) {
                $uniqueKeys[$tenantForeignKey] = $row[$tenantForeignKey];
            }

            if (! empty($uniqueKeys)) {
                DB::table($pivotTable)->updateOrInsert($uniqueKeys, $row);
            }
        }
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            return;
        }

        /** @var \Illuminate\Database\Eloquent\Model $roleModel */
        $roleModel = Utils::getRoleModel();
        /** @var \Illuminate\Database\Eloquent\Model $permissionModel */
        $permissionModel = Utils::getPermissionModel();

        $tenancyEnabled = false;
        $teamForeignKey = 'team_id';

        foreach ($rolePlusPermissions as $rolePlusPermission) {
            $tenantId = $rolePlusPermission[$teamForeignKey] ?? null;

            // Set tenant context for role creation and permission sync
            if ($tenancyEnabled) {
                setPermissionsTeamId($tenantId);
            }

            $roleData = [
                'name' => $rolePlusPermission['name'],
                'guard_name' => $rolePlusPermission['guard_name'],
            ];

            // Include tenant ID in role data (can be null for global roles)
            if ($tenancyEnabled && ! blank($teamForeignKey)) {
                $roleData[$teamForeignKey] = $tenantId;
            }

            $role = $roleModel::firstOrCreate($roleData);

            if (! blank($rolePlusPermission['permissions'])) {
                $permissionModels = collect($rolePlusPermission['permissions'])
                    ->map(fn ($permission) => $permissionModel::firstOrCreate([
                        'name' => $permission,
                        'guard_name' => $rolePlusPermission['guard_name'],
                    ]))
                    ->all();

                $role->syncPermissions($permissionModels);
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (blank($permissions = json_decode($directPermissions, true))) {
            return;
        }

        /** @var \Illuminate\Database\Eloquent\Model $permissionModel */
        $permissionModel = Utils::getPermissionModel();

        foreach ($permissions as $permission) {
            if ($permissionModel::whereName($permission['name'])->doesntExist()) {
                $permissionModel::create([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ]);
            }
        }
    }
}
