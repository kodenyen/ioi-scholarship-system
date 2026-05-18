<?php

class Admin extends Controller {
    public function __construct() {
        $this->adminModel = $this->model('AdminModel');
        $this->sponsorModel = $this->model('SponsorModel');
        $this->studentModel = $this->model('StudentModel');
        $this->formModel = $this->model('FormModel');
        $this->assignmentModel = $this->model('AssignmentModel');
        $this->messageModel = $this->model('MessageModel');
    }

    public function index() {
        if (!isLoggedIn()) {
            redirect('admin/login');
        }
        redirect('admin/dashboard');
    }

    public function moderation() {
        if (!isLoggedIn()) redirect('admin/login');
        
        $messages = $this->messageModel->getPendingMessages();
        foreach($messages as $message) {
            $message->responses = $this->messageModel->getMessageResponses($message->id);
        }
        $data = ['messages' => $messages];
        $this->view('admin/moderation/index', $data);
    }

    public function approve($id) {
        if (!isLoggedIn()) redirect('admin/login');
        if ($this->messageModel->updateStatus($id, 'approved')) {
            // Send Notification Email
            $message = $this->messageModel->getMessageById($id);
            if ($message) {
                $subject = "New Message from Scholar: " . $message->sender_name;
                
                // Format the email body
                $body = "
                    <div style='font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif; padding: 30px; border: 1px solid #f0f0f0; border-radius: 15px; max-width: 600px; margin: 0 auto; color: #333;'>
                        <div style='text-align: center; margin-bottom: 25px;'>
                            <h2 style='color: #005BFF; margin: 0;'>IOI Scholarship Program</h2>
                            <p style='color: #888; font-size: 0.9rem;'>Communication Portal Notification</p>
                        </div>
                        
                        <p>Hello <strong>{$message->receiver_name}</strong>,</p>
                        <p>You have received a new message from <strong>{$message->sender_name}</strong> through the scholarship communication portal.</p>
                        
                        <div style='padding: 20px; background: #f8f9fa; border-left: 4px solid #005BFF; border-radius: 5px; margin: 25px 0; font-style: italic; color: #444; line-height: 1.6;'>
                            \"{$message->content}\"
                        </div>
                        
                        <p style='margin-bottom: 30px;'>Please log in to your dashboard to view full conversation and reply.</p>
                        
                        <div style='text-align: center;'>
                            <a href=\"" . URLROOT . "\" style='background: #005BFF; color: white; padding: 14px 35px; text-decoration: none; border-radius: 10px; font-weight: bold; display: inline-block; box-shadow: 0 4px 15px rgba(0,91,255,0.2);'>Access Dashboard</a>
                        </div>
                        
                        <div style='margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; font-size: 0.8rem; color: #999; text-align: center;'>
                            <p>This is an automated notification from the IOI Scholarship Program.<br>Please do not reply directly to this email.</p>
                        </div>
                    </div>
                ";
                
                sendEmail($message->receiver_email, $subject, $body);
            }

            flash('moderation_message', 'Message Approved and notification sent to receiver');
            redirect('admin/moderation');
        }
    }

    public function reject($id) {
        if (!isLoggedIn()) redirect('admin/login');
        if ($this->messageModel->updateStatus($id, 'rejected')) {
            flash('moderation_message', 'Message Rejected');
            redirect('admin/moderation');
        }
    }

    public function forms() {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'label' => trim($_POST['label']),
                'type' => trim($_POST['type']),
                'assigned_to' => trim($_POST['assigned_to']),
                'options' => trim($_POST['options']),
                'label_err' => ''
            ];

            if (empty($data['label'])) $data['label_err'] = 'Please enter label';

