<!DOCTYPE html>
<html>
<head>
    <title>Course list</title>
    <meta charset="utf-8" />
    <link href="courses.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="header">
    <h1>Courses at CSE</h1>
<!-- Ex. 1: File of Courses -->
    <?php
        $file = "courses.tsv";
        $lines = file($file); 
        $filename = basename($file);
    ?>
    <p>
        Course list has <?= count($lines) ?>  total courses
        and
        size of <?= filesize($file) ?> bytes.
    </p>
</div>
<div class="article">
    <div class="section">
        <h2>Today's Courses</h2>
<!-- Ex. 2: Today’s Courses & Ex 6: Query Parameters -->
        <?php
            $numberOfCourses = 3;
            if (isset($_GET["number_of_courses"]) == 1 && $_GET["number_of_courses"] != "") {
                $numberOfCourses = (int)$_GET["number_of_courses"];
            }

            function getCoursesByNumber($listOfCourses, $numberOfCourses){
                $resultArray = array();
//                implement here.
                if ($numberOfCourses == 1) {
                    $resultArray = array_rand($listOfCourses);
                }
                else {
                    $resultArray = array_rand($listOfCourses, $numberOfCourses);
                }
                return $resultArray;
            }

            $todaysCourses = getCoursesByNumber($lines, $numberOfCourses);
        ?>
        <ol>
            <?php
                if ($numberOfCourses == 1) {
                    $tokenwords = explode("\t", $lines[$todaysCourses]);
                    $newString = implode(" - ", $tokenwords);
                    ?>
                    <li><?= $newString ?></li> 
                    <?php }
                else {
                    foreach ($todaysCourses as $todayCourse) { 
                        $tokenwords = explode("\t", $lines[$todayCourse]);
                        $newString = implode(" - ", $tokenwords);
                        ?>
                        <li><?= $newString ?></li> 
                <?php }
                }
            ?>
        </ol>
    </div>
    <div class="section">
        <h2>Searching Courses</h2>
<!-- Ex. 3: Searching Courses & Ex 6: Query Parameters -->
        <?php
            $startCharacter = "C";
            if (isset($_GET["character"]) == 1 && $_GET["character"] != "") {
                $startCharacter = $_GET["character"];
            }

            function getCoursesByCharacter($listOfCourses, $startCharacter){
                $resultArray = array();
//                implement here.
                foreach ($listOfCourses as $listOfCourse) {
                    if ($listOfCourse[0] == $startCharacter)
                        array_push($resultArray, $listOfCourse);
                }
                return $resultArray;
            }

            $searchedCourses = getCoursesByCharacter($lines, $startCharacter);
        ?>
        <p>
            Courses that started by <strong>'<?= $startCharacter ?>'</strong> are followings :
        </p>
        <ol>
            <?php
                foreach ($searchedCourses as $searchedCourse) { 
                    $tokenwords2 = explode("\t", $searchedCourse);
                    $newString2 = implode(" - ", $tokenwords2); ?>
                    <li><?= $newString2 ?></li>
                <?php }
            ?>
        </ol>
    </div>
    <div class="section">
        <h2>List of Courses</h2>
<!-- Ex. 4: List of Courses & Ex 6: Query Parameters -->
        <?php
            $orderby = 0;
            $ordering = "alphabet order";
            if (isset($_GET["orderby"]) == 1 && $_GET["orderby"] != "") {
                $orderby = $_GET["orderby"];
            }

            function getCoursesByOrder($listOfCourses, $orderby){
                $resultArray = $listOfCourses;
//                implement here.
                if ($orderby == 0) {
                    sort($resultArray);
                }
                else if($orderby == 1) {
                    rsort($resultArray);
                    $ordering = "alphabet reverse order";
                }
                else {
                    print "Input error.";
                    exit(1);
                }
                return $resultArray;
            }
            $orderedCourses = getCoursesByOrder($lines, $orderby);
        ?>
        <p>
            All of courses ordered by <strong><?= $ordering ?></strong> are followings :
        </p>
        <ol>
            <?php
                foreach ($orderedCourses as $orderedCourse) {
                    $tokenwords2 = explode("\t", $orderedCourse);
                    $newString2 = implode(" - ", $tokenwords2); 
                    
                    if (strlen($tokenwords2[0]) > 20) { ?>
                        <li class="long"><?= $newString2 ?></li>
                    <?php }
                    else { ?>
                        <li><?= $newString2 ?></li>
                <?php } 
                }
            ?>
        </ol>
    </div>
    <div class="section">
        <h2>Adding Courses</h2>
<!-- Ex. 5: Adding Courses & Ex 6: Query Parameters -->
        <?php
            if (isset($_GET["new_course"]) == 1 && $_GET["new_course"] != "" && isset($_GET["code_of_course"]) == 1 && $_GET["code_of_course"] != "") {
                $newCourse = $_GET["new_course"];
                $codeOfCourse = $_GET["code_of_course"];
                $newarray[0] = $newCourse;
                $newarray[1] = $codeOfCourse;

                $newword = implode("\t", $newarray);
                file_put_contents($file, "\n", FILE_APPEND); 
                file_put_contents($file, $newword, FILE_APPEND); ?>
                <p>Adding a course is success!</p>
            <?php }
            else { ?>
                <p>Input course or code of the course doesn't exist.</p>
            <?php }
        ?>
    </div>
</div>
<div id="footer">
    <a href="http://validator.w3.org/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-html.png" alt="Valid HTML5" />
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-css.png" alt="Valid CSS" />
    </a>
</div>
</body>
</html>