<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href="<?php echo base_url("lab_manager/appointment/") ?>"> <i class="fa fa-list"></i>  <?php echo display('appointment_list') ?> </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open('lab_manager/appointment/form/'.$appointment->appointment_id,'class="form-inner"') ?> 
                        
                            <!-- patient id -->
                            <?php echo form_hidden('appointment_id', $appointment->appointment_id);?>
                            <div class="form-group row">
                                <label for="patient_id" class="col-xs-3 col-form-label"><?php echo display('patient_id') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="patient_id" autocomplete="off" type="text" class="form-control" id="patient_id" placeholder="<?php echo display('patient_id') ?>" value="<?php echo $appointment->patient_id ?>">
                                    <span></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="appointment_type" class="col-xs-3 col-form-label">Appointment Type<span class="text-danger">*</span> <?php echo form_error('appointment_type') ?></label>
                                        <div class="col-xs-9">
                                            <?php echo form_dropdown('appointment_type', $this->config->item('appointment_type'), $appointment->appointment_type, 'class="form-control input-sm" id="appointment_type"'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                    <?php
                                        $testOpts =[''=>'Select Test'];
                                        foreach ($test_options as $data) {
                                            $testOpts[$data->test_id] = $data->test_name;
                                        }
                                        $pkgOpts =[''=>'Select Package'];
                                        foreach ($package_options as $data) {
                                            $pkgOpts[$data->package_id] = $data->package_name;
                                        }
                                    ?>
                                        <div id="test_wrapper" <?php echo ($appointment->appointment_type == "t") ? "style='display: block;'" : "style='display: none;'" ?>>
                                            <label for="test" class="col-xs-3 col-form-label">Select Test <span class="text-danger">*</span> <?php echo form_error('test') ?></label>
                                            <div class="col-xs-9">
                                                <?php echo form_dropdown('test', $testOpts, $appointment->test, 'class="form-control input-sm" id="test"'); ?>    
                                                </div>
                                        </div>
                                        
                                        <div id="package_wrapper" <?php echo ($appointment->appointment_type == "p") ? "style='display: block;'" : "style='display: none;'" ?>>
                                            <label for="package" class="col-xs-3 col-form-label">Select Package <span class="text-danger">*</span> <?php echo form_error('package') ?></label>
                                            <div class="col-xs-9">
                                                <?php echo form_dropdown('package', $pkgOpts, $appointment->package, 'class="form-control input-sm" id="package" '); ?>    
                                            </div>
                                        </div>
                                        
                                        
                                    </div>        
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="test_price" class="col-xs-3 col-form-label"><?php echo display('test_price') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="test_price" autocomplete="off" type="text" class="form-control" id="test_price" placeholder="<?php echo display('test_price') ?>" value="<?php echo $appointment->test_price ?>" readonly>
                                    <span></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="discount" class="col-xs-3 col-form-label"><?php echo display('discount') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="discount" autocomplete="off" type="text" class="form-control" id="discount" placeholder="<?php echo display('discount') ?>" value="<?php echo $appointment->discount ?>">
                                    <span></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tax" class="col-xs-3 col-form-label"><?php echo display('tax') ?> (%)</label>
                                <div class="col-xs-9">
                                <input name="tax" onchange="calc()" type="text" class="form-control" id="tax" placeholder="<?php echo display('tax') ?>" value="<?php echo $appointment->tax ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="total_price" class="col-xs-3 col-form-label"><?php echo display('total_price') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="total_price" autocomplete="off" type="text" class="form-control" id="total_price" placeholder="<?php echo display('total_price') ?>" value="<?php echo $appointment->total_price ?>" readonly>
                                    <span></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="blood_group" class="col-xs-3 col-form-label"><?php echo display('blood_group') ?></label>
                                <div class="col-xs-9">
                                    <?php echo form_dropdown('blood_group',$this->config->item('blood_group'),$appointment->blood_group,'class="form-control" id="blood_group"') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sample_collection_time" class="col-xs-3 col-form-label"><?php echo display('sample_collection_time') ?></label>
                                <div class="col-xs-9"> 
                                    <input name="sample_collection_time" type="text" class="timepicker form-control" id="sample_collection_time" placeholder="<?php echo display('sample_collection_time') ?>" value="<?= $appointment->sample_collection_time ?>">
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="appointment_date" class="col-xs-3 col-form-label"><?php echo display('appointment_date') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9"> 
                                    <input name="appointment_date" type="text" class="datepicker form-control" id="appointment_date" placeholder="<?php echo display('appointment_date') ?>" value="<?= $appointment->appointment_date ?>">
                                </div>
                            </div>
                            <?php
                                $doctor_list['other'] = "Other";
                            ?>
                            <div class="form-group row">
                                <label for="doctor_id" class="col-xs-3 col-form-label"><?php echo display('doctor_name') ?></label>
                                <div class="col-xs-9">
                                    <?php echo form_dropdown('doctor_id',$doctor_list,$appointment->doctor_id,'class="form-control" id="doctor_id"') ?>
                                </div>
                            </div> 
                            <div class="form-group row <?php if($appointment->doctor_id == "other") echo 'show'; else  echo 'hide'; ?>" id='extra'>
                                <label for="doctor_name" id='drname_lbl' class="col-xs-3 col-form-label"><?php echo display('doctor_name') ?></label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control input-sm" name="<?php echo 'doctor_name'; ?>" id="doctor_name" placeholder="Specify Doctor Name" value="<?php if($appointment->doctor_id == "other") echo $appointment->doctor_name; ?>" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('payment_status') ?></label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                        <label class="radio-inline">
                                        <input type="radio" name="payment_status" value="1" <?php if($appointment->payment_status == 1) echo 'checked'; ?>><?php echo display('paid') ?>
                                        </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="payment_status" value="0" <?php if($appointment->payment_status == 0) echo 'checked'; ?>><?php echo display('unpaid') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="0" <?php if($appointment->status == 0) echo 'checked'; ?>><?php echo display('pending') ?>
                                        </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="1" <?php if($appointment->status == 1) echo 'checked'; ?>><?php echo display('inprogress') ?>
                                        </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="2" <?php if($appointment->status == 2) echo 'checked'; ?>><?php echo display('cancelled') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('onaid') ?></label>
                                <div class="col-xs-9">
                                    <div class="checkbox checkbox-success">
                                            <input id="admission_id" name="admission_id" type="checkbox" <?php if($appointment->admission_id != '') echo 'checked'; ?>>
                                            <label for="admission_id"><?php echo display("onaid") ?></label>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            if($appointment->bill_generated == 0){
                            ?>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        <?php echo form_close() ?>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $.getJSON("<?php echo base_url('my-assets/js/admin_js/json/customer.json') ?>", function(data) {
        $("#patient_id").autocomplete({
            source: data,
            minLength: 1,
            select: function(event, ui) {
                setTimeout(function(){
                    $("#patient_id").val(ui.item.value);
                });
            }
        });
    });
    //check patient id
    $('#patient_id').blur(function(){
        var pid = $(this);

        $.ajax({
            url  : '<?= base_url('bed_manager/bed_assign/check_patient/') ?>',
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
                if(data.admission_id == true){
                    $('#admission_id').prop('checked', true)
                }else{
                    $('#admission_id').prop('checked', false);
                }
            }, 
            error : function()
            {
                alert('failed');
            }
        });
    });
});

