<?php
// webboard.php
//load file topics
$topics_file = 'topics.txt';
if (!file_exists($topics_file)) {
    // ถ้าไม่พบไฟล์ 'topics.txt', สร้างไฟล์ใหม่และเขียนข้อความเริ่มต้นลงไป
    file_put_contents($topics_file, "");
}
$topics = file($topics_file);


if (isset($_GET['topic'])) {
    $topic = htmlspecialchars($_GET['topic']);//get sting from ?topic=thisvalue
    $file = "$topic.txt";//current file is thisvalue.txt where we store chat in
    if (!file_exists($file)) {
        file_put_contents($file, ""); // Create the file if it doesn't exist
    }
    $messages = file($file);
} else {
    $topic = null;
    $messages = [];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Webboard</title>
    <style>
        body {
            background-color: #3A3A5A; /* สีม่วงอมเท้าเข้ม */
            color: #FFFFFF; /* สีขาว */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            font-size: 72px;
            font-weight: bold; /* ตัวหนา */
        }
        h2 {
            font-size: 48px;
            font-weight: bold; /* ตัวหนา */
        }
        .block-topic {
            display: block;
            width: 300px;
            margin: 10px auto;
            padding: 20px;
            background-color:rgb(42, 42, 67);
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
        }
        .block-text {
            display: block;
            width: 80%;
            margin: 10px auto;
            padding: 20px;
            font-size: 30px;
            background-color:rgb(42, 42, 67);
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
        }
        a {
            color:rgb(255, 255, 255); /* สีส้มอมแดง */
            text-decoration: none; /* เอาเส้นใต้ออก */
            font-weight: bold; /* ตัวหนาเล็กน้อย */
        }

        /* ลิงก์เมื่อ hover */
        a:hover {
            color: #FFD700; /* เปลี่ยนสีเป็นสีทองเมื่อชี้ */
            text-decoration: underline; /* ใส่เส้นใต้เมื่อ hover */
        }
        span{
            color:rgb(130, 130, 130);
            font-size: 20px;
        }
    </style>
</head>
<body>
    <center>
<h1><a href ="webboard.php" style="color: white">Webboard</a></h1>
<?php if (!$topic): ?>  <!--check if url has ?=topic -->
    <h3>Choose a topic:</h3>
    <?php foreach ($topics as $t): ?>
        <a href="?topic=<?= htmlspecialchars($t) ?>">
            <div class="block-topic">
                <?= htmlspecialchars($t) ?>
            </div>
        </a><br>
    <?php endforeach; ?>
    <form action="addtopic.php" method="POST">
        <label>New Topic:</label><br><br>
        Topic : <input type="text" name="new_topic"><br><br>
        Author : <input type="text" name="author"><br><br>
        <button type="submit">Add Topic</button>
    </form>
<?php else: ?> <!-- display msg -->
    <hr>
    <h3>Topic</h3>
    <h2 style="margin-top: 0;margin-bottom: 5;"> <?= $topic ?></h2>

    <!-- <a href="webboard.php">Back to webboard</a> -->
    
    <div>
        <?php 
        // Extract the first line for author
        $author_info = count($messages) > 0 ? array_shift($messages) : "No author information available.";
        ?>

        <p><strong><?= nl2br($author_info) ?></strong></p>
    </div>
    <div>
        <h3>Messages:</h3>
        <?php 
        $chat_messages = $messages; 
        ?>
        <?php if (count($chat_messages) > 0): ?>
            <?php $index = 1; // เริ่มต้นนับลำดับ ?>
            <?php foreach ($chat_messages as $message): ?>
                <div class="block-text">
                <span style="display: block; text-align: left;">
                    <br>message <?= $index ?><br>
                </span>
                    <?= nl2br($message) ?>
                </div>
                <?php $index++;?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages yet.</p>
        <?php endif; ?>
    </div>
    <hr> 
    <form action="addmsg.php" method="POST">
        <h3>Add Comment</h3> 
        <input type="hidden" name="topic" value="<?= $topic ?>">
        <label>Message:</label><br>
        <textarea name="message" rows="4" cols="50"></textarea><br><br>
        <label>Author:</label><br>
        <input type="text" name="author"><br><br>
        <button type="submit">Post Message</button>
    </form>
<?php endif; ?>
</body>
</html>
