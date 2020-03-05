<?php

namespace Mini\Controller;

use GuzzleHttp\Psr7\Response;
use function Http\Response\send;
use Mini\Libs\Utility;
use Mini\Model\DLA;

class ApiController
{

    // User
    public function login()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $email = $request->email;
            $password = $request->password;

            $dlaDb = new DLA();
            $util = new Utility();

            $user = $dlaDb->login($email);

            if ($user) {
                $valid = $util->verifyPassword($password, $user->password);
                if ($valid) {
                    $cors = array();
                    $courses = $dlaDb->getStudentCoursesDone($user->user_id);
                    foreach ($courses as $course) {
                        $cors[] = $course->course_id;
                    }
                    $response = array(
                        "error" => false,
                        "user" => array(
                            "user_id" => $util->encryptData($user->user_id),
                            "profile_id" => $util->encryptData($user->profile_id),
                            "auth_token" => $user->auth_token,
                            "email" => $user->email,
                            "firstname" => $user->firstname,
                            "lastname" => $user->lastname,
                            "phone_number" => $user->phone_number,
                            "date_of_birth" => $user->date_of_birth,
                            "type" => $user->type,
                            "matric_number" => $user->matric_number,
                            "gender" => $user->gender,
                            "marital_status" => $user->marital_status,
                            "othername" => $user->othername,
                            "country" => $user->country,
                            "residence_address" => $user->residence_address,
                            "employment_status" => $user->employment_status,
                            "company_name" => $user->company_name,
                            "position_in_company" => $user->position_in_company,
                            "company_address" => $user->company_address,
                            "company_phone_number" => $user->company_phone_number,
                            "company_email" => $user->company_email,
                            "religion" => $user->religion,
                            "name_of_ministry" => $user->name_of_ministry,
                            "courses" => $cors
                        )
                    );
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Invalid username or password"
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Invalid username or password"
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
        // echo json_encode($response);
    }

    public function register()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $account_type = $request->accountType;
            $email = $request->email;
            $password = $request->password;
            $firstname = $request->firstname;
            $lastname = $request->lastname;
            $gender = $request->gender;
            $country = $request->country;
            $marital_status = isset($request->marital_status) ? $request->marital_status : 'SINGLE';
            $othername = isset($request->othername) ? $request->othername : '';
            $phone_number = $request->phone_number;
            $residence_address = $request->residence_address;
            $role_id = $request->role_id;
            $date_of_birth = $request->date_of_birth;

            $dlaDb = new DLA();
            $util = new Utility();

            $userExists = $dlaDb->userExist($email);

            if (!$userExists) {
                $email_token = $util->generateToken(23);

                $account = $dlaDb->createStudentAccount($email, $util->encryptPassword($password), $email_token);

                if ($account) {
                    $insert = $dlaDb->addStudentProfile($account, $account_type, $firstname, $lastname, $othername, $gender, $marital_status, $phone_number, $date_of_birth, $country, $residence_address);

                    if ($insert) {
                        $message = "Thank you for registering for Daystar Leadership Academy, click 'ACTIVATE ACCOUNT' to acticate your account.";
                        $link = 'https://portal.dlaonline.org/confirm-email?bspoke=' . $email_token . '&grad=' . $util->encryptData($account);
                        // Send new password to $email
                        $util->SendActivationEmail($firstname, $email, $message, $link);
                        $response = array(
                            "error" => false,
                            "message" => "Account successfully created. Kindly check your email to activate your account."
                        );
                    } else {
                        $response = array(
                            "error" => true,
                            "message" => "Error occurred creating your profile, please contact administrator."
                        );
                    }
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Error occurred creating your account, please contact administrator."
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Email already exist."
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
        // echo json_encode($response);
    }

    public function activateAccount()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $util = new Utility();
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $user_id = (int)$util->decryptData($request->grad);
            $confirm_email_token = $request->bspoke;

            $dlaDb = new DLA();

            $user = $dlaDb->checkEmailToken($user_id, $confirm_email_token);

            if ($user) {
                $auth_token = $util->generateToken(23);
                $update = $dlaDb->activateGenerateAuthToken($user_id, $auth_token);
                if ($update) {
                    $response = array(
                        "error" => false,
                        "message" => "Your account had been activated successfully. kindly login."
                    );
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Unable to activate your account. kindly contact administrator."
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Error occurred, please try again."
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function resetPassword()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $email = $request->email;

            $dlaDb = new DLA();
            $util = new Utility();

            $userExists = $dlaDb->userExist($email);

            if ($userExists) {
                $new_password = $util->generate_random_string(8);
                $user = $dlaDb->resetPassword($email, $util->encryptPassword($new_password));

                if ($user) {
                    $message = "Your new password is $new_password. kindly change it once you login";
                    // Send new password to $email
                    $util->sendGenericMail($email, $message);
                    $response = array(
                        "error" => false,
                        "message" => "A new password has been generated and sent to your email, kindly check your email for the new password. ",
                    );
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Invalid username or password"
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Email does not exist."
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function changePassword()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dlaDb = new DLA();
            $util = new Utility();

            $headers = getallheaders();
            $auth_token = $headers["Authorization"];

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $user_id = (int)$util->decryptData($request->userId);
            $password = $request->password;

            if ($dlaDb->verifyAuthToken($auth_token)) {
                $user = $dlaDb->changePassword($user_id, $util->encryptPassword($password));

                if ($user) {
                    $response = array(
                        "error" => false,
                        "message" => "Password changed successfully."
                    );
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Error occurred, please try again."
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Invalid Request."
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function updateProfile()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dlaDb = new DLA();
            $util = new Utility();

            $headers = getallheaders();
            $auth_token = $headers["Authorization"];

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $profile_id = (int)$util->decryptData($request->profile_id);
            $email = $request->email;
            $firstname = $request->firstname;
            $lastname = $request->lastname;
            $othername = $request->othername;
            $phone_no = $request->phone_number;
            $gender = $request->gender;
            $marital_status = $request->marital_status;
            $country = $request->country;
            $residence_address = $request->residence_address;
            $employment_status = $request->employment_status;
            $company_name = $request->company_name;
            $position_in_company = $request->position_in_company;
            $company_address = $request->company_address;
            $company_phone_number = $request->company_phone_number;
            $company_email = $request->company_email;
            $religion = $request->religion;
            $name_of_ministry = $request->name_of_ministry;

            if ($dlaDb->verifyAuthToken($auth_token)) {

                $update = $dlaDb->updateStudentProfile($firstname, $lastname, $othername, $gender, $marital_status, $phone_no, $country, $residence_address, $employment_status, $company_name, $position_in_company, $company_address, $company_phone_number, $company_email, $religion, $name_of_ministry, $profile_id);

                if ($update) {
                    $cors = array();
                    $courses = $dlaDb->getStudentCoursesDone($util->decryptData($request->user_id));
                    foreach ($courses as $course) {
                        $cors[] = $course->course_id;
                    }
                    $user = $dlaDb->login($email);
                    $response = array(
                        "error" => false,
                        "message" => "Profile updated successfully.",
                        "user" => array(
                            "user_id" => $util->encryptData($user->user_id),
                            "profile_id" => $util->encryptData($user->profile_id),
                            "auth_token" => $user->auth_token,
                            "email" => $user->email,
                            "firstname" => $user->firstname,
                            "lastname" => $user->lastname,
                            "phone_number" => $user->phone_number,
                            "date_of_birth" => $user->date_of_birth,
                            "type" => $user->type,
                            "matric_number" => $user->matric_number,
                            "gender" => $user->gender,
                            "marital_status" => $user->marital_status,
                            "othername" => $user->othername,
                            "country" => $user->country,
                            "residence_address" => $user->residence_address,
                            "employment_status" => $user->employment_status,
                            "company_name" => $user->company_name,
                            "position_in_company" => $user->position_in_company,
                            "company_address" => $user->company_address,
                            "company_phone_number" => $user->company_phone_number,
                            "company_email" => $user->company_email,
                            "religion" => $user->religion,
                            "name_of_ministry" => $user->name_of_ministry,
                            "courses" => $cors
                        )
                    );
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Error occurred, please try again."
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Invalid Request."
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function getCurrentSessions()
    {
        $response = array();
        $dlaDb = new DLA();
        $util = new Utility();

        $headers = getallheaders();
        $auth_token = $headers["Authorization"];

        if ($dlaDb->verifyAuthToken($auth_token)) {
            $sess = array();
            $sessions = $dlaDb->getActiveSessions();

            foreach ($sessions as $session) {
                $sess[] = array(
                    "session_id" => $util->encryptData($session->id),
                    "course" => $session->name,
                    "course_id" => $session->course_id,
                    "theme" => $session->theme,
                    "fee" => number_format($session->fee, 2, '.', ','),
                    "start_date" => $session->start_date,
                    "end_date" => $session->end_date,
                    "registration_start_date" => $session->registration_start_date,
                    "registration_end_date" => $session->registration_end_date,
                    "training_start" => date('M jS', strtotime($session->start_date)) . ' - ' . date('M jS, Y', strtotime($session->end_date)),
                    "registration" => date('F jS', strtotime($session->registration_start_date)) . ' - ' . date('F jS, Y', strtotime($session->registration_end_date)),
                );
            }

            $response = array(
                "error" => false,
                "sessions" => $sess
            );
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function getSessionAndTimeTable($session_id, $user_id)
    {
        $response = array();
        $dlaDb = new DLA();
        $util = new Utility();

        $headers = getallheaders();
        $auth_token = $headers["Authorization"];

        if ($dlaDb->verifyAuthToken($auth_token)) {
            $session = $dlaDb->getSingleSession((int)$util->decryptData($session_id));
            $user_id = (int)$util->decryptData($user_id);

            if ($session) {
                $prere = array();
                $prerequisites = $dlaDb->getCoursePrerequisite($session->course_id);
                foreach ($prerequisites as $prerequisite) {
                    $prere[] = $prerequisite->prerequisite_id;
                }
                $tt = array();
                $time_tables = $dlaDb->getOutlinesTimeTable((int)$util->decryptData($session_id));
                foreach ($time_tables as $time_table) {
                    $tt[] = array(
                        "name" => $time_table->name,
                        "facilitator" => $time_table->firstname . ' ' . $time_table->lastname,
                        "date" => date('F jS, Y', strtotime($time_table->date)),
                        "start_time" => $time_table->start_time,
                        "end_time" => $time_table->end_time,
                    );
                }
                $tag_no = $dlaDb->getStudentSessionNumber($session->id, $user_id);
                $response = array(
                    "error" => false,
                    "session" => array(
                        "session_id" => $util->encryptData($session->id),
                        "course" => $session->name,
                        "course_id" => $util->encryptData($session->course_id),
                        "c_id" => $session->course_id,
                        "theme" => $session->theme,
                        "fee" => number_format($session->fee, 2, '.', ','),
                        "main_fee" => $session->fee,
                        "start_date" => $session->start_date,
                        "end_date" => $session->end_date,
                        "has_prerequisite" => $session->has_prerequisite,
                        "prerequisite" => $prere,
                        "registration_start_date" => $session->registration_start_date,
                        "registration_end_date" => $session->registration_end_date,
                        "training_start" => date('M jS', strtotime($session->start_date)) . ' - ' . date('M jS, Y', strtotime($session->end_date)),
                        "registration" => date('F jS', strtotime($session->registration_start_date)) . ' - ' . date('F jS, Y', strtotime($session->registration_end_date)),
                        "time_table" => $tt,
                        'tag_no' => $tag_no ? $tag_no->session_number : 0
                    )
                );

            } else {
                $response = array(
                    "error" => true,
                    "message" => "An error occurred, please try again."
                );
            }

        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function makeOfflinePayment()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dlaDb = new DLA();
            $util = new Utility();

            $headers = getallheaders();
            $auth_token = $headers["Authorization"];

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $user_id = (int)$util->decryptData($request->user_id);
            $session_id = (int)$util->decryptData($request->session_id);
            $course_id = (int)$util->decryptData($request->course_id);
            $type = $request->type;
            $has_pre = $request->has_prerequisite;
            $amount = $request->amount;
            $description = $request->description;
            $paid_by = $request->paid_by;
            $hash = $request->hash;
            $payment_date = $request->payment_date;
            $reference_number = $request->reference_number;


            if ($dlaDb->verifyAuthToken($auth_token)) {
                $session_number = $dlaDb->getStudentSessionNumberCount($session_id) + 1;

                $ss = $dlaDb->addStudentSession($session_id, $user_id, $course_id, 1, $session_number);
                $trnx = $dlaDb->addTransaction($user_id, $session_id, $type, $amount, 0, $description, $paid_by, $hash, $payment_date, $reference_number);

                if ($ss && $trnx) {
                    $cors = array();
                    $courses = $dlaDb->getStudentCoursesDone($request->user_id);
                    foreach ($courses as $course) {
                        $cors[] = $course->course_id;
                    }
                    $user = $dlaDb->getUserProfile($user_id);
                    $response = array(
                        "error" => false,
                        "message" => "Payment details received. Your Matric No will be generated upon confirmation.",
                        "user" => array(
                            "user_id" => $util->encryptData($user->user_id),
                            "profile_id" => $util->encryptData($user->profile_id),
                            "auth_token" => $user->auth_token,
                            "email" => $user->email,
                            "firstname" => $user->firstname,
                            "lastname" => $user->lastname,
                            "phone_number" => $user->phone_number,
                            "date_of_birth" => $user->date_of_birth,
                            "type" => $user->type,
                            "matric_number" => $user->matric_number,
                            "gender" => $user->gender,
                            "marital_status" => $user->marital_status,
                            "othername" => $user->othername,
                            "country" => $user->country,
                            "residence_address" => $user->residence_address,
                            "employment_status" => $user->employment_status,
                            "company_name" => $user->company_name,
                            "position_in_company" => $user->position_in_company,
                            "company_address" => $user->company_address,
                            "company_phone_number" => $user->company_phone_number,
                            "company_email" => $user->company_email,
                            "religion" => $user->religion,
                            "name_of_ministry" => $user->name_of_ministry,
                            "courses" => $cors
                        )
                    );
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Error occurred, please try again."
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Invalid Request."
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function makeOnlinePayment()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dlaDb = new DLA();
            $util = new Utility();

            $headers = getallheaders();
            $auth_token = $headers["Authorization"];

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $user_id = (int)$util->decryptData($request->user_id);
            $session_id = (int)$util->decryptData($request->session_id);
            $course_id = (int)$util->decryptData($request->course_id);
            $has_pre = $request->has_prerequisite;
            $type = $request->type;
            $amount = $request->amount;
            $description = $request->description;
            $paid_by = $request->paid_by;
            $hash = $request->hash;
            $payment_date = date("Y-m-d");
            $reference_number = $request->reference_number;


            if ($dlaDb->verifyAuthToken($auth_token)) {
                $session_number = $dlaDb->getStudentSessionNumberCount($session_id) + 1;

                if ($has_pre == 0) {
                    $last_matric = $dlaDb->getlastMatricNo()->matric_number;
                    $matric_number = intval(substr($last_matric, 3)) + 1;
                    $dlaDb->updateProfileMatric('DLA' . $matric_number, $user_id);
                }

                $ss = $dlaDb->addStudentSession($session_id, $user_id, $course_id, 1, $session_number);
                $trnx = $dlaDb->addTransaction($user_id, $session_id, $type, $amount, 0, $description, $paid_by, $hash, $payment_date, $reference_number);

                if ($ss && $trnx) {
                    $cors = array();
                    $courses = $dlaDb->getStudentCoursesDone($request->user_id);
                    foreach ($courses as $course) {
                        $cors[] = $course->course_id;
                    }
                    $user = $dlaDb->getUserProfile($user_id);
                    $response = array(
                        "error" => false,
                        "message" => "Payment details received. Your Matric Number has generated, kindly check your profile for your Matric Number.",
                        "user" => array(
                            "user_id" => $util->encryptData($user->user_id),
                            "profile_id" => $util->encryptData($user->profile_id),
                            "auth_token" => $user->auth_token,
                            "email" => $user->email,
                            "firstname" => $user->firstname,
                            "lastname" => $user->lastname,
                            "phone_number" => $user->phone_number,
                            "date_of_birth" => $user->date_of_birth,
                            "type" => $user->type,
                            "matric_number" => $user->matric_number,
                            "gender" => $user->gender,
                            "marital_status" => $user->marital_status,
                            "othername" => $user->othername,
                            "country" => $user->country,
                            "residence_address" => $user->residence_address,
                            "employment_status" => $user->employment_status,
                            "company_name" => $user->company_name,
                            "position_in_company" => $user->position_in_company,
                            "company_address" => $user->company_address,
                            "company_phone_number" => $user->company_phone_number,
                            "company_email" => $user->company_email,
                            "religion" => $user->religion,
                            "name_of_ministry" => $user->name_of_ministry,
                            "courses" => $cors
                        )
                    );
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Error occurred, please try again."
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Invalid Request."
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function makeDonation()
    {
        $response = array();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dlaDb = new DLA();
            $util = new Utility();

            $headers = getallheaders();
            $auth_token = $headers["Authorization"];

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $user_id = (int)$util->decryptData($request->user_id);
            $session_id = 0;
            $type = $request->type;
            $amount = $request->amount;
            $description = $request->description;
            $paid_by = $request->paid_by;
            $hash = $request->hash;
            $payment_date = $request->payment_date;
            $reference_number = $request->reference_number;
            $status = 0;

            if($type == 'online_payment'){
                $status = 1;
            }


            if ($dlaDb->verifyAuthToken($auth_token)) {

                $trnx = $dlaDb->addTransaction($user_id, $session_id, $type, $amount, $status, $description, $paid_by, $hash, $payment_date, $reference_number);

                if ($trnx) {
                    $response = array(
                        "error" => false,
                        "message" => "Donation received. Thank you.",
                    );
                } else {
                    $response = array(
                        "error" => true,
                        "message" => "Error occurred, please try again."
                    );
                }
            } else {
                $response = array(
                    "error" => true,
                    "message" => "Invalid Request."
                );
            }
        } else {
            $response = array(
                "error" => true,
                "message" => "Invalid Request."
            );
        }

        $main_response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode($response), $version = '1.1');

        send($main_response);
    }

    public function getHeaders()
    {
        $headers = getallheaders();
        echo json_encode($headers["Authorization"]);

        // $headers = getallheaders();
        // $contentName = $headers['Content-Type'];
        // throw new \ErrorException($postdata);
    }

    public function testResponse()
    {
        $response = new Response($status = 200, $headers = [
            'Content-Type' => 'text/json'
        ], $body = json_encode([
            'reponse' => uniqid(true)
        ]), $version = '1.1');

        send($response);
    }

    public function TestEncrypt()
    {
        $util = new Utility();

        $message = $util->encryptData(3095);
        echo json_encode(array(
            'message' => $message
        ));
    }

    public function TestDecrypt($crypted)
    {
        $util = new Utility();

        $message = $util->decryptData($crypted);
        echo json_encode(array(
            'message' => $message
        ));
    }
}
