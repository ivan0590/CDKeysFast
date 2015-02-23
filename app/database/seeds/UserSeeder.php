<?php

/**
 * Description of UserSeeder
 *
 * @author Ivan
 */
class UserSeeder extends DatabaseSeeder {

    public function run() {


        $admin = Admin::where('id', '<=', 5);
        $client = Client::where('id', '<=', 5);

        for ($index = 1; $index <= 10; $index++) {

            if ($index <= 5) {
                $userType = $admin;
                $id = $index;
            } else {
                $userType = $client;
                $id = $index - 5;
            }


            $user = User::create([
                        'email' => "userTest$index@userTest.com",
                        'password' => Hash::make("userTest$index"),
                        'name' => "userTest$index",
                        'surname' => "userTest$index",
                        'confirmed' => false,
                        'confirmation_code' => str_random(30),
                        'change_email_code' => '',
                        'change_email' => null,
                        'change_password_code' => '',
                        'change_password' => '',
                        'unsuscribe_code' => ''
            ]);

            $userType->get()->find($id)->user()->save($user);
        }
    }

}