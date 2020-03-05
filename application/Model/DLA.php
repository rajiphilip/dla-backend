<?php

namespace Mini\Model;

use Mini\Core\Model;

class DLA extends Model
{

    public function getUserByEmail($email)
    {
        $sql = "SELECT u.id as user_id, u.role_id, u.email, u.password, p.id as profile_id, p.type, p.firstname, p.lastname  FROM users u, profiles p  WHERE u.id = p.user_id AND u.is_banned = 0 AND u.email_confirmed = 1 AND u.role_id NOT IN (4, 5) AND u.email = :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function getFacilitators()
    {
        $sql = "SELECT user_id, firstname, lastname FROM profiles WHERE type = :type ORDER BY firstname ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':type' => 'FACILITATOR'
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getStudentInSession($session_id)
    {
        $sql = "SELECT p.user_id, p.firstname, p.lastname FROM profiles p, session_students s WHERE p.user_id = s.student_id AND s.session_id = :session_id ORDER BY firstname ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    // Courses

    public function getCourses()
    {
        $sql = "SELECT * FROM courses ORDER BY id ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getCourse($course_id)
    {
        $sql = "SELECT * FROM courses WHERE id = :course_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':course_id' => $course_id);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function getCoursePrerequisite($course_id)
    {
        $sql = "SELECT * FROM course_prerequisites WHERE course_id = :course_id ORDER BY id ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(':course_id' => $course_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function addCourse($name, $status, $has_prerequisite)
    {
        $sql = "INSERT INTO courses (name, status, has_prerequisite, created_at, updated_at) VALUES (:name, :status, :has_prerequisite, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(':name' => $name, ':status' => $status, ':has_prerequisite' => $has_prerequisite);
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function addCoursePrerequisite($course_id, $prerequisite_id)
    {
        $sql = "INSERT INTO course_prerequisites (course_id, prerequisite_id, status, created_at, updated_at) VALUES (:course_id, :prerequisite_id, 1, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(':course_id' => $course_id, ':prerequisite_id' => $prerequisite_id);
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function deleteCourse($course_id)
    {
        $sql = "DELETE FROM courses WHERE id = :course_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':course_id' => $course_id);

        return $query->execute($parameters);
    }

    public function deleteCoursePrerequisite($course_id)
    {
        $sql = "DELETE FROM course_prerequisites WHERE course_id = :course_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':course_id' => $course_id);

        $query->execute($parameters);
    }

    public function updateCourse($name, $status, $has_prerequisite, $course_id)
    {
        $sql = "UPDATE courses SET name = :name, status = :status, has_prerequisite = :has_prerequisite WHERE id = :course_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':name' => $name, ':status' => $status, ':has_prerequisite' => $has_prerequisite, ':course_id' => $course_id);
        return $query->execute($parameters);
    }

    // Outline Time Table

    public function getSessions()
    {
        $sql = "SELECT s.id, s.status, c.name, s.start_date, s.end_date, s.registration_start_date, s.registration_end_date, s.fee, s.theme, s.created_at, s.updated_at FROM sessions s, courses c WHERE c.id = s.course_id ORDER BY s.start_date DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getActiveSessions()
    {
        $sql = "SELECT s.id, s.status, c.id AS course_id, c.name, s.start_date, s.end_date, s.registration_start_date, s.registration_end_date, s.fee, s.theme, s.created_at, s.updated_at FROM sessions s, courses c WHERE s.status in (2, 3) AND c.id = s.course_id ORDER BY s.start_date ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getSession($session_id)
    {
        $sql = "SELECT * FROM sessions WHERE id = :session_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':session_id' => $session_id);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function addSession($status, $course_id, $start_date, $end_date, $registration_start_date, $registration_end_date, $fee, $theme)
    {
        $sql = "INSERT INTO sessions (status, course_id, start_date, end_date, registration_start_date, registration_end_date, fee, theme, created_at, updated_at) VALUES (:status, :course_id, :start_date, :end_date, :registration_start_date, :registration_end_date, :fee, :theme, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':status' => $status,
            ':course_id' => $course_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':registration_start_date' => $registration_start_date,
            ':registration_end_date' => $registration_end_date,
            ':fee' => $fee,
            ':theme' => $theme
        );
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function updateSession($status, $course_id, $start_date, $end_date, $registration_start_date, $registration_end_date, $fee, $theme, $session_id)
    {
        $sql = "UPDATE sessions SET status = :status, course_id = :course_id, start_date = :start_date, end_date = :end_date, registration_start_date = :registration_start_date, registration_end_date = :registration_end_date, fee = :fee, theme = :theme WHERE id = :session_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':status' => $status,
            ':course_id' => $course_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':registration_start_date' => $registration_start_date,
            ':registration_end_date' => $registration_end_date,
            ':fee' => $fee,
            ':theme' => $theme,
            ':session_id' => $session_id
        );
        return $query->execute($parameters);
    }

    public function deleteSession($session_id)
    {
        $sql = "DELETE FROM sessions WHERE id = :session_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':session_id' => $session_id);

        return $query->execute($parameters);
    }

    // Outline

    public function getOutlines()
    {
        $sql = "SELECT * FROM outlines ORDER BY name ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getOutline($outline_id)
    {
        $sql = "SELECT * FROM outlines WHERE id = :outline_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':outline_id' => $outline_id);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function addOutline($name, $code, $description)
    {
        $sql = "INSERT INTO outlines (name, code, description, created_at, updated_at) VALUES (:name, :code, :description, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':name' => $name,
            ':code' => $code,
            ':description' => $description
        );
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function updateOutline($name, $code, $description, $outline_id)
    {
        $sql = "UPDATE outlines SET name = :name, code = :code, description = :description WHERE id = :outline_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':name' => $name,
            ':code' => $code,
            ':description' => $description,
            ':outline_id' => $outline_id
        );
        return $query->execute($parameters);
    }

    public function deleteOutline($outline_id)
    {
        $sql = "DELETE FROM outlines WHERE id = :outline_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':outline_id' => $outline_id);

        return $query->execute($parameters);
    }


    // Outline Time Table

    public function getOutlinesTimeTable($session_id)
    {
        $sql = "SELECT f.id, s.theme, p.firstname, p.lastname,  o.name, f.date, f.start_time, f.end_time, f.created_at, f.updated_at FROM facilitator_session_outlines f, sessions s, outlines o, profiles p WHERE f.facilitator_id = p.user_id AND f.outline_id = o.id AND f.session_id = s.id AND f.session_id = :session_id ORDER BY f.date DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(':session_id' => $session_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getOutlineTimeTable($id)
    {
        $sql = "SELECT * FROM facilitator_session_outlines WHERE id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function addOutlineTimeTable($session_id, $facilitator_id, $outline_id, $date, $start_time, $end_time)
    {
        $sql = "INSERT INTO facilitator_session_outlines (session_id, facilitator_id, outline_id, date, start_time, end_time, created_at, updated_at) VALUES (:session_id, :facilitator_id, :outline_id, :date, :start_time, :end_time, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id,
            ':facilitator_id' => $facilitator_id,
            ':outline_id' => $outline_id,
            ':date' => $date,
            ':start_time' => $start_time,
            ':end_time' => $end_time
        );
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function updateOutlineTimeTable($session_id, $facilitator_id, $outline_id, $date, $start_time, $end_time, $id)
    {
        $sql = "UPDATE facilitator_session_outlines SET session_id = :session_id, facilitator_id = :facilitator_id, outline_id = :outline_id, date = :date, start_time = :start_time, end_time = :end_time WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id,
            ':facilitator_id' => $facilitator_id,
            ':outline_id' => $outline_id,
            ':date' => $date,
            ':start_time' => $start_time,
            ':end_time' => $end_time,
            ':id' => $id
        );
        return $query->execute($parameters);
    }

    public function deleteOutlineTimeTable($id)
    {
        $sql = "DELETE FROM facilitator_session_outlines WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);

        return $query->execute($parameters);
    }

    public function getSessionRemOutline($session_id)
    {
        $sql = "SELECT id, name FROM outlines WHERE id NOT IN (SELECT outline_id FROM facilitator_session_outlines WHERE session_id = :session_id) ORDER BY name ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(':session_id' => $session_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    //Message
    public function getMyMessages($user_id)
    {
        $sql = "SELECT m.id, p.firstname, p.lastname, m.body, m.subject, m.time_sent, m.is_read FROM messages m, profiles p WHERE m.receiver_id = p.user_id AND m.sender_id = :sender_id ORDER BY m.time_sent DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(':sender_id' => $user_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function addMessage($sender_id, $receiver_id, $subject, $body)
    {
        $sql = "INSERT INTO messages (sender_id, receiver_id, subject, body, time_sent, is_read, created_at, updated_at) VALUES (:sender_id, :receiver_id, :subject, :body, NOW(), 0, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':sender_id' => $sender_id,
            ':receiver_id' => $receiver_id,
            ':subject' => $subject,
            ':body' => $body
        );
        $query->execute($parameters);
        return $this->db->lastInsertId();
    }

    //Forum
    public function getForums()
    {
        $sql = "SELECT f.id, p.firstname, p.lastname, f.title, f.post, f.status, f.no_of_likes, f.posted_at FROM forums f, profiles p WHERE f.user_id = p.user_id ORDER BY f.posted_at DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getForum($forum_id)
    {
        $sql = "SELECT f.id, p.firstname, p.lastname, f.title, f.post, f.status, f.posted_at FROM forums f, profiles p WHERE f.user_id = p.user_id AND f.id = :forum_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':forum_id' => $forum_id);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function getForumComment($forum_id)
    {
        $sql = "SELECT fc.id, p.firstname, p.lastname, fc.post, fc.status, fc.no_of_likes, fc.created_at FROM forum_comments fc, profiles p WHERE fc.user_id = p.user_id AND fc.forum_id = :forum_id ORDER BY created_at DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(':forum_id' => $forum_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    //Feedback
    public function getFeedbackQuestions()
    {
        $sql = "SELECT fq.id, ft.type, fq.question, fq.created_at FROM feedback_questions fq, feedback_type ft WHERE fq.type = ft.id ORDER BY id ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getFeedbackQuestion($feedback_id)
    {
        $sql = "SELECT id, type, question FROM feedback_questions WHERE id = :feedback_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':feedback_id' => $feedback_id);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function addFeedbackQuestion($type, $question)
    {
        $sql = "INSERT INTO feedback_questions (type, question, created_at, updated_at) VALUES (:type, :question, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':type' => $type,
            ':question' => $question
        );
        $query->execute($parameters);
        return $this->db->lastInsertId();
    }

    public function deleteFeedbackQuestion($feedback_id)
    {
        $sql = "DELETE FROM feedback_questions WHERE id = :feedback_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':feedback_id' => $feedback_id);

        return $query->execute($parameters);
    }

    public function updateFeedbackQuestion($type, $question, $feedback_id)
    {
        $sql = "UPDATE feedback_questions SET type = :type, question = :question WHERE id = :feedback_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':type' => $type,
            ':question' => $question,
            ':feedback_id' => $feedback_id
        );
        return $query->execute($parameters);
    }

    public function getFeedbackTypes()
    {
        $sql = "SELECT id, type, created_at FROM feedback_type ORDER BY type ASC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getFeedbackType($feedback_type_id)
    {
        $sql = "SELECT id, type FROM feedback_type WHERE id = :feedback_type_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':feedback_type_id' => $feedback_type_id);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function addFeedbackType($type)
    {
        $sql = "INSERT INTO feedback_type (type, created_at, updated_at) VALUES (:type, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':type' => $type
        );
        $query->execute($parameters);
        return $this->db->lastInsertId();
    }

    public function deleteFeedbackType($feedback_type_id)
    {
        $sql = "DELETE FROM feedback_type WHERE id = :feedback_type_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':feedback_type_id' => $feedback_type_id);

        return $query->execute($parameters);
    }

    public function updateFeedbackType($type, $feedback_type_id)
    {
        $sql = "UPDATE feedback_type SET type = :type WHERE id = :feedback_type_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':type' => $type,
            ':feedback_type_id' => $feedback_type_id
        );
        return $query->execute($parameters);
    }

    public function getFacilitatorsInSession($session_id)
    {
        $sql = "SELECT user_id, firstname, lastname FROM profiles WHERE user_id IN (SELECT facilitator_id FROM facilitator_session_outlines WHERE session_id = :session_id) ORDER BY firstname ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getFeedback($session_id, $facilitator_id)
    {
        $sql = "SELECT fq.question, (SELECT type FROM feedback_type WHERE id = f.type) as type,  f.feedback_question_id, AVG(f.rate) AS rating FROM feedback f, feedback_questions fq WHERE f.feedback_question_id = fq.id AND f.facilitator_id = :facilitator_id AND f.session_id = :session_id  GROUP BY feedback_question_id ORDER BY fq.question ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id,
            ':facilitator_id' => $facilitator_id
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getAllTransaction($session_id)
    {
        $sql = "SELECT t.id, p.user_id, p.firstname, p.lastname,  t.type, t.amount, t.status, t.paid_by, t.payment_date, t.reference_number FROM transactions t, profiles p WHERE p.user_id = t.user_id AND t.session_id = :session_id ORDER BY t.payment_date DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getAllApprovedTransaction($session_id)
    {
        $sql = "SELECT t.id, p.firstname, p.lastname,  t.type, t.amount, t.status, t.paid_by, t.payment_date, t.reference_number FROM transactions t, profiles p WHERE p.user_id = t.user_id AND t.session_id = :session_id AND t.status = 1 ORDER BY t.payment_date DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getAllUnapprovedTransaction($session_id)
    {
        $sql = "SELECT t.id, p.user_id, p.firstname, p.lastname,  t.type, t.amount, t.status, t.paid_by, t.payment_date, t.reference_number FROM transactions t, profiles p WHERE p.user_id = t.user_id AND t.session_id = :session_id  AND t.status = 0  ORDER BY t.payment_date DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getlastMatricNo()
    {
        $sql = "SELECT matric_number FROM profiles ORDER BY matric_number DESC LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function updateTransactionStatus($transaction_id)
    {
        $sql = "UPDATE transactions SET status = 1 WHERE id = :transaction_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':transaction_id' => $transaction_id
        );
        return $query->execute($parameters);
    }

    public function updateProfileMatric($matric_no, $user_id)
    {
        $sql = "UPDATE profiles SET matric_number = :matric_number WHERE user_id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':matric_number' => $matric_no,
            ':user_id' => $user_id
        );
        return $query->execute($parameters);
    }

    //Users
    public function getListOfFacilitators()
    {
        $sql = "SELECT u.email, p.id, p.user_id, p.firstname, p.lastname, p.othername, p.gender, p.marital_status, p.phone_number FROM profiles p, users u WHERE p.user_id = u.id AND p.type = :type ORDER BY firstname ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':type' => 'FACILITATOR'
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function createAccount($email, $password)
    {
        $sql = "INSERT INTO users (email, password, role_id, email_confirmed, created_at, updated_at) VALUES (:email, :password, 4, 1, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':email' => $email,
            ':password' => $password
        );
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function addFacilitator($user_id, $type, $firstname, $lastname, $othername, $gender, $marital_status, $phone_number, $facebook, $instagram, $twitter)
    {
        $sql = "INSERT INTO profiles(user_id, type, firstname, lastname, othername, gender, marital_status, phone_number, facebook, instagram, twitter, created_at, updated_at) VALUES (:user_id, :type, :firstname, :lastname, :othername, :gender, :marital_status, :phone_number, :facebook, :instagram, :twitter, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':user_id' => $user_id,
            ':type' => $type,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':othername' => $othername,
            ':gender' => $gender,
            ':marital_status' => $marital_status,
            ':phone_number' => $phone_number,
            ':facebook' => $facebook,
            ':instagram' => $instagram,
            ':twitter' => $twitter
        );
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function getFacilitator($id)
    {
        $sql = "SELECT id, user_id, firstname, lastname, othername, gender, marital_status, phone_number, facebook, instagram, twitter FROM profiles WHERE id = :id AND type = :type LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':id' => $id,
            ':type' => 'FACILITATOR'
        );
        $query->execute($parameters);
        return $query->fetch();
    }

    public function updateFacilitator($firstname, $lastname, $othername, $gender, $marital_status, $phone_number, $facebook, $instagram, $twitter, $id)
    {
        $sql = "UPDATE profiles SET firstname = :firstname, lastname = :lastname, othername = :othername, gender = :gender, marital_status = :marital_status, phone_number = :phone_number, facebook = :facebook, instagram = :instagram, twitter = :twitter, updated_at = NOW() WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':othername' => $othername,
            ':gender' => $gender,
            ':marital_status' => $marital_status,
            ':phone_number' => $phone_number,
            ':facebook' => $facebook,
            ':instagram' => $instagram,
            ':twitter' => $twitter,
            ':id' => $id
        );
        return $query->execute($parameters);
    }

    public function getListOfStudents($session_id)
    {
        $sql = "SELECT u.email, p.user_id, p.firstname, p.lastname, p.othername, p.gender, p.marital_status, p.phone_number FROM profiles p, users u, session_students ss WHERE p.user_id = u.id AND ss.student_id = p.user_id AND ss.session_id = :session_id ORDER BY firstname ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function blockUser($user_id)
    {
        $sql = "UPDATE users SET is_banned = 1 WHERE id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':user_id' => $user_id
        );
        return $query->execute($parameters);
    }

    public function resetUser($auth_token, $confirm_email_token, $remember_token, $user_id)
    {
        $sql = "UPDATE users SET auth_token = :auth_token, confirm_email_token = :confirm_email_token, remember_token = :remember_token WHERE id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':auth_token' => $auth_token,
            ':confirm_email_token' => $confirm_email_token,
            ':remember_token' => $remember_token,
            ':user_id' => $user_id
        );
        return $query->execute($parameters);
    }

    public function getStudent($id)
    {
        $sql = "SELECT u.id, u.email, p.user_id, p.type, p.matric_number, p.firstname, p.lastname, p.othername, p.gender, p.marital_status, p.phone_number, p.date_of_birth, p.country, p.residence_address, p.employment_status, p.company_name, p.position_in_company, p.company_address, p.company_phone_number, p.company_email, p.religion, p.name_of_ministry, p.facebook, p.instagram, p.twitter, p.created_at FROM profiles p, users u WHERE p.user_id = u.id AND u.id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':id' => $id,
        );
        $query->execute($parameters);
        return $query->fetch();
    }

    public function getStudentSessionDetails($id)
    {
        $sql = "SELECT c.name, s.start_date, s.end_date, s.fee, s.theme, ss.session_number FROM sessions s, session_students ss, courses c WHERE s.id = ss.session_id AND c.id = ss.course_id AND ss.student_id = :student_id ORDER BY s.start_date ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':student_id' => $id,
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getStudentTransactionDetails($id)
    {
        $sql = "SELECT c.name, s.start_date, s.end_date, s.fee, s.theme, t.type, t.amount, t.status, t.description, t.paid_by, t.payment_date, t.reference_number FROM sessions s, transactions t, courses c WHERE s.id = t.session_id AND c.id = s.course_id AND t.user_id = :user_id ORDER BY s.start_date ASC";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':user_id' => $id,
        );
        $query->execute($parameters);
        return $query->fetchAll();
    }

//API
    public function login($email)
    {
        $sql = "SELECT u.id as user_id, u.role_id, u.auth_token, u.email, u.password,p.matric_number, p.gender, p.marital_status, phone_number, p.date_of_birth,  p.id as profile_id, p.type, p.firstname, p.lastname, p.othername, p.country, p.residence_address, p.employment_status, p.company_name, p.position_in_company, p.company_address, p.company_phone_number, p.company_email, p.religion, p.name_of_ministry FROM users u, profiles p  WHERE u.id = p.user_id AND u.is_banned = 0 AND u.email_confirmed = 1 AND u.role_id = 5 AND u.email = :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function getUserProfile($user_id)
    {
        $sql = "SELECT u.id as user_id, u.role_id, u.auth_token, u.email, u.password,p.matric_number, p.gender, p.marital_status, phone_number, p.date_of_birth,  p.id as profile_id, p.type, p.firstname, p.lastname, p.othername, p.country, p.residence_address, p.employment_status, p.company_name, p.position_in_company, p.company_address, p.company_phone_number, p.company_email, p.religion, p.name_of_ministry FROM users u, profiles p  WHERE u.id = p.user_id AND u.is_banned = 0 AND u.email_confirmed = 1 AND u.role_id = 5 AND u.id = :user_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);

        $query->execute($parameters);
        return $query->fetch();
    }

    public function userExist($email)
    {
        $sql = "SELECT email FROM users WHERE email = :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':email' => $email
        );

        $query->execute($parameters);

        return ($query->fetch()) ? true : false;
    }

    public function resetPassword($email, $password)
    {
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $query = $this->db->prepare($sql);
        $parameters = array(':password' => $password, ':email' => $email);

        return $query->execute($parameters);
    }

    public function changePassword($user_id, $password)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':password' => $password, ':user_id' => $user_id);

        return $query->execute($parameters);
    }

    public function createStudentAccount($email, $password, $email_token)
    {
        $sql = "INSERT INTO users (email, password, role_id, email_confirmed, confirm_email_token, created_at, updated_at) VALUES (:email, :password, 5, 0, :confirm_email_token, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':email' => $email,
            ':password' => $password,
            ':confirm_email_token' => $email_token
        );
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function addStudentProfile($user_id, $account_type, $firstname, $lastname, $othername, $gender, $marital_status, $phone_number, $date_of_birth, $country, $residence_address)
    {
        $sql = "INSERT INTO profiles(user_id, type, firstname, lastname, othername, gender, marital_status, phone_number, date_of_birth, country, residence_address, created_at, updated_at) VALUES (:user_id, :type, :firstname, :lastname, :othername, :gender, :marital_status, :phone_number, :date_of_birth, :country, :residence_address, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':user_id' => $user_id,
            ':type' => $account_type,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':othername' => $othername,
            ':gender' => $gender,
            ':marital_status' => $marital_status,
            ':phone_number' => $phone_number,
            ':date_of_birth' => $date_of_birth,
            ':country' => $country,
            ':residence_address' => $residence_address
        );
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function getUser($user_id)
    {
        $sql = "SELECT user_id, name, email, mobile, registered_at FROM users WHERE user_id = :user_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);

        $query->execute($parameters);
        return $query->fetch();
    }

    public function getUserByOrder($order_id)
    {
        $sql = "SELECT user_id, name, email, mobile, registered_at FROM users WHERE user_id = (SELECT user_id FROM transactions WHERE reference = :order_id LIMIT 1) LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':order_id' => $order_id);

        $query->execute($parameters);
        return $query->fetch();
    }

    public function register($name, $email, $mobile, $password)
    {
        $sql = "INSERT INTO users (name, email, mobile, password, registered_at) VALUES (:name, :email, :mobile, SHA1(:password), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':name' => $name,
            ':email' => $email,
            ':mobile' => $mobile,
            ':password' => SALT . $password
        );

        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

//    public function addTransaction($user_id, $product_id, $category, $merchant, $product, $ip_address, $amount, $vendor_parameter_value)
//    {
//        $sql = "INSERT INTO transactions (user_id, product_id, category, merchant, product, ip_address, amount, vendor_parameter_value, created_at) VALUES (:user_id, :product_id, :category, :merchant, :product, :ip_address, :amount, :vendor_parameter_value, NOW())";
//        $query = $this->db->prepare($sql);
//        $parameters = array(
//            ':user_id' => $user_id,
//            ':product_id' => $product_id,
//            ':category' => $category,
//            ':merchant' => $merchant,
//            ':product' => $product,
//            ':ip_address' => $ip_address,
//            ':amount' => $amount,
//            ':vendor_parameter_value' => $vendor_parameter_value
//        );
//
//        $query->execute($parameters);
//
//        return $this->db->lastInsertId();
//    }

    public function updateReference($trans_id, $reference)
    {
        $sql = "UPDATE transactions SET reference = :reference WHERE trans_id = :trans_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':reference' => $reference,
            ':trans_id' => $trans_id
        );

        return $query->execute($parameters);
    }

    public function updatePaymentResponse($reference, $response, $response_json, $status)
    {
        $sql = "UPDATE transactions SET response = :response, response_json = :response_json, status = :status, created_at = NOW() WHERE reference = :reference";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':response' => $response,
            ':response_json' => $response_json,
            ':status' => $status,
            ':reference' => $reference
        );

        return $query->execute($parameters);
    }

    public function getTransactions($user_id)
    {
        $sql = "SELECT category, merchant, product, ip_address, amount, vendor_parameter_value, status, reference, response, created_at FROM transactions WHERE user_id = :user_id ORDER BY created_at DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function checkEmailToken($user_id, $confirm_email_token)
    {
        $sql = "SELECT * FROM users WHERE id = :user_id  AND confirm_email_token = :confirm_email_token LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':user_id' => $user_id,
            ':confirm_email_token' => $confirm_email_token
        );
        $query->execute($parameters);
        return $query->fetch();
    }

    public function activateGenerateAuthToken($user_id, $auth_token)
    {
        $sql = "UPDATE users SET email_confirmed = 1, email_verified_at = NOW(), auth_token = :auth_token WHERE id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':auth_token' => $auth_token,
            ':user_id' => $user_id
        );

        return $query->execute($parameters);
    }

    public function verifyAuthToken($token)
    {
        $sql = "SELECT * FROM users WHERE auth_token = :auth_token LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':auth_token' => $token);

        $query->execute($parameters);
        return $query->fetch() ? true : false;
    }

    public function verifyUserAuthToken($user_id, $token)
    {
        $sql = "SELECT * FROM users WHERE user_id = :user_id AND auth_token = :auth_token  LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':user_id' => $user_id,
            ':auth_token' => $token
        );

        $query->execute($parameters);
        return $query->fetch() ? true : false;
    }

    public function updateStudentProfile($firstname, $lastname, $othername, $gender, $marital_status, $phone_number, $country, $residence_address, $employment_status, $company_name, $position_in_company, $company_address, $company_phone_number, $company_email, $religion, $name_of_ministry, $profile_id)
    {
        $sql = "UPDATE profiles SET firstname = :firstname, lastname = :lastname, othername = :othername, gender = :gender, marital_status = :marital_status, phone_number = :phone_number, country = :country, residence_address = :residence_address, employment_status = :employment_status, company_name = :company_name, position_in_company = :position_in_company, company_address = :company_address, company_phone_number = :company_phone_number, company_email = :company_email, religion = :religion, name_of_ministry = :name_of_ministry, updated_at = NOW() WHERE id = :profile_id";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':othername' => $othername,
            ':gender' => $gender,
            ':marital_status' => $marital_status,
            ':phone_number' => $phone_number,
            ':country' => $country,
            ':residence_address' => $residence_address,
            ':employment_status' => $employment_status,
            ':company_name' => $company_name,
            ':position_in_company' => $position_in_company,
            ':company_address' => $company_address,
            ':company_phone_number' => $company_phone_number,
            ':company_email' => $company_email,
            ':religion' => $religion,
            ':name_of_ministry' => $name_of_ministry,
            ':profile_id' => $profile_id
        );

        $query->execute($parameters);

        return $query->execute($parameters);
    }

    public function getStudentCoursesDone($user_id)
    {
        $sql = "SELECT course_id FROM session_students WHERE student_id = :student_id ORDER BY course_id DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(':student_id' => $user_id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getSingleSession($session_id)
    {
        $sql = "SELECT s.id, s.status, c.id AS course_id, c.name, c.has_prerequisite, s.start_date, s.end_date, s.registration_start_date, s.registration_end_date, s.fee, s.theme, s.created_at, s.updated_at FROM sessions s, courses c WHERE s.status in (2, 3) AND c.id = s.course_id AND s.id = :session_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':session_id' => $session_id);
        $query->execute($parameters);
        return $query->fetch();
    }

    public function getStudentSessionNumberCount($session_id)
    {
        $sql = "SELECT COUNT(*) AS session_number FROM session_students WHERE session_id = :session_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':session_id' => $session_id);
        $query->execute($parameters);
        return $query->fetch()->session_number;
    }

    public function addStudentSession($session_id, $student_id, $course_id, $status, $session_number)
    {
        $sql = "INSERT INTO session_students (session_id, student_id, course_id, status, session_number, created_at, updated_at) VALUES (:session_id, :student_id, :course_id, :status, :session_number, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':session_id' => $session_id,
            ':student_id' => $student_id,
            ':course_id' => $course_id,
            ':status' => $status,
            ':session_number' => $session_number
        );

        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function addTransaction($user_id, $session_id, $type, $amount, $status, $description, $paid_by, $hash, $payment_date, $reference_number)
    {
        $sql = "INSERT INTO transactions (user_id, session_id, type, amount, status, description, paid_by, hash, payment_date, reference_number, created_at, updated_at) VALUES (:user_id, :session_id, :type, :amount, :status, :description, :paid_by, :hash, :payment_date, :reference_number, NOW(), NOW())";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':user_id' => $user_id,
            ':session_id' => $session_id,
            ':type' => $type,
            ':amount' => $amount,
            ':status' => $status,
            ':description' => $description,
            ':paid_by' => $paid_by,
            ':hash' => $hash,
            ':payment_date' => $payment_date,
            ':reference_number' => $reference_number
        );

        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function getStudentSessionNumber($session_id, $user_id)
    {
        $sql = "SELECT * FROM session_students WHERE session_id = :session_id AND student_id = :student_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':session_id' => $session_id,':student_id' => $user_id);
        $query->execute($parameters);
        return $query->fetch();
    }
}
