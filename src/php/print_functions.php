<?php

function printEvent($id) {
    if ($event = new Event($id)) {
        $title = $event->getTitle();
        $score = 5;

        echo "<div class='event'>";
        echo "    <div class='container-score'>";
        echo "        <button class='upvote'><i class='material-icons'>keyboard_arrow_up</i></button>";
        echo "        <div class='score'>$score</div>";
        //echo "        <button class='downvote'><i class='material-icons'>keyboard_arrow_down</i></button>";
        echo "    </div>";
        echo "    <a class='title' href='#'>$title</a>";
        echo "    <div class='time'></div>";
        echo "</div>";
    }
}


 ?>
