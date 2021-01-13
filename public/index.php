<?php
session_start();
include './classes/Employer.php';

$name = isset($_POST['name']) && !empty($_POST['name']) ? trim($_POST['name']) : false;
$experienced = isset($_POST['experienced']) ? $_POST['experienced'] : false;

if (isset($_POST['reset']) && $_POST['reset'] === 'session') Employer::resetSessionList();
if (isset($_POST['reset']) && $_POST['reset'] === 'text') Employer::resetTextFileList();

if ($name) $candidate = new Employer($name, $experienced);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css"/>
    <title>ART21 Task</title>
</head>
<body>
<div class="console-box">
    <?= isset($candidate) ? $candidate->getMessage() : ''; ?>
</div>
<div class="form-box">
    <h2>New employee</h2>
    <form method="post">
        <div class="form-block">
            <label for="name">New employees name:</label>
            <input type="text" name="name" id="name" required/>
        </div>
        <div class="form-block">
            <label for="experienced">Employee has experience</label>
            <input type="checkbox" name="experienced" id="experienced" value="true">
        </div>
        <div class="form-block">
            <input type="submit" value="Add"/>
        </div>
    </form>
</div>
<div class="employees-box">
    <div class="employees-block">
        <h2>Employess in session</h2>
        <?php if (!Employer::displaySessionList()): ?>
            <p>List is empty</p>
        <?php else: ?>
            <ul>
                <?php foreach (Employer::displaySessionList() as $candidate): ?>
                    <li><?= $candidate ?></li>
                <?php endforeach; ?>
            </ul>
            <form method="post">
                <input type="hidden" name="reset" value="session"/>
                <input type="submit" value="Reset session list"/>
            </form>
        <?php endif; ?>
    </div>
    <div class="employees-block">
        <h2>Employees in text file</h2>
        <?php if (!Employer::displayTextFileList() || empty(Employer::displayTextFileList()[0])): ?>
            <p>List is empty</p>
        <?php else: ?>
            <ul>
                <?php foreach (Employer::displayTextFileList() as $candidate): ?>
                    <li><?= $candidate ?></li>
                <?php endforeach; ?>
            </ul>
            <form method="post">
                <input type="hidden" name="reset" value="text"/>
                <input type="submit" value="Reset text file list"/>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
