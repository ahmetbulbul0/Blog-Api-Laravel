<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "role_id" => Role::ADMIN_ID,
            "first_name" => "blog",
            "last_name" => "admin",
            "username" => "blogadmin",
            "email" => "blogadmin@blogadmin.com",
            "password" => "password",
            "profile_picture" => null,
            "occupation" => "admin",
            "date_of_birth" => "11-01-2025",
            "location" => "Turkey",
            "preferred_language" => "tr",
            "gender" => "male",
            "bio" => "In ipsum occaecat deserunt adipisicing exercitation eiusmod duis laboris. Mollit nostrud qui aliqua commodo. Adipisicing nisi deserunt nulla aute eu sint ipsum. Adipisicing dolor aliqua cupidatat laboris minim nisi eu cillum sint sunt id veniam. Ipsum fugiat est excepteur eiusmod occaecat laboris mollit pariatur occaecat do ea ad. Non cupidatat dolore cillum elit dolore. Ex veniam deserunt sit aliquip qui eiusmod est minim ut proident cupidatat laboris officia cupidatat.",
        ]);

        User::create([
            "role_id" => Role::AUTHOR_ID,
            "first_name" => "blog",
            "last_name" => "author",
            "username" => "blogauthor",
            "email" => "blogauthor@blogauthor.com",
            "password" => "password",
            "profile_picture" => null,
            "occupation" => "author",
            "date_of_birth" => "11-01-2025",
            "location" => "Turkey",
            "preferred_language" => "tr",
            "gender" => "male",
            "bio" => "Id culpa sint fugiat sint et ullamco quis Lorem et ipsum qui proident in aliqua. Quis cillum Lorem sunt proident exercitation dolor labore ex proident incididunt in elit est nulla. Veniam velit minim nisi sint magna magna elit ullamco. Et et deserunt sit magna laborum ex enim id veniam aliquip. Tempor fugiat consectetur aute et velit velit. Aute reprehenderit consectetur consequat sint ullamco exercitation in ad ea officia. Sunt proident labore irure ipsum sit ut eu excepteur.",
        ]);

        User::create([
            "role_id" => Role::READER_ID,
            "first_name" => "blog",
            "last_name" => "reader",
            "username" => "blogreader",
            "email" => "blogreader@blogreader.com",
            "password" => "password",
            "profile_picture" => null,
            "occupation" => "reader",
            "date_of_birth" => "11-01-2025",
            "location" => "Turkey",
            "preferred_language" => "tr",
            "gender" => "male",
            "bio" => "Anim labore non et culpa. Elit proident sit in adipisicing cillum. Amet exercitation culpa mollit aliquip officia quis laborum reprehenderit. Mollit officia sint Lorem ex fugiat ad proident cillum eiusmod consequat tempor irure.",
        ]);
    }
}
