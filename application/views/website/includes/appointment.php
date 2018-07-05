<section id="appointment" class="choose-form-inner">
    <div class="container">

        <div class="row">

            <!-- Main Title -->
            <div class="col-md-6 col-md-offset-3">
                <div class="title-block">
                    <h3><?= (!empty($section['appointment']['title'])?$section['appointment']['title']:null) ?></h3>
                    <p><?= (!empty($section['appointment']['description'])?$section['appointment']['description']:null) ?></p>
                </div>
            </div> 
        </div>


            <!-- Message & exception -->
            <div class="col-sm-12">
                <?php if ($this->session->flashdata('success') != null) {  ?>
                <div class="alert alert-info"> 
                    <?php echo $this->session->flashdata('success'); ?>
                </div> 
                <?php } ?>
                
                <?php if ($this->session->flashdata('exception') != null) {  ?>
                <div class="alert alert-danger">
                <?php echo $this->session->flashdata('exception'); ?>
                </div>
                <?php } ?> 
            </div>


            <!-- Appointment Form -->
            <div class="col-sm-6 col-md-4">
 
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?= ($this->session->flashdata('p_status')!=2?"active":null) ?>">
                    <a href="#appRegister" aria-controls="appRegister" role="tab" data-toggle="tab"><?php echo display('appointment') ?></a>
                </li>
                <li role="presentation" class="<?= ($this->session->flashdata('p_status')==2?"active":null) ?>">
                    <a href="#patientRegister" aria-controls="patientRegister" role="tab" data-toggle="tab"><?php echo display('registration') ?></a>
                </li> 
              </ul>


              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Login -->
                <div role="tabpanel" class="tab-pane <?= ($this->session->flashdata('p_status')!=2?"active":null) ?>" id="appRegister">
                    <div id="form" class="form-area"> 
                        <?= form_open('website/appointment/create','id="appointmentForm"') ?> 
                        <div class="form-padding">
                            <h4><?php echo display('appointment_form') ?></h4>

                            <!-- patient id -->
                            <div class="form-group">
                                <label><?php echo display('patient_id') ?> <i class="text-danger">*</i></label>
                                <input name="patient_id" autocomplete="off" type="text" class="form-control" id="patient_id" placeholder="<?php echo display('patient_id') ?>" value="<?php echo $appointment->patient_id ?>">
                                <span></span>
                            </div>
     
                            <div class="form-group">
                                <label><?php echo display('department_name') ?> <i class="text-danger">*</i></label>
                                <?php echo form_dropdown('department_id',$department_list,$appointment->department_id,'class="form-control" id="department_id"') ?>
                                <span class="doctor_error"></span>
                            </div>
     
                            <div class="form-group">
                                <label><?php echo display('doctor_name') ?><i class="text-danger">*</i></label>
                                <?php echo form_dropdown('doctor_id','','','class="form-control" id="doctor_id"') ?>
                                <p class="help-block" id="available_days"></p>
                            </div>

                            <div class="form-group">
                                <label><?php echo display('appointment_date') ?> <i class="text-danger">*</i></label>
                                <input name="date" type="text" class="datepicker-avaiable-days form-control" id="date" placeholder="<?php echo display('appointment_date') ?>" >
                            </div>
     
                            <div class="form-group">
                                <label><?php echo display('serial_no') ?> <i class="text-danger">*</i></label>
                                <div id="serial_preview">
                                    <div class="btn btn-success disabled btn-sm"> 01</div>
                                    <div class="btn btn-success disabled btn-sm"> 02</div>
                                    <div class="btn btn-success disabled btn-sm"> 03</div>...
                                    <div class="slbtn btn btn-success disabled btn-sm"> N</div>

                                </div>
                                <input type="hidden" name="schedule_id" id="schedule_id"/>
                                <input type="hidden" name="serial_no" id="serial_no"/>
                            </div>

                            <div class="form-group">
                                <label><?php echo display('problem') ?> </label>
                                <textarea name="problem" class="form-control" placeholder="<?php echo display('problem') ?>"  rows="7"></textarea>
                            </div> 

                        </div>

                        <div class="form-footer">
                            <div class="checkbox">
                                <label></label>
                            </div>
                            <button type="submit" id="submit" class="btn thm-btn"><?php echo display('submit') ?></button>
                        </div> 

                        <?= form_close() ?>
                    </div>
                </div>

                <!-- Register -->
                <div role="tabpanel" class="tab-pane <?= ($this->session->flashdata('p_status')==2?"active":null) ?>" id="patientRegister">
                    <div id="form" class="form-area"> 

                        <?= form_open_multipart('website/patient/create','id="appointmentForm"') ?> 
                        <div class="form-padding">
                            <h4><?php echo display('registration_form') ?></h4>

                            <div class="form-group">
                                <label><?php echo display('full_name') ?> <i class="text-danger">*</i></label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input name="firstname" type="text" class="form-control" placeholder="<?php echo display('first_name') ?>">
                                    </div>

                                    <div class="col-sm-6">
                                        <input name="lastname" type="text" class="form-control" placeholder="<?php echo display('last_name') ?>"> 
                                    </div>  
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php echo display('contact') ?> <i class="text-danger">*</i></label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input name="phone" type="text" class="form-control" placeholder="<?php echo display('phone') ?> (<?php echo display('optional') ?>)"> 
                                    </div>

                                    <div class="col-sm-6">
                                        <input name="mobile" type="text" class="form-control" placeholder="<?php echo display('mobile') ?>"> 
                                    </div>  
                                </div>
                            </div> 

                            <div class="form-group">
                                <div class="form-check">
                                <label><?php echo display('sex') ?> <i class="text-danger">*</i></label>
                                    <label class="radio-inline">
                                    <input type="radio" name="sex" value="Male"><?php echo display('male') ?>
                                    </label>
                                    <label class="radio-inline">
                                    <input type="radio" name="sex" value="Female"><?php echo display('female') ?>
                                    </label>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label><?php echo display('date_of_birth') ?> <i class="text-danger">*</i></label>
                                <input name="date_of_birth" type="text" class="datepicker form-control" placeholder="<?php echo display('date_of_birth') ?>" >
                            </div>

                            <div class="form-group">
                                <label><?php echo display('blood_group') ?> </label>
                                <?php
                                    $bloodList = array( 
                                        ''   => display('select_option'),
                                        'A+' => 'A+',
                                        'A-' => 'A-',
                                        'B+' => 'B+',
                                        'B-' => 'B-',
                                        'O+' => 'O+',
                                        'O-' => 'O-',
                                        'AB+' => 'AB+',
                                        'AB-' => 'AB-'
                                    );
                                    echo form_dropdown('blood_group', $bloodList, null, 'class="form-control"'); 
                                ?>
                            </div> 
     
                            <div class="form-group">
                                <label><?php echo display('picture') ?></label>
                                <input name="picture" type="file">
                            </div>

                            <div class="form-group">
                                <label><?php echo display('address') ?> <i class="text-danger">*</i></label>
                                <textarea name="address" class="form-control" placeholder="<?php echo display('address') ?>"  rows="7"></textarea>
                            </div> 

                        </div>

                        <div class="form-footer">
                            <div class="checkbox">
                                <label></label>
                            </div>
                            <button type="submit" id="submit" class="btn thm-btn"><?php echo display('submit') ?></button>
                        </div> 

                        <?= form_close() ?>
                    </div>
                </div> 
              </div>
  

            </div>



            <!-- Section Image -->
            <div class="col-md-4 hidden-sm">
                <div class="doctor_img">
                    <img src="<?= (!empty($section['appointment']['featured_image'])?base_url($section['appointment']['featured_image']):null) ?>" class="img-responsive" alt="">
                </div>
            </div>



            <!-- Why Choose Us -->
            <div class="col-sm-6 col-md-4">
            <?php 
            if (!empty($items['appointment'])):
            foreach ($items['appointment'] as $appointment):
            ?>   
                <div class="choose">
                    <div class="choose-icon"> 
                        <?php if (!empty($appointment['icon_image'])): ?>
                            <img src="<?= $appointment['icon_image'] ?>" alt=""/>
                        <?php endif; ?>
                    </div>
                    <div class="choose-content">
                        <h4><?= $appointment['title'] ?></h4>
                        <p><?= character_limiter($appointment['description'],120) ?></p>
                    </div>
                </div> 
            <?php
            endforeach;
            endif;
            ?>   
            </div>

            
        </div>

    </div>
