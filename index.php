<?php

require_once 'base/first.php';

if(Session::exists('home')) {
    echo '<p>' . Session::flash('home'). '</p>';
}

$user = new User(); //Current

if($user->isLoggedIn()) {
?>

    <p style="text-align: center;">Hello, Agent <?php echo $user->data()->username; ?> | <a href="logout.php" >Log out</a></li></p>	
<?php

} else {
    echo '<center>Welcome to Agentology, Inc.:<br><p>Please click here to <a href="login.php">login</a>.<br>Not a member? <a href="register.php">register.</a></p></center>';
}