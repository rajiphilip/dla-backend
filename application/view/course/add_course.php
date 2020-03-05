<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Course</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Course</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-6">

                    <form action="<?= URL; ?>/course/saveCourse" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Course Title:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Select Option --</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Has Prerequisite?:</label>
                            <select class="form-control" id="has_prerequisite" name="has_prerequisite" required>
                                <option value="">-- Select Option --</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div style="padding: 10px; display: none" id="course_options">
                            <?php foreach ($courses as $course){?>
                            <div class="form-group">
                                <input type="checkbox" name="course[]" value="<?= $course->id; ?>">&nbsp;&nbsp;&nbsp;<?= $course->name; ?></input>
                            </div>
                            <?php }?>
                        </div>

                        <input type="submit" class="btn btn-primary btn-user" value="Add Course"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->