</section>



 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

    //check patient id
    $('#patient_id').keyup(function(){
        var pid = $(this);

        $.ajax({
            url  : '<?= base_url('website/appointment/check_patient/') ?>',
            type : 'post',
            dataType : 'JSON',
            data : {
                '<?= $this->security->get_csrf_token_name(); ?>' : '<?= $this->security->get_csrf_hash(); ?>',
                patient_id : pid.val()
            },
            success : function(data) 
            {
                if (data.status == true) {
                    pid.next().text(data.message).addClass('text-success').removeClass('text-danger');
                } else if (data.status == false) {
                    pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    pid.next().text(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });
 
    //department_id
    $("#department_id").change(function(){
        var output = $('.doctor_error'); 
        var doctor_list = $('#doctor_id');
        var available_day = $('#available_day');

        $.ajax({
            url  : '<?= base_url('website/appointment/doctor_by_department/') ?>',
            type : 'post',
            dataType : 'JSON',
            data : {
                '<?= $this->security->get_csrf_token_name(); ?>' : '<?= $this->security->get_csrf_hash(); ?>',
                department_id : $(this).val()
            },
            success : function(data) 
            {
                if (data.status == true) {
                    doctor_list.html(data.message);
                    available_day.html(data.available_days);
                    output.html('');
                } else if (data.status == false) {
                    doctor_list.html('');
                    output.html(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    doctor_list.html('');
                    output.html(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    }); 


    //doctor_id
    $("#doctor_id").change(function(){
        var doctor_id = $('#doctor_id'); 
        var output = $('#available_days'); 

        $.ajax({
            url  : '<?= base_url('website/appointment/schedule_day_by_doctor/') ?>',
            type : 'post',
            dataType : 'JSON',
            data : {
                '<?= $this->security->get_csrf_token_name(); ?>' : '<?= $this->security->get_csrf_hash(); ?>',
                doctor_id : $(this).val()
            },
            success : function(data) 
            {
                if (data.status == true) {
                    output.html(data.message).addClass('text-success').removeClass('text-danger');
                } else if (data.status == false) {
                    output.html(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    output.html(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });


    //date
    $("#date").change(function(){
        var date        = $('#date'); 
        var serial_preview   = $('#serial_preview'); 
        var doctor_id   = $('#doctor_id'); 
        var schedule_id = $("#schedule_id"); 
        var patient_id  = $("#patient_id"); 
 
        $.ajax({
            url  : '<?= base_url('website/appointment/serial_by_date/') ?>',
            type : 'post',
            dataType : 'JSON',
            data : {
                '<?= $this->security->get_csrf_token_name(); ?>' : '<?= $this->security->get_csrf_hash(); ?>',
                doctor_id  : doctor_id.val(),
                patient_id : patient_id.val(), 
                date : $(this).val()
            },
            success : function(data) 
            { 
                if (data.status == true) {
                    //set schedule id
                    schedule_id.val(data.schedule_id); 
                    serial_preview.html(data.message);
                } else if (data.status == false) {
                    schedule_id.val('');
                    serial_preview.html(data.message).addClass('text-danger').removeClass('text-success');
                } else {
                    schedule_id.val('');
                    serial_preview.html(data.message).addClass('text-danger').removeClass('text-success');
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });

    //serial_no 
    $("body").on('click','.serial_no',function(){
        var serial_no = $(this).attr('data-item');
        $("#serial_no").val(serial_no);
        $('.serial_no').removeClass('btn-danger').addClass('btn-success').not(".disabled");
        $(this).removeClass('btn-success').addClass('btn-danger').not(".disabled");
    });

    $( ".datepicker-avaiable-days" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,
        minDate: 0,  
        // beforeShowDay: DisableDays 
     });


});
</script>

