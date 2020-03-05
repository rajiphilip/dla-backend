<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Session Time Table</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Session Time Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-6">
                    <form action="<?= URL; ?>outline/saveOutlineTimeTable" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Session:</label>
                            <select class="form-control" id="session_id" name="session_id" required>
                                <option value="">-- Select Option --</option>
                                <?php foreach ($sessions as $session){?>
                                <option value="<?= $session->id;?>"><?= $session->theme .' - '. date('F, Y', strtotime($session->start_date));?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Facilitator:</label>
                            <select class="form-control" id="facilitator_id" name="facilitator_id" required>
                                <option value="">-- Select Option --</option>
                                <?php foreach ($facilitators as $facilitator){?>
                                    <option value="<?= $facilitator->user_id?>"><?= $facilitator->firstname.' '.$facilitator->lastname;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Outline:</label>
                            <select class="form-control" id="outline_id" name="outline_id" required>
                                <option value="">-- Select Option --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date:</label>
                            <input type="text" class="form-control start_date" id="date" name="date"
                                   aria-describedby="emailHelp" readonly required>
                        </div>

                        <div class="form-group">
                            <label>Start Time:</label>
                            <input type="text" class="form-control datetimepicker-input" id="start_time" name="start_time" data-toggle="datetimepicker" data-target="#start_time"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>End Time:</label>
                            <input type="text" class="form-control datetimepicker-input" id="end_time" name="end_time"  data-toggle="datetimepicker" data-target="#end_time"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-user" value="Add Session Time Table"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->