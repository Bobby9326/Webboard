<?php
// addtopic.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_topic = htmlspecialchars($_POST['new_topic']);
    $author = htmlspecialchars($_POST['author']);

    if (!empty($new_topic)) {
        $topics_file = 'topics.txt';
        $topics = file_exists($topics_file) ? file($topics_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

        if (!in_array($new_topic, $topics)) {
            // Add the new topic to the topics list
            file_put_contents($topics_file, "$new_topic\n", FILE_APPEND | LOCK_EX);
            
            // Create a new file for the topic and include the author's name
            $new_topic_file = "$new_topic.txt";
            $date = date('Y-M-d');
            $initial_message = "Author : $author Date : $date<hr>\n";
            file_put_contents($new_topic_file, $initial_message, LOCK_EX);
            

            header("Location: webboard.php");
            exit();
        } else {
            echo "Topic already exists.";
        }
    } else {
        echo "Topic name cannot be empty.";
    }
} else {
    echo "Invalid request.";
}
?>