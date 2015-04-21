<?php 
session_start();
require_once('new-connection.php');
require_once('functions.php');



if( isset( $_POST['action']) && $_POST['action'] == 'register')
{
    register_formval($_POST);
}
elseif( isset( $_POST['action']) && $_POST['action'] == 'login')
{
    login_formval($_POST);
}
//maliciious navigation to process.php or someone is trying to log off
elseif (! isset( $_SESSION['logged_in']) && $_POST['action'] != 'login' ) 
{
    session_destroy();
    header('location:index.php');
    exit();
}

if( isset( $_POST['action'] ) && $_POST['action'] == 'message' ) 
{
    $message = $_POST['message'];
    $query = "  INSERT INTO messages ( message, users_id, updated_at, created_at ) 
                VALUES ( '" . $message . "', '" . $_SESSION['user_id'] . "' , NOW(), NOW() )";

    run_mysql_query($query);
    
    header('location: wall.php');
    exit();
}

if ( isset( $_POST['action'] ) && $_POST['action'] == 'comment') 
{

    $comment = $_POST['comment'];
    $query = "  INSERT INTO comments ( comment , users_id , messages_id, created_at, updated_at ) 
                VALUES ( '" . $comment . "', '". $_SESSION['user_id'] ."', '". $_POST['message_id']."', NOW(), NOW() )
                ";

    run_mysql_query($query);

    header('location: wall.php');
    exit();
}

if ( isset( $_POST['action'] ) && $_POST['action'] == 'deletecomment') 
{
    $query = "  DELETE FROM comments 
    WHERE comments.id = {$_POST['comment_id']}";
    
    run_mysql_query($query);
}

if ( isset( $_POST['action']) && $_POST ['action'] == 'deletemessage') 
{

    $cquery = " DELETE FROM comments
                WHERE comments.messages_id = {$_POST['message_id']}
                ";

    run_mysql_query($cquery);

    $mquery = " DELETE FROM messages
                WHERE messages.id = {$_POST['message_id']}
                ";

    run_mysql_query($cquery);
    run_mysql_query($mquery);
}

header('location: wall.php');
exit();

?>