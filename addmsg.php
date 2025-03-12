<?php
// addmsg.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = htmlspecialchars($_POST['topic']);
    $message = htmlspecialchars($_POST['message']);
    $author = htmlspecialchars($_POST['author']);

    $file = "$topic.txt";
    $date = date('Y-M-d');

    $newMessage = "$message<br><hr><div style=\"display: flex; justify-content: space-between;\"><span style=\"text-align: left;\">Author : $author</span><span style=\"text-align: right;\">Date : $date</span> </div>\n";

    if (file_put_contents($file, $newMessage, FILE_APPEND | LOCK_EX)) {
        header("Location: webboard.php?topic=$topic");
        exit();
    } else {
        echo "Error writing to file.";
    }
} else {
    echo "Invalid request.";
}
?>
