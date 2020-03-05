<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Session</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Session</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-6">
                    <form action="<?= URL; ?>/session/updateSession" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Theme:</label>
                            <input type="text" class="form-control" id="theme" name="theme"
                                   value="<?= $session->theme;?>" aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Course:</label>
                            <select class="form-control" id="course_id" name="course_id" required>
                                <option value="">-- Select Option --</option>
                                <?php foreach ($courses as $course){?>
                                    <option value="<?= $course->id?>" <?= ($course->id == $session->course_id) ? 'selected' : '';?>><?= $course->name?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Select Option --</option>
                                <option value="1" <?= ($session->status == 1) ? 'selected' : '';?>>PAST</option>
                                <option value="2" <?= ($session->status == 2) ? 'selected' : '';?>>PRESENT</option>
                                <option value="3" <?= ($session->status == 3) ? 'selected' : '';?>>FUTURE</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fee:</label>
                            <input type="number" class="form-control" id="fee" name="fee"
                                   value="<?= $session->fee;?>"  aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Event Start Date:</label>
                            <input type="text" class="form-control start_date" id="start_date" name="start_date"
                                   value="<?= $session->start_date;?>" aria-describedby="emailHelp" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Event End Date:</label>
                            <input type="text" class="form-control end_date" id="end_date" name="end_date"
                                   value="<?= $session->end_date;?>" aria-describedby="emailHelp" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Registration Start Date:</label>
                            <input type="text" class="form-control reg_start_date" id="registration_start_date" name="registration_start_date"
                                   value="<?= $session->registration_start_date;?>"  aria-describedby="emailHelp" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Registration End Date:</label>
                            <input type="text" class="form-control reg_end_date" id="registration_end_date" name="registration_end_date"
                                   value="<?= $session->registration_end_date;?>"  aria-describedby="emailHelp" readonly required>
                        </div>
                        <input type="hidden" name="session_id" value="<?= $session->id;?>" />
                        <input type="submit" class="btn btn-primary btn-user" value="Update Session"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->