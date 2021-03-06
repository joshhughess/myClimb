<?php
/**
 * Created by PhpStorm.
 * User: joshh
 * Date: 08/11/2017
 * Time: 19:43
 */
session_start();
$host = "localhost";
$userName = "root";
$password = "password";
$db = "myclimb";

$connect = mysqli_connect($host,$userName,$password, $db);
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $postVisAll = null;
    $allowAllFollow = null;
    if (isset($_POST['postVisAll'])) {
        $postVisAll = mysqli_real_escape_string($connect,$_POST['postVisAll']);
    } else {
        $postVisAll = "N";
    }
    if (isset($_POST['allowAllFollow'])) {
        $allowAllFollow = mysqli_real_escape_string($connect,$_POST['allowAllFollow']);
    } else {
        $allowAllFollow = "N";
    }
    $pref_isSport = null;
    $pref_isTrad = null;
    $pref_isTopRope = null;
    $pref_isMountaineering = null;
    $pref_isBouldering = null;
    $pref_isFreeSolo = null;
    if (isset($_POST['isSport'])) {
        $pref_isSport = mysqli_real_escape_string($connect, $_POST['isSport']);
    } else {
        $pref_isSport = "N";
    }
    if (isset($_POST['isTrad'])) {
        $pref_isTrad = mysqli_real_escape_string($connect,$_POST['isTrad']);
    } else {
        $pref_isTrad = "N";
    }
    if (isset($_POST['isTopRope'])) {
        $pref_isTopRope = mysqli_real_escape_string($connect,$_POST['isTopRope']);
    } else {
        $pref_isTopRope = "N";
    }
    if (isset($_POST['isMountaineering'])) {
        $pref_isMountaineering = mysqli_real_escape_string($connect,$_POST['isMountaineering']);
    } else {
        $pref_isMountaineering = "N";
    }
    if (isset($_POST['isBouldering'])) {
        $pref_isBouldering = mysqli_real_escape_string($connect,$_POST['isBouldering']);
    } else {
        $pref_isBouldering = "N";
    }
    if (isset($_POST['isFreeSolo'])) {
        $pref_isFreeSolo = mysqli_real_escape_string($connect,$_POST['isFreeSolo']);
    } else {
        $pref_isFreeSolo = "N";
    }
    $postCommentVoteCount = mysqli_real_escape_string($connect,$_POST['postCommentVoteCount']);
    if (isset($_POST['post'])) {
        //check first to see if preference is there
        $check = "SELECT * FROM preferences WHERE username='$username'";
        $res = mysqli_query($connect, $check);
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $update = "UPDATE preferences SET postVisAll='$postVisAll', allowAllFollow='$allowAllFollow', isSport='$pref_isSport', isTrad='$pref_isTrad', isTopRope='$pref_isTopRope', isBouldering='$pref_isBouldering', isMountaineering='$pref_isMountaineering', isFreeSolo='$pref_isFreeSolo', postCommentVoteCount='$postCommentVoteCount' WHERE username='$username'";
                if (mysqli_query($connect, $update)) {
                    // send email
                    $to = $email;
                    $subject = "Preferences Updated";
                    $message = "<html><body>";
                    $message .= "<p>Your preference settings have been updated.</p>";
                    $message .= "<a href='localhost/myClimb/profile.php'>Click here</a> to go back</body></html>";
                    $headers = 'From: auto.myclimb@gmail.com' . "\r\n";
                    $headers .= 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                    if (mail($to, $subject, $message, $headers)) {
                        header('Location: profile.php');
                    }
                } else {
                    echo "There is an error somewhere";
                }
            }
        }
    } elseif (isset($_POST['changePass'])) {
        $passwordKey = generateRandomString();
        $to = $email;
        $subject = "Password Updated";
        $message = "<html><body>";
        $message .= "<p>Your password has been updated. Please verify</p>";
        $message .= "<a href='localhost/myClimb/profile.php?key=" . $passwordKey . "'>Click here</a> to verify</body></html>";
        $headers = 'From: auto.myclimb@gmail.com' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            header('Location: profile.php');
            $_SESSION['newPass'] = $_POST['password'];
            $_SESSION['passwordKey'] = $passwordKey;
        }
    } else {
        $mySQL = "INSERT INTO preferences(username,postVisAll,allowAllFollow) VALUES('$username','$postVisAll','$allowAllFollow')";
        if (mysqli_query($connect, $mySQL)) {
            echo "inserted";
        } else {
            echo "There is an error somewhere";
            echo mysqli_error($connect);
        }
    }
}else{
    header("Location:index.php?notLoggedin");
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}