            if (empty($data['label_err'])) {
                if ($this->formModel->addField($data)) {
                    flash('form_message', 'Field Added');
                    redirect('admin/forms');
                } else {
                    die('Something went wrong');
                }
            } else {
                $fields = $this->formModel->getFields();
                $data['fields'] = $fields;
                $this->view('admin/forms/index', $data);
            }
        } else {
            $fields = $this->formModel->getFields();
            $data = [
                'fields' => $fields,
                'label' => '', 'type' => 'text', 'assigned_to' => 'sponsor', 'options' => '', 'label_err' => ''
            ];
            $this->view('admin/forms/index', $data);
        }
    }

    public function delete_field($id) {
        if (!isLoggedIn()) redirect('admin/login');
        if ($this->formModel->deleteField($id)) {
            flash('form_message', 'Field Removed');
            redirect('admin/forms');
        } else {
            die('Something went wrong');
        }
    }

    public function assignments() {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sponsor_id = $_POST['sponsor_id'];
            $student_id = $_POST['student_id'];
            if ($this->assignmentModel->assign($sponsor_id, $student_id)) {
                flash('assignment_message', 'Student Assigned');
                redirect('admin/assignments');
            }
        }

        $assignments = $this->assignmentModel->getAssignments();
        $sponsors = $this->sponsorModel->getSponsors();
        $students = $this->studentModel->getStudents();
        $data = [
            'assignments' => $assignments,
            'sponsors' => $sponsors,
            'students' => $students
        ];
        $this->view('admin/assignments/index', $data);
    }

    public function unassign($sponsor_id, $student_id) {
        if (!isLoggedIn()) redirect('admin/login');
        if ($this->assignmentModel->unassign($sponsor_id, $student_id)) {
            flash('assignment_message', 'Assignment Removed');
            redirect('admin/assignments');
        }
    }

    public function sponsors() {
        if (!isLoggedIn()) redirect('admin/login');

        // Pagination
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalSponsors = $this->sponsorModel->getSponsorCount();
        $totalPages = ceil($totalSponsors / $limit);

        $sponsors = $this->sponsorModel->getSponsors($limit, $offset);
        
        $data = [
            'sponsors' => $sponsors,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
        $this->view('admin/sponsors/index', $data);
    }

    public function add_sponsor() {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'access_token' => bin2hex(random_bytes(16)),
                'profile_photo' => '',
                'name_err' => '',
                'email_err' => ''
            ];

            // Handle file upload
            if(!empty($_FILES['profile_photo']['name'])) {
                $filename = time() . '_' . $_FILES['profile_photo']['name'];
                $target_dir = APPROOT . '/uploads/sponsor_photos/';
                $target_file = $target_dir . basename($filename);
                if(move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
                    $data['profile_photo'] = 'uploads/sponsor_photos/' . $filename;
                }
            }

            if (empty($data['name'])) $data['name_err'] = 'Please enter name';
            if (empty($data['email'])) $data['email_err'] = 'Please enter email';

            if (empty($data['name_err']) && empty($data['email_err'])) {
                // Hash Password
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if ($this->sponsorModel->addSponsor($data)) {
                    flash('sponsor_message', 'Sponsor Added');
                    redirect('admin/sponsors');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('admin/sponsors/add', $data);
            }
        } else {
            $data = ['name' => '', 'email' => '', 'password' => '', 'name_err' => '', 'email_err' => ''];
            $this->view('admin/sponsors/add', $data);
        }
    }

    public function edit_sponsor($id) {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $sponsor = $this->sponsorModel->getSponsorById($id);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'profile_photo' => $sponsor->profile_photo,
                'password' => '',
                'name_err' => '',
                'email_err' => ''
            ];

            // Hash Password if provided
            if(!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // Handle file upload
            if(!empty($_FILES['profile_photo']['name'])) {
                $filename = time() . '_' . $_FILES['profile_photo']['name'];
                $target_dir = APPROOT . '/uploads/sponsor_photos/';
                $target_file = $target_dir . basename($filename);
                if(move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
                    // Delete old photo
                    if(!empty($sponsor->profile_photo) && file_exists(APPROOT . '/' . $sponsor->profile_photo)) {
                        unlink(APPROOT . '/' . $sponsor->profile_photo);
                    }
                    $data['profile_photo'] = 'uploads/sponsor_photos/' . $filename;
                }
            }

            if (empty($data['name'])) $data['name_err'] = 'Please enter name';
            if (empty($data['email'])) $data['email_err'] = 'Please enter email';

            if (empty($data['name_err']) && empty($data['email_err'])) {
                if ($this->sponsorModel->updateSponsor($data)) {
                    flash('sponsor_message', 'Sponsor Updated');
                    redirect('admin/sponsors');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('admin/sponsors/edit', $data);
            }
        } else {
            $sponsor = $this->sponsorModel->getSponsorById($id);
            if (!$sponsor) {
                redirect('admin/sponsors');
            }
            $data = [
                'id' => $id,
                'name' => $sponsor->name,
                'email' => $sponsor->email,
                'profile_photo' => $sponsor->profile_photo,
                'name_err' => '',
                'email_err' => ''
            ];
            $this->view('admin/sponsors/edit', $data);
        }
    }

    public function delete_sponsor($id) {
        if (!isLoggedIn()) redirect('admin/login');
        
        if ($this->sponsorModel->deleteSponsor($id)) {
            flash('sponsor_message', 'Sponsor Removed');
            redirect('admin/sponsors');
        } else {
            die('Something went wrong');
        }
    }

    public function students() {
        if (!isLoggedIn()) redirect('admin/login');

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $sort = isset($_GET['sort']) ? trim($_GET['sort']) : 'newest';

        // Pagination
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalStudents = $this->studentModel->getStudentCount($search);
        $totalPages = ceil($totalStudents / $limit);

        $students = $this->studentModel->getStudents($search, $sort, $limit, $offset);

        $data = [
            'students' => $students,
            'search' => $search,
            'sort' => $sort,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
        $this->view('admin/students/index', $data);
    }
    public function student_profile($id) {
        if (!isLoggedIn()) redirect('admin/login');

        $student = $this->studentModel->getStudentById($id);
        
        // Get student assignments (sponsors)
        $this->db = new Database();
        $this->db->query('SELECT s.* FROM sponsors s JOIN sponsor_student ss ON s.id = ss.sponsor_id WHERE ss.student_id = :id');
        $this->db->bind(':id', $id);
        $sponsors = $this->db->resultSet();

        // Get student messages
        $messages = $this->messageModel->getMessagesForUser('student', $id);

        // Get student uploads
        $this->db->query('SELECT * FROM student_uploads WHERE student_id = :id ORDER BY created_at DESC');
        $this->db->bind(':id', $id);
        $uploads = $this->db->resultSet();

        // Get gallery
        $gallery = $this->studentModel->getGallery($id);

        $data = [
            'student' => $student,
            'sponsors' => $sponsors,
            'messages' => $messages,
            'uploads' => $uploads,
            'gallery' => $gallery
        ];

        $this->view('admin/students/profile', $data);
    }

    public function upload_results($id) {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!empty($_FILES['result_file']['name'])) {
                $filename = time() . '_' . $_FILES['result_file']['name'];
                $target_dir = APPROOT . '/uploads/results/';
                if(!is_dir($target_dir)) mkdir($target_dir);
                $target_file = $target_dir . basename($filename);
                
                if(move_uploaded_file($_FILES['result_file']['tmp_name'], $target_file)) {
                    $this->db = new Database();
                    $this->db->query('INSERT INTO student_uploads (student_id, file_name, file_path) VALUES (:student_id, :name, :path)');
                    $this->db->bind(':student_id', $id);
                    $this->db->bind(':name', $_POST['file_name']);
                    $this->db->bind(':path', 'uploads/results/' . $filename);
                    $this->db->execute();
                    flash('student_message', 'Result Image Uploaded');
                }
            }
            redirect('admin/student_profile/' . $id);
        }
    }

    public function upload_gallery($id) {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!empty($_FILES['gallery_photo']['name'])) {
                $filename = time() . '_' . $_FILES['gallery_photo']['name'];
                $target_dir = APPROOT . '/uploads/gallery/';
                if(!is_dir($target_dir)) mkdir($target_dir);
                $target_file = $target_dir . basename($filename);
                
                if(move_uploaded_file($_FILES['gallery_photo']['tmp_name'], $target_file)) {
                    $this->studentModel->addGalleryPhoto($id, 'uploads/gallery/' . $filename, $_POST['caption']);
                    flash('student_message', 'Photo Added to Gallery');
                }
            }
            redirect('admin/student_profile/' . $id);
        }
    }

    public function delete_gallery_photo($photo_id, $student_id) {
        if (!isLoggedIn()) redirect('admin/login');
        if($this->studentModel->deleteGalleryPhoto($photo_id)) {
            flash('student_message', 'Photo Removed');
        }
        redirect('admin/student_profile/' . $student_id);
    }

    public function delete_result($upload_id, $student_id) {
        if (!isLoggedIn()) redirect('admin/login');
        
        $this->db = new Database();
        $this->db->query('SELECT file_path FROM student_uploads WHERE id = :id');
        $this->db->bind(':id', $upload_id);
        $file = $this->db->single();

        if($file && file_exists(APPROOT . '/' . $file->file_path)) {
            unlink(APPROOT . '/' . $file->file_path);
        }

        $this->db->query('DELETE FROM student_uploads WHERE id = :id');
        $this->db->bind(':id', $upload_id);
        $this->db->execute();

        flash('student_message', 'Result Removed');
        redirect('admin/student_profile/' . $student_id);
    }

    public function preview_portfolio($id) {
        if (!isLoggedIn()) redirect('admin/login');

        $student = $this->studentModel->getStudentById($id);
        if (!$student) redirect('admin/students');

        // Get student uploads/results
        $this->db = new Database();
        $this->db->query('SELECT * FROM student_uploads WHERE student_id = :id');
        $this->db->bind(':id', $id);
        $uploads = $this->db->resultSet();

        // Get gallery
        $gallery = $this->studentModel->getGallery($id);

        $data = [
            'student' => $student,
            'uploads' => $uploads,
            'gallery' => $gallery,
            'is_preview' => true
        ];
        $this->view('sponsor/student_profile', $data);
    }

    public function add_student() {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'first_name' => trim($_POST['first_name']),
                'surname' => trim($_POST['surname']),
                'age' => trim($_POST['age']),
                'class' => trim($_POST['class']),
                'email' => trim($_POST['email']),
                'about' => trim($_POST['about']),
                'educational_goals' => trim($_POST['educational_goals']),
                'memory_verse' => trim($_POST['memory_verse']),
                'prayer_needs' => trim($_POST['prayer_needs']),
                'profile_photo' => '',
                'access_token' => bin2hex(random_bytes(16)),
                'first_name_err' => '',
                'surname_err' => ''
            ];

            // Handle file upload
            if(!empty($_FILES['profile_photo']['name'])) {
                $filename = time() . '_' . $_FILES['profile_photo']['name'];
                $target_dir = APPROOT . '/uploads/profile_photos/';
                $target_file = $target_dir . basename($filename);
                if(move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
                    $data['profile_photo'] = 'uploads/profile_photos/' . $filename;
                }
            }

            if (empty($data['first_name'])) $data['first_name_err'] = 'Please enter first name';
            if (empty($data['surname'])) $data['surname_err'] = 'Please enter surname';

            if (empty($data['first_name_err']) && empty($data['surname_err'])) {
                // Hash Password
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if ($this->studentModel->addStudent($data)) {
                    flash('student_message', 'Student Added');
                    redirect('admin/students');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('admin/students/add', $data);
            }
        } else {
            $data = [
                'first_name' => '', 'surname' => '', 'age' => '', 'class' => '', 
                'email' => '', 'password' => '', 'about' => '', 'first_name_err' => '', 'surname_err' => ''
            ];
            $this->view('admin/students/add', $data);
        }
    }

    public function edit_student($id) {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $student = $this->studentModel->getStudentById($id);
            $data = [
                'id' => $id,
                'first_name' => trim($_POST['first_name']),
                'surname' => trim($_POST['surname']),
                'age' => trim($_POST['age']),
                'class' => trim($_POST['class']),
                'email' => trim($_POST['email']),
                'about' => trim($_POST['about']),
                'educational_goals' => trim($_POST['educational_goals']),
                'memory_verse' => trim($_POST['memory_verse']),
                'prayer_needs' => trim($_POST['prayer_needs']),
                'profile_photo' => $student->profile_photo,
                'password' => '',
                'first_name_err' => '',
                'surname_err' => ''
            ];

            // Hash Password if provided
            if(!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // Handle file upload
            if(!empty($_FILES['profile_photo']['name'])) {
                $filename = time() . '_' . $_FILES['profile_photo']['name'];
                $target_dir = APPROOT . '/uploads/profile_photos/';
                $target_file = $target_dir . basename($filename);
                if(move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
                    // Delete old photo
                    if(!empty($student->profile_photo) && file_exists(APPROOT . '/' . $student->profile_photo)) {
                        unlink(APPROOT . '/' . $student->profile_photo);
                    }
                    $data['profile_photo'] = 'uploads/profile_photos/' . $filename;
                }
            }

            if (empty($data['first_name'])) $data['first_name_err'] = 'Please enter first name';
            if (empty($data['surname'])) $data['surname_err'] = 'Please enter surname';

            if (empty($data['first_name_err']) && empty($data['surname_err'])) {
                if ($this->studentModel->updateStudent($data)) {
                    flash('student_message', 'Student Updated');
                    redirect('admin/students');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('admin/students/edit', $data);
            }
        } else {
            $student = $this->studentModel->getStudentById($id);
            if (!$student) {
                redirect('admin/students');
            }
            $data = [
                'id' => $id,
                'first_name' => $student->first_name,
                'surname' => $student->surname,
                'age' => $student->age,
                'class' => $student->class,
                'email' => $student->email,
                'about' => $student->about,
                'first_name_err' => '',
                'surname_err' => ''
            ];
            $this->view('admin/students/edit', $data);
        }
    }

    public function delete_student($id) {
        if (!isLoggedIn()) redirect('admin/login');
        
        if ($this->studentModel->deleteStudent($id)) {
            flash('student_message', 'Student Removed');
            redirect('admin/students');
        } else {
            die('Something went wrong');
        }
    }

    public function login() {
        if (isLoggedIn()) {
            redirect('admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            if (empty($data['email'])) $data['email_err'] = 'Please enter email';
            if (empty($data['password'])) $data['password_err'] = 'Please enter password';

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInAdmin = $this->adminModel->login($data['email'], $data['password']);
                if ($loggedInAdmin) {
                    $this->createAdminSession($loggedInAdmin);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('admin/login', $data);
                }
            } else {
                $this->view('admin/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->view('admin/login', $data);
        }
    }

    public function createAdminSession($admin) {
        $_SESSION['admin_id'] = $admin->id;
        $_SESSION['admin_email'] = $admin->email;
        $_SESSION['admin_name'] = $admin->name;
        redirect('admin/dashboard');
    }

    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_name']);
        session_destroy();
        redirect('admin/login');
    }

    public function dashboard() {
        if (!isLoggedIn()) {
            redirect('admin/login');
        }

        // Fetch counts for dashboard stats
        $this->db = new Database();
        
        $this->db->query('SELECT COUNT(*) as count FROM messages WHERE status = "pending"');
        $pendingCount = $this->db->single()->count;

        $this->db->query('SELECT COUNT(*) as count FROM sponsors');
        $sponsorCount = $this->db->single()->count;

        $this->db->query('SELECT COUNT(*) as count FROM students');
        $studentCount = $this->db->single()->count;

        $data = [
            'title' => 'Admin Dashboard',
            'pending_count' => $pendingCount,
            'sponsor_count' => $sponsorCount,
            'student_count' => $studentCount
        ];
        $this->view('admin/dashboard', $data);
    }

    public function settings() {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle logo upload
            if(!empty($_FILES['site_logo']['name'])) {
                $filename = 'logo_' . time() . '_' . $_FILES['site_logo']['name'];
                $target_dir = APPROOT . '/uploads/system/';
                if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                $target_file = $target_dir . basename($filename);
                
                if(move_uploaded_file($_FILES['site_logo']['tmp_name'], $target_file)) {
                    // Delete old logo if exists
                    $oldLogo = getSetting('site_logo');
                    if($oldLogo && file_exists(APPROOT . '/' . $oldLogo)) {
                        unlink(APPROOT . '/' . $oldLogo);
                    }
                    $this->adminModel->updateSetting('site_logo', 'uploads/system/' . $filename);
                    flash('settings_message', 'Logo updated successfully');
                }
            }

            // Handle logo deletion
            if(isset($_POST['delete_logo'])) {
                $oldLogo = getSetting('site_logo');
                if($oldLogo && file_exists(APPROOT . '/' . $oldLogo)) {
                    unlink(APPROOT . '/' . $oldLogo);
                }
                $this->adminModel->updateSetting('site_logo', '');
                flash('settings_message', 'Logo removed');
            }

            // Handle other settings
            $text_keys = [
                'top_bar_text', 'contact_phone', 'contact_email', 'donate_url',
                'smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_encryption', 'smtp_from_name'
            ];
            foreach($text_keys as $key) {
                if(isset($_POST[$key])) {
                    $this->adminModel->updateSetting($key, trim($_POST[$key]));
                }
            }

            flash('settings_message', 'Settings updated');
            redirect('admin/settings');
        }

        $data = [
            'title' => 'System Settings',
            'site_logo' => getSetting('site_logo'),
            'top_bar_text' => getSetting('top_bar_text'),
            'contact_phone' => getSetting('contact_phone'),
            'contact_email' => getSetting('contact_email'),
            'donate_url' => getSetting('donate_url'),
            'smtp_host' => getSetting('smtp_host'),
            'smtp_port' => getSetting('smtp_port'),
            'smtp_user' => getSetting('smtp_user'),
            'smtp_pass' => getSetting('smtp_pass'),
            'smtp_encryption' => getSetting('smtp_encryption'),
            'smtp_from_name' => getSetting('smtp_from_name')
        ];
        $this->view('admin/settings', $data);
    }

    public function menu_manager() {
        if (!isLoggedIn()) redirect('admin/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Add new menu item
            $data = [
                'label' => trim($_POST['label']),
                'url' => trim($_POST['url']),
                'parent_id' => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null,
                'sort_order' => (int)$_POST['sort_order']
            ];

            $this->db = new Database();
            $this->db->query('INSERT INTO menu_items (label, url, parent_id, sort_order) VALUES (:label, :url, :parent_id, :sort_order)');
            $this->db->bind(':label', $data['label']);
            $this->db->bind(':url', $data['url']);
            $this->db->bind(':parent_id', $data['parent_id']);
            $this->db->bind(':sort_order', $data['sort_order']);
            
            if ($this->db->execute()) {
                flash('menu_message', 'Menu item added');
            }
            redirect('admin/menu_manager');
        }

        $menu_items = getMenuItems(); // Flat list might be better for manager, but nested is okay
        
        // Let's also get a flat list for parent selection
        $this->db = new Database();
        $this->db->query('SELECT * FROM menu_items ORDER BY parent_id ASC, sort_order ASC');
        $flat_items = $this->db->resultSet();

        $data = [
            'menu_items' => $menu_items,
            'flat_items' => $flat_items
        ];
        $this->view('admin/menu_manager', $data);
    }

    public function delete_menu_item($id) {
        if (!isLoggedIn()) redirect('admin/login');
        
        $this->db = new Database();
        $this->db->query('DELETE FROM menu_items WHERE id = :id');
        $this->db->bind(':id', $id);
        
        if ($this->db->execute()) {
            flash('menu_message', 'Menu item removed');
        }
        redirect('admin/menu_manager');
    }
}
