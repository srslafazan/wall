<?php

function get_messages() {

        $query = "  SELECT *, messages.id as messageid
                    FROM messages
                    LEFT JOIN users
                    ON users.id = messages.users_id
        ";
        return fetch($query);
}

function get_comments($message_id) {

        $query = "  SELECT *, comments.id as commentid FROM comments
                    LEFT JOIN users
                    ON users.id = comments.users_id
                    WHERE messages_id = $message_id
        ";

        return fetch($query);
}


function register_formval($post)
{
    $_SESSION['errors'] = array();

    if (empty($post['first_name']))
    {
        $_SESSION['errors'][] = "First name can't be blank!";
    }
    if (empty($post['last_name']))
    {
        $_SESSION['errors'][] = "Last name can't be blank!";
    }
    if ( $post['password'] !== $post['confirm_password'] )
    {
        $_SESSION['errors'][] = "Passwords must match!";
    }
    if (empty($post['password']))
    {
        $_SESSION['errors'][] = "Password field is required!";
    }
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['errors'][] = "Please use valid email address!";
    }
    // end of validation checks

    if(count( $_SESSION['errors'] ) > 0 ) 
    {
        header('location: index.php');
        die();
    } 
    else // insert user into database , login user
    {
        $encrypted_password = md5($_POST['password']);
        $first_name = $post['first_name'];
        $last_name = $post['last_name'];
        $email = $post['email'];

        $query = "INSERT INTO users (first_name, last_name, password, email, created_at, updated_at) VALUES ('$first_name','$last_name', '{$encrypted_password}', '$email', NOW(), NOW() )";
        run_mysql_query($query);
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $post['first_name'];
        $_SESSION['newuser'] = true;

        $idquery = "SELECT id FROM users
        WHERE users.email = '$email'
        AND users.password = '$encrypted_password';
        ";

        $useridarray = fetch($idquery);

        $userid = $useridarray[0]['id'];

        $_SESSION['user_id'] = $userid;

        header('location: wall.php');
        die();
    }
    
}

function login_formval($post) 
{
    $_SESSION['errors'] = array();

    if (empty($post['password']))
    {
        $_SESSION['errors'][] = "Password field is required.";
    }
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['errors'][] = "Please use valid email address.";
    }

    // check val with db users
        $encrypted_password = md5($post['password']);
        $email = $post['email'];

        $query = "SELECT * FROM users
        WHERE users.password = '{$encrypted_password}'
        AND users.email = '{$email}'
        ";

        $user = fetch($query);

    if(count( $_SESSION['errors'] ) > 0 ) 
    {

        header('location: index.php');
        die();

    } 


    if( $user === null ) {
        unset($_SESSION['errors']);
        $_SESSION['errors'][] = "Username or email incorrect.";
        header('location: index.php');
        die();
    }

    // end of reg val checks

    else // login user
    {
        $idquery = "    SELECT id FROM users
                        WHERE users.email = '$email'
                        AND users.password = '$encrypted_password'
        ";
        $useridarray = fetch($idquery);
        $userid = $useridarray[0]['id'];

        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $user[0]['first_name'];
        $_SESSION['user_id'] = $userid;
        unset($_SESSION['newuser']);
        header('location: wall.php');
        die();
    }
    
}

function getMessages() {
    $query = "SELECT messages.message, 

    ;";
}


function displayData ($tablename, $column1, $column2) {

    $query = "SELECT * FROM {$tablename};";
    $queryname = fetch($query);


    $data = array();

    if ( count($queryname) > 1 && !isset($queryname['id']) ) {

        foreach ( $queryname as $querynums => $queryarrays ) {

            foreach ( $queryarrays as $querykeys => $queryvalues ) {
                array_push( $data, [ $querykeys => $queryvalues ] );
            }
        }    
    } 
    elseif ( isset($queryname['id']) ) 
    {

        
        foreach ( $queryname as $querynums => $queryvalues ) 
            { 
                array_push($data, $queryvalues);
            }
    }

    elseif ( count($queryname) == 0 )
    {
        return false;
    }

    return $data;
}

function saveData($tablename, $column1, $column2, $value1, $value2) {

    $query = "INSERT INTO $tablename ($tablename.$column1, $tablename.$column2) VALUES ('$value1', '$value2');";
    run_mysql_query($query);
}

function uploadPhoto ( $filename, $target_dir ) {
    // if no target directory
    // if ( $target_dir === undefined) {
    //     $target_dir = "uploads/";
    // }

    $target_file = $target_dir . basename($_FILES[$filename]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);

    return true;
}

function deleteData ($tablename, $row ) {
    $query = "DELETE FROM $tablename;";
    // $queryname = fetch($query);
}

function displayMessages ($tablename) {

    $data = array();

    if ( count($queryname) > 1 && !isset($queryname['id']) ) {

        foreach ( $queryname as $querynums => $queryarrays ) {

                foreach ( $queryarrays as $querykeys => $queryvalues ) {
                    array_push( $data, [ $querykeys => $queryvalues ] );
                }

        }    
    } 
    elseif ( isset($queryname['id']) ) 
    {

        
        foreach ( $queryname as $querynums => $queryvalues ) 
            { 
                array_push($data, $queryvalues);
            }
    }

    elseif ( count($queryname) == 0 )
    {
        return false;
    }

    return $data;
}

?>