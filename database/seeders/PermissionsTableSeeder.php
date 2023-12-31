<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'content_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'content_category_create',
            ],
            [
                'id'    => 19,
                'title' => 'content_category_edit',
            ],
            [
                'id'    => 20,
                'title' => 'content_category_show',
            ],
            [
                'id'    => 21,
                'title' => 'content_category_delete',
            ],
            [
                'id'    => 22,
                'title' => 'content_category_access',
            ],
            [
                'id'    => 23,
                'title' => 'content_tag_create',
            ],
            [
                'id'    => 24,
                'title' => 'content_tag_edit',
            ],
            [
                'id'    => 25,
                'title' => 'content_tag_show',
            ],
            [
                'id'    => 26,
                'title' => 'content_tag_delete',
            ],
            [
                'id'    => 27,
                'title' => 'content_tag_access',
            ],
            [
                'id'    => 28,
                'title' => 'content_page_create',
            ],
            [
                'id'    => 29,
                'title' => 'content_page_edit',
            ],
            [
                'id'    => 30,
                'title' => 'content_page_show',
            ],
            [
                'id'    => 31,
                'title' => 'content_page_delete',
            ],
            [
                'id'    => 32,
                'title' => 'content_page_access',
            ],
            [
                'id'    => 33,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 34,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 35,
                'title' => 'season_create',
            ],
            [
                'id'    => 36,
                'title' => 'season_edit',
            ],
            [
                'id'    => 37,
                'title' => 'season_show',
            ],
            [
                'id'    => 38,
                'title' => 'season_delete',
            ],
            [
                'id'    => 39,
                'title' => 'season_access',
            ],
            [
                'id'    => 40,
                'title' => 'match_create',
            ],
            [
                'id'    => 41,
                'title' => 'match_edit',
            ],
            [
                'id'    => 42,
                'title' => 'match_show',
            ],
            [
                'id'    => 43,
                'title' => 'match_delete',
            ],
            [
                'id'    => 44,
                'title' => 'match_access',
            ],
            [
                'id'    => 45,
                'title' => 'thidaurobotic_access',
            ],
            [
                'id'    => 46,
                'title' => 'score_detail_create',
            ],
            [
                'id'    => 47,
                'title' => 'score_detail_edit',
            ],
            [
                'id'    => 48,
                'title' => 'score_detail_show',
            ],
            [
                'id'    => 49,
                'title' => 'score_detail_delete',
            ],
            [
                'id'    => 50,
                'title' => 'score_detail_access',
            ],
            [
                'id'    => 51,
                'title' => 'team_create',
            ],
            [
                'id'    => 52,
                'title' => 'team_edit',
            ],
            [
                'id'    => 53,
                'title' => 'team_show',
            ],
            [
                'id'    => 54,
                'title' => 'team_delete',
            ],
            [
                'id'    => 55,
                'title' => 'team_access',
            ],
            [
                'id'    => 56,
                'title' => 'match_team_create',
            ],
            [
                'id'    => 57,
                'title' => 'match_team_edit',
            ],
            [
                'id'    => 58,
                'title' => 'match_team_show',
            ],
            [
                'id'    => 59,
                'title' => 'match_team_delete',
            ],
            [
                'id'    => 60,
                'title' => 'match_team_access',
            ],
            [
                'id'    => 61,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
