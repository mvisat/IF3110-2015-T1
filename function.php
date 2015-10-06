<?php
    function displayAllQuestionList() {
        $mysqli = new mysqli("localhost", "root", "", "exchangelyz");
        // check error
        if ($mysqli->connect_errno) {
            echo "Connect failed: " . $mysqli->connect_error;
            exit();
        }
        // query from database
        if ($result = $mysqli->query("SELECT * FROM question ORDER BY time DESC LIMIT 10")) {
            while ($row = $result->fetch_assoc()) {
                $query = "SELECT id FROM answer WHERE id_question='". $row["id"] ."'";
                $answers = $mysqli->query($query)->num_rows;
                displayQuestionList(
                    $row["id"], $row["topic"], $row["name"], $row["email"],
                    $row["content"], $row["time"], $row["vote"], $answers);
            }
            $result->close();
        }
        $mysqli->close();
    }

    function displayQuestionList($id, $topic, $name, $email, $content, $time, $vote, $answer) {
        echo '<div class=question-item>';
            echo '<div class="stat">';
                echo '<div class="vote">';
                    echo '<div class="vote-count">';
                        echo '<span title="'. $vote .' votes">'. $vote .'</span>';
                    echo '</div>';
                    echo '<div>votes</div>';
                echo '</div>';

                echo '<div class="answer">';
                    echo '<div class="answer-count">';
                        echo '<span title="'. $answer .' answers">'. $answer .'</span>';
                    echo '</div>';
                    echo '<div>answers</div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="summary">';
                echo '<h3 class="topic"><a class="topic" href="question.php?id='. $id .'">'. $topic .'</a></h3>';
                echo '<p>'. $content .'</p>';
                echo '<div class="timestamp">';
                    echo 'asked by '. $name .' at '. $time .' | <a href=ask.php?id='. $id .'>edit</a> | <a href="#">delete</a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<hr class="item">';
    }
?>