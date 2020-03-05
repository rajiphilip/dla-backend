<?php

namespace Mini\Controller;

use Mini\Model\DLA;
use Mini\Libs\Utility;

class CourseController
{
    public function index()
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();
        //$util = new Utility();

        $courses = $dlaDb->getCourses();
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/course/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addCourse()
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();
        //$util = new Utility();

        $courses = $dlaDb->getCourses();
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/course/add_course.php';
        require APP . 'view/_templates/footer.php';
    }

    public function saveCourse()
    {
        if (isset($_POST["name"], $_POST["status"], $_POST["has_prerequisite"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->addCourse($_POST["name"], $_POST["status"], $_POST["has_prerequisite"]);

            if ($insert) {
                if($_POST["has_prerequisite"] == 1){
                    foreach ($_POST['course'] as $pre_course){
                        $dlaDb->addCoursePrerequisite($insert, $pre_course);
                    }
                }

                header('location: ' . URL . 'course/?msg=Course details saved succesfully.');
            } else {
                header('location: ' . URL . 'course/addCourse?dan=An error occured, please try again later.');
            }
        } else {
            header('location: ' . URL . 'course/addCourse?dan=Invalid Request');
        }
    }

    public function editCourse($course_id)
    {
        require_once '_incSession.php';

        if (!isset($course_id) || empty($course_id)) {
            header('location: ' . URL . 'course/?dan=Invalid operation.');
        }
        $dlaDb = new DLA();
        //$util = new Utility();
        $pre_array = array();

        $course = $dlaDb->getCourse($course_id);
        $courses = $dlaDb->getCourses();
        $course_prerequisites = $dlaDb->getCoursePrerequisite($course_id);

        foreach ($course_prerequisites as $p){
            $pre_array[] = $p->prerequisite_id;
        }
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/course/edit_course.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateCourse()
    {
        if (isset($_POST["name"], $_POST["status"], $_POST["has_prerequisite"], $_POST["course_id"])) {
            $dlaDb = new DLA();

            $insert = $dlaDb->updateCourse($_POST["name"], $_POST["status"], $_POST["has_prerequisite"], $_POST["course_id"]);

            if ($insert) {
                if($_POST["has_prerequisite"] == 1){
                    $dlaDb->deleteCoursePrerequisite($_POST["course_id"]);
                    foreach ($_POST['course'] as $pre_course){
                        $dlaDb->addCoursePrerequisite($_POST["course_id"], $pre_course);
                    }
                }
                header('location: ' . URL . 'course/?msg=Course details updated succesfully.');
            } else {
                header('location: ' . URL . 'course/editCourse/' . $_POST["course_id"] . '?dan=An error occured, please try again later.');
            }
        } else {
            header('location: ' . URL . 'course/?dan=Invalid Request');
        }
    }

    public function deleteCourse($course_id)
    {
        require_once '_incSession.php';

        $dlaDb = new DLA();

        $deletePre = $dlaDb->deleteCoursePrerequisite($course_id);

        $delete = $dlaDb->deleteCourse($course_id);

        if ($delete) {
            header('location: ' . URL . 'course/?msg=Course successfully deleted.');
        } else {
            header('location: ' . URL . 'course/?dan=An error occurred, please try again.');
        }
    }

}
