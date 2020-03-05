<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Course</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Course</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-6">

                    <form action="<?= URL; ?>/course/updateCourse" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Course Title:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   aria-describedby="emailHelp" value="<?= $course->name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Select Option --</option>
                                <option value="1" <?= ($course->status == 1) ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?= ($course->status == 0) ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Has Prerequisite?:</label>
                            <select class="form-control" id="has_prerequisite" name="has_prerequisite" required>
                                <option value="">-- Select Option --</option>
                                <option value="1" <?= ($course->has_prerequisite == 1) ? 'selected' : ''; ?>>Yes
                                </option>
                                <option value="0" <?= ($course->has_prerequisite == 0) ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <?php if ($course->has_prerequisite == 1) { ?>
                            <div style="padding: 10px;" id="course_options">
                                <?php foreach ($courses as $cors) {
                                    if($cors->id == $course->id){
                                        continue;
                                    }
                                    ?>

                                    <div class="form-group">
                                        <input type="checkbox" name="course[]" value="<?= $cors->id; ?>" <?= in_array($cors->id, $pre_array) ? 'checked':''; ?>>&nbsp;&nbsp;<?= $cors->name; ?> </input>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }else{ ?>
                            <div style="padding: 10px; display: none;" id="course_options">
                                <?php foreach ($courses as $cors) {
                                    if($cors->id == $course->id){
                                        continue;
                                    }
                                    ?>

                                    <div class="form-group">
                                        <input type="checkbox" name="course[]" value="<?= $cors->id; ?>">&nbsp;&nbsp;<?= $cors->name; ?> </input>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }?>
                        <input type="hidden" value="<?= $course->id;?>" name="course_id"/>
                        <input type="submit" class="btn btn-primary btn-user" value="Update Course"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->