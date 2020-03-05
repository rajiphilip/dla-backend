<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Session Time Table</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Session Time Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-6">
                    <form action="<?= URL; ?>outline/updateOutlineTimeTable" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Session:</label>
                            <select class="form-control" id="session_id" name="session_id" required>
                                <option value="">-- Select Option --</option>
                                <?php foreach ($sessions as $session){?>
                                <option value="<?= $session->id?>" <?= ($session->id == $outline_timetable->session_id)?'selected':''?>><?= $session->theme?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Facilitator:</label>
                            <select class="form-control" id="facilitator_id" name="facilitator_id" required>
                                <option value="">-- Select Option --</option>
                                <?php foreach ($facilitators as $facilitator){?>
                                    <option value="<?= $facilitator->user_id?>" <?= ($facilitator->user_id == $outline_timetable->facilitator_id)?'selected':''?>><?= $facilitator->firstname.' '.$facilitator->lastname;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Outline:</label>
                            <select class="form-control" id="outline_id" name="outline_id" required>
                                <option value="">-- Select Option --</option>
                                <?php foreach ($outlines as $outline){?>
                                    <option value="<?= $outline->id;?>" <?= ($outline->id == $outline_timetable->outline_id)?'selected':''?>><?= $outline->name;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date:</label>
                            <input type="text" class="form-control start_date" id="date" name="date"  value="<?= $outline_timetable->date;?>"
                                   aria-describedby="emailHelp" readonly required>
                        </div>

                        <div class="form-group">
                            <label>Start Time: <span style="font-size: 8px;">Leave blank if time hasnt change, else change the time by clickingin the field</span></label>
                            <input type="text" class="form-control datetimepicker-input" id="start_time" name="start_time" data-toggle="datetimepicker" data-target="#start_time"
                                   aria-describedby="emailHelp" value="<?= $outline_timetable->start_time;?>" style="color: #2d2e33;" required>
                        </div>
                        <div class="form-group">
                            <label>End Time: <span style="font-size: 8px;">Leave blank if time hasnt change, else change the time by clickingin the field</span></label>
                            <input type="text" class="form-control datetimepicker-input" id="end_time" name="end_time"    data-toggle="datetimepicker" data-target="#end_time"
                                   aria-describedby="emailHelp" value="<?= $outline_timetable->end_time;?>" required>
                        </div>
                        <input type="hidden" name="fso_id" value="<?= $outline_timetable->id;?>" />
                        <input type="submit" class="btn btn-primary btn-user" value="Update Session Time Table"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->