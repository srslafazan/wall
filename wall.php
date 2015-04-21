<?php 
session_start();
require_once('new-connection.php');
require_once('functions.php');

?>

 <!DOCTYPE html>
 <html>
 <head>
     <title>Dojo Wall - The Wall</title>
     <link rel='stylesheet' href='main.css'>
 </head>
 <body>
     <div id="container">

        <div id='header'>
            <h3><a href='wall.php'>CodingDojo Wall</a></h3>
            <p>Welcome<?php if (!isset($_SESSION['newuser'])) { echo " back"; } ?>, <span class='username'><?= $_SESSION['user'] ?></span>!</p>
            <a href="index.php">Log Off</a>
        </div>

    <div id='postmessage'>
        <!-- <h4>Post a message</h4> -->
        <form action='process.php' method='post'>
            <input type='hidden' name='action' value='message'>                
            <textarea name='message' placeholder='I want to say that...' target></textarea>
            <input type='submit' value='Post'>
        </form>
    </div>

    <div class='post'>
        
    <?php

        $messages = get_messages();

        for ( $i = count($messages) - 1 ; $i >= 0 ; $i-- )
        {   
            $message = $messages[$i];
    ?>
            <div class='message'>
            <h4><?php echo "{$message['first_name']} {$message['last_name']} - {$message['created_at']}"?></h4>
            <p><?= $message['message'] ?></p>
            </div>
            
            <?php
                $message_id = $message['messageid'];
                $comments = get_comments($message_id);

            ?>

                <form class='no css form' action='process.php' method='post'>
                    <input type='hidden' name='action' value='deletemessage'>
                    <input type='hidden' name='message_id' value="<?= $message_id ?>">
                    <input class='delete button dmessage' type='submit' value='delete'>
                </form>

            <?php
                for ( $j = 0 ; $j < count($comments) ; $j++ ) 
                { 
            ?>

                    <div class='comment'>
                        <h5><?php echo "{$comments[$j]['first_name']} {$comments[$j]['last_name']} - {$comments[$j]['created_at']}"; ?></h5>
                        <p><?= $comments[$j]['comment'] ?></p>
                        <form class='no css form' action='process.php' method='post'>
                            <input type='hidden' name='action' value='deletecomment'>
                            <input type='hidden' name='comment_id' value="<?= $comments[$j]['commentid']?>">
                            <input class='delete button' type='submit' value='delete'>
                        </form>
                    </div> 
                <?php           
                }
                ?>

                <div class='commentbox'>
                    <!-- <h4>Post a comment</h4> -->
                    <form action='process.php' method='post'>
                        <input type='hidden' name='action' value='comment'>
                        <input type='hidden' name='message_id' value="<?= $message_id; ?>">
                        <textarea name='comment' placeholder="I'm thinking..."></textarea>
                        <input class='green button' type='submit' value='Comment'>
                    </form>
                </div>     
        <?php
        }
        ?>
            </div>
        </div>
    </div>
</body>
</html>