$(document).off('change.appointment_type').on('change.appointment_type', '#appointment_type', function(event) {
    $('#test_price').val(0);
    $('#discount').val(0);
    $('#tax').val(0);
    $('#total_price').val(0);

    if($(this).val() == "p"){
        $("#package_wrapper").show();
        $("#test_wrapper").hide();
    }else{
        $("#package_wrapper").hide();
        $("#test_wrapper").show();
    }   
                            
});

$(document).off('change.test').on('change.test', '#test', function(event) {
    if($(this).val()){
        $('#discount').val(0);
        $('#tax').val(0);
        var url = '<?php echo base_url() ?>lab_manager/test/getTestPrice';
        $.ajax({
            type: "POST",
            url: url,
            data : {'test_id' : $(this).val(), 'csrf_test_name' : '<?php echo $this->input->post('csrf_cookie_name')?>'},
            success: function (result) {
                var data = JSON.parse(result)
                if(data.status == "SUCCESS"){
	            	$('#test_price').val(data.test_price);
	        		$('#total_price').val(data.final_price);
	        	}
                else{
                    alert("parser error");
                }
            }
        });
	}else{
    	$('#test_price').val(0);
    	$('#discount').val(0);
        $('#tax').val(0);
        $('#total_price').val(0);
    }	
});

$(document).off('change.package').on('change.package', '#package', function(event) {
    if($(this).val()){
        $('#discount').val(0);
        $('#tax').val(0);
        var url = '<?php echo base_url() ?>lab_manager/package/getPackagePrice';
        $.ajax({
            type: "POST",
            url: url,
            data : {'package_id' : $(this).val(), 'csrf_test_name' : '<?php echo $this->input->post('csrf_cookie_name')?>'},
            success: function (result) {
                var data = JSON.parse(result)
                if(data.status == "SUCCESS"){
	            	$('#test_price').val(data.package_actual_price);
                    $('#total_price').val(data.package_final_price);
	        	}
                else{
                    alert("parser error");
                }
            }
        });
	}else{
    	$('#test_price').val(0);
    	$('#discount').val(0);
        $('#tax').val(0);
        $('#total_price').val(0);
    }	
});

function calc(){
    var charge = parseFloat($("#test_price").val());
    var dis = parseFloat($("#discount").val());
    var tax = parseFloat($("#tax").val());
    var cal = charge - (charge*(dis/100));
    var taxcal = cal + (charge*(tax/100));
    setTimeout(function (){
        $("#total_price").val(parseFloat(taxcal.toFixed(2)));
    },100);
}
$(document).off('focusout.discount').on('focusout.discount', '#discount', function(event) {
    var price = parseInt($('#test_price').val());
    var discountPercent = parseInt($(this).val());
    if(discountPercent && Number.isInteger(discountPercent) && discountPercent <= 100 && discountPercent > 0){
        //var discount_price = (discountPercent/100)*price,
        //total_price = price-discount_price;
        //$('#total_price').val((total_price).toFixed(2));
        calc();
    }else{
        $('#discount').val(0);
        //$('#total_price').val((price).toFixed(2));
        calc()
    }
});

$(document).off('focusout.tax').on('focusout.tax', '#tax', function(event) {
    var price = parseInt($('#test_price').val());
    var taxPercent = parseInt($(this).val());
    if(taxPercent && Number.isInteger(taxPercent) && taxPercent <= 100 && taxPercent > 0){
        //var tax_price = (taxPercent/100)*price,
        //total_price = price+tax_price;
        //$('#total_price').val((total_price).toFixed(2));
        calc();
    }else{
        $('#tax').val(0);
        //$('#total_price').val((price).toFixed(2));
        calc();
    }
});

$(document).off('change.doctor_id').on('change.doctor_id', '#doctor_id', function(event) {
    if($(this).val() == "other"){
        $("#extra").removeClass('hide');
        $("#extra").addClass('show');
    }else{
        $("#extra").removeClass('show');
        $("#extra").addClass('hide');
    }
});

</script>

