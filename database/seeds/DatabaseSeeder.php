<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Fetch all data from the old table
        $data = DB::table('user')->get();

        foreach ($data as $row) {
            // Insert into users table
            DB::table('users')->update([
                'status' => $row->status,
            ]);
            // DB::table('users')->insert([
            //     'name' => $row->name,
            //     'email' => $row->email,
            //     'password' => $row->password,
            //     'user_uid' => $row->user_uid,
            //     'username' => $row->username,
            //     'contact_number' => $row->contact_number,
            //     'address' => $row->address,
            //     'city' => $row->city,
            //     'state' => $row->state,
            //     'pincode' => $row->pincode,
            //     'user_group' => $row->user_group,
            //     'vendor_id' => $row->id,
            //     'remember_token' => $row->remember_token,
            //     'email_verified_at' => $row->email_verified_at,
            //     'isAdmin' => $row->isAdmin,
            //     'created_at' => $row->created_at,
            //     'updated_at' => $row->updated_at,
            // ]);

            //     DB::table('vendors')->insert([
            //         'vendor_id' => $row->id,
            //         'name' => $row->name,
            //         'store_name' => $row->store_name,
            //         'store_url' => $row->store_url,
            //         'status' => $row->status,
            //         'plugin_ui' => $row->plugin_ui,
            //         'store_ui' => $row->store_ui,
            //         'fabric_upload_limit' => $row->fabric_upload_limit,
            //         'created_at' => $row->created_at,
            //         'updated_at' => $row->updated_at,
                
            //     ]);
        }
    }
}

