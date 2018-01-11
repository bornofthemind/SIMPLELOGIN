<?php

require_once 'base/first.php';

if (Input::exists()) {
     if(Token::check(Input::get('token'))) {
         $validate = new Validate();
         $validation = $validate->check($_POST, array(
                'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
        ));

        if ($validate->passed()) {
            $user = new User();
            $salt = Hash::salt(32);

            try {
                $user->create(array(
                    'name' => Input::get('name'),
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1
                ));

                Session::flash('home', 'Welcome ' . Input::get('username') . '! Your account has been registered. You may now log in.');
                Redirect::to('index.php');
            } catch(Exception $e) {
                echo $error, '<br>';
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error . "<br>";
            }
        }
    }
}
?>
<form style="text-align: center; " action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo Input::get('name'); ?>" id="name">
    </div>

    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo Input::get('username'); ?>">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Password Again</label>
        <input type="password" name="password_again" id="password_again" value="">
    </div>
    <br>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">
</form>
