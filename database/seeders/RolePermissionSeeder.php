<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Dashboard
            [
                'name' => 'view-dashboard',
                'display_name' => 'View Dashboard',
                'module' => 'Dashboard',
            ],

            // Products
            [
                'name' => 'view-products',
                'display_name' => 'View Products',
                'module' => 'Products',
            ],
            [
                'name' => 'create-products',
                'display_name' => 'Add Product',
                'module' => 'Products',
            ],
            [
                'name' => 'edit-products',
                'display_name' => 'Edit Product',
                'module' => 'Products',
            ],
            [
                'name' => 'delete-products',
                'display_name' => 'Delete Product',
                'module' => 'Products',
            ],

            // Categories
            [
                'name' => 'view-categories',
                'display_name' => 'View Categories',
                'module' => 'Categories',
            ],
            [
                'name' => 'create-categories',
                'display_name' => 'Add Category',
                'module' => 'Categories',
            ],
            [
                'name' => 'edit-categories',
                'display_name' => 'Edit Category',
                'module' => 'Categories',
            ],
            [
                'name' => 'delete-categories',
                'display_name' => 'Delete Category',
                'module' => 'Categories',
            ],

            // Brands
            [
                'name' => 'view-brands',
                'display_name' => 'View Brands',
                'module' => 'Brands',
            ],
            [
                'name' => 'create-brands',
                'display_name' => 'Add Brand',
                'module' => 'Brands',
            ],
            [
                'name' => 'edit-brands',
                'display_name' => 'Edit Brand',
                'module' => 'Brands',
            ],
            [
                'name' => 'delete-brands',
                'display_name' => 'Delete Brand',
                'module' => 'Brands',
            ],

            // Inventory
            [
                'name' => 'view-inventory',
                'display_name' => 'View Inventory',
                'module' => 'Inventory',
            ],
            [
                'name' => 'stock-in',
                'display_name' => 'Stock In',
                'module' => 'Inventory',
            ],
            [
                'name' => 'stock-adjustment',
                'display_name' => 'Stock Adjustment',
                'module' => 'Inventory',
            ],
            [
                'name' => 'view-stock-movements',
                'display_name' => 'View Stock Movements',
                'module' => 'Inventory',
            ],

            // Sales
            [
                'name' => 'view-sales',
                'display_name' => 'View Sales',
                'module' => 'Sales',
            ],
            [
                'name' => 'create-sale',
                'display_name' => 'Create Sale',
                'module' => 'Sales',
            ],
            [
                'name' => 'edit-sale',
                'display_name' => 'Edit Sale',
                'module' => 'Sales',
            ],
            [
                'name' => 'delete-sale',
                'display_name' => 'Delete Sale',
                'module' => 'Sales',
            ],
            [
                'name' => 'print-receipt',
                'display_name' => 'Print Receipt',
                'module' => 'Sales',
            ],

            // Customers
            [
                'name' => 'view-customers',
                'display_name' => 'View Customers',
                'module' => 'Customers',
            ],
            [
                'name' => 'create-customers',
                'display_name' => 'Add Customer',
                'module' => 'Customers',
            ],
            [
                'name' => 'edit-customers',
                'display_name' => 'Edit Customer',
                'module' => 'Customers',
            ],
            [
                'name' => 'delete-customers',
                'display_name' => 'Delete Customer',
                'module' => 'Customers',
            ],

            // Expenses
            [
                'name' => 'view-expenses',
                'display_name' => 'View Expenses',
                'module' => 'Expenses',
            ],
            [
                'name' => 'create-expenses',
                'display_name' => 'Add Expense',
                'module' => 'Expenses',
            ],
            [
                'name' => 'edit-expenses',
                'display_name' => 'Edit Expense',
                'module' => 'Expenses',
            ],
            [
                'name' => 'delete-expenses',
                'display_name' => 'Delete Expense',
                'module' => 'Expenses',
            ],

            // Reports
            [
                'name' => 'view-reports',
                'display_name' => 'View Reports',
                'module' => 'Reports',
            ],
            [
                'name' => 'sales-reports',
                'display_name' => 'Sales Reports',
                'module' => 'Reports',
            ],
            [
                'name' => 'inventory-reports',
                'display_name' => 'Inventory Reports',
                'module' => 'Reports',
            ],
            [
                'name' => 'expense-reports',
                'display_name' => 'Expense Reports',
                'module' => 'Reports',
            ],

            // Users
            [
                'name' => 'view-users',
                'display_name' => 'View Users',
                'module' => 'Users',
            ],
            [
                'name' => 'create-users',
                'display_name' => 'Add User',
                'module' => 'Users',
            ],
            [
                'name' => 'edit-users',
                'display_name' => 'Edit User',
                'module' => 'Users',
            ],
            [
                'name' => 'activate-users',
                'display_name' => 'Activate / Deactivate User',
                'module' => 'Users',
            ],
            [
                'name' => 'change-user-password',
                'display_name' => 'Change User Password',
                'module' => 'Users',
            ],

            // Roles
            [
                'name' => 'view-roles',
                'display_name' => 'View Roles',
                'module' => 'Roles',
            ],
            [
                'name' => 'create-roles',
                'display_name' => 'Add Role',
                'module' => 'Roles',
            ],
            [
                'name' => 'edit-roles',
                'display_name' => 'Edit Role',
                'module' => 'Roles',
            ],
            [
                'name' => 'delete-roles',
                'display_name' => 'Delete Role',
                'module' => 'Roles',
            ],
            [
                'name' => 'manage-permissions',
                'display_name' => 'Manage Permissions',
                'module' => 'Roles',
            ],

            // Settings
            [
                'name' => 'view-settings',
                'display_name' => 'View Settings',
                'module' => 'Settings',
            ],
            [
                'name' => 'edit-settings',
                'display_name' => 'Edit Settings',
                'module' => 'Settings',
            ],

            // Audit Log
            [
                'name' => 'view-audit-logs',
                'display_name' => 'View User Activity / Audit Logs',
                'module' => 'Audit Logs',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

        $roles = [
            [
                'name' => 'administrator',
                'display_name' => 'Administrator',
                'description' => 'Full system access and administration.',
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Management access to sales, inventory, products and reports.',
            ],
            [
                'name' => 'sales_staff',
                'display_name' => 'Sales Staff',
                'description' => 'POS, sales and customer management.',
            ],
            [
                'name' => 'storekeeper',
                'display_name' => 'Storekeeper',
                'description' => 'Inventory, stock and product management.',
            ],
            [
                'name' => 'accountant',
                'display_name' => 'Accountant',
                'description' => 'Sales, expenses and financial reports.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                array_merge($role, [
                    'is_active' => true,
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $allPermissions = Permission::all();

        // Administrator gets everything
        $administrator = Role::where('name', 'administrator')->first();

        $administrator->permissions()->sync(
            $allPermissions->pluck('id')->toArray()
        );

        // Manager
        $managerPermissions = [
            'view-dashboard',

            'view-products',
            'create-products',
            'edit-products',

            'view-categories',
            'create-categories',
            'edit-categories',

            'view-brands',
            'create-brands',
            'edit-brands',

            'view-inventory',
            'stock-in',
            'stock-adjustment',
            'view-stock-movements',

            'view-sales',
            'create-sale',
            'edit-sale',
            'print-receipt',

            'view-customers',
            'create-customers',
            'edit-customers',

            'view-expenses',
            'create-expenses',
            'edit-expenses',

            'view-reports',
            'sales-reports',
            'inventory-reports',
            'expense-reports',

            'view-settings',
        ];

        $manager = Role::where('name', 'manager')->first();

        $manager->permissions()->sync(
            Permission::whereIn('name', $managerPermissions)
                ->pluck('id')
                ->toArray()
        );

        // Sales Staff
        $salesPermissions = [
            'view-dashboard',

            'view-products',

            'view-sales',
            'create-sale',
            'print-receipt',

            'view-customers',
            'create-customers',
            'edit-customers',
        ];

        $salesStaff = Role::where('name', 'sales_staff')->first();

        $salesStaff->permissions()->sync(
            Permission::whereIn('name', $salesPermissions)
                ->pluck('id')
                ->toArray()
        );

        // Storekeeper
        $storekeeperPermissions = [
            'view-dashboard',

            'view-products',
            'create-products',
            'edit-products',

            'view-categories',
            'create-categories',
            'edit-categories',

            'view-brands',
            'create-brands',
            'edit-brands',

            'view-inventory',
            'stock-in',
            'stock-adjustment',
            'view-stock-movements',

            'view-customers',
        ];

        $storekeeper = Role::where('name', 'storekeeper')->first();

        $storekeeper->permissions()->sync(
            Permission::whereIn('name', $storekeeperPermissions)
                ->pluck('id')
                ->toArray()
        );

        // Accountant
        $accountantPermissions = [
            'view-dashboard',

            'view-sales',
            'print-receipt',

            'view-customers',

            'view-expenses',
            'create-expenses',
            'edit-expenses',

            'view-reports',
            'sales-reports',
            'expense-reports',
            'inventory-reports',
        ];

        $accountant = Role::where('name', 'accountant')->first();

        $accountant->permissions()->sync(
            Permission::whereIn('name', $accountantPermissions)
                ->pluck('id')
                ->toArray()
        );
    }
}
