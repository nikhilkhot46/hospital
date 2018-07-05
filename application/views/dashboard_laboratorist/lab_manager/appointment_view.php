<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("dashboard_laboratorist/lab_manager/appointment/form") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_appointment') ?> </a>  
                </div>
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("dashboard_laboratorist/lab_manager/appointment/todays_appointments") ?>"> <i class="fa fa-plus"></i>  <?php echo display('todays_appointment') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('appointment_id') ?></th>
                            <th><?php echo display('patient_id') ?></th>
                            <th><?php echo display('test') ?></th>
                            <th><?php echo display('date') ?></th>
                            <th><?php echo display('actual_price') ?></th>
                            <th><?php echo display('discount') ?></th>
                            <th><?php echo display('final_price') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('payment') ?></th>
                            <th><?php echo display('doctor_name') ?></th>
                            <th><?php echo display('report') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($appointment)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($appointment as $pack) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $pack->appointment_id; ?></td>
                                    <td><?php echo $pack->patient_id; ?></td>
                                    <td>
                                        <?php 
                                            $data = $this->config->item('appointment_type');
                                            //echo $data[$pack->appointment_type]; 
                                            if($pack->appointment_type == "t")
                                            {
                                                foreach ($test_options as $data) {
                                                    $testOpts[$data->test_id] = $data->test_name;
                                                }
                                                echo $testOpts[$pack->test];
                                            }
                                            else{
                                                foreach ($package_options as $data) {
                                                    $pkgOpts[$data->package_id] = $data->package_name;
                                                }
                                                echo $pkgOpts[$pack->package];
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $pack->appointment_date; ?></td>
                                    <td><?php echo $pack->test_price; ?></td>
                                    <td><?php echo $pack->discount; ?>%</td>
                                    <td><?php echo $pack->total_price; ?></td>
                                    <td>
                                        <?php
                                            switch ($pack->status) {
                                                case '0':
                                                        echo '<span class="label label-info">'.display('pending').'</span>';
                                                    break;
                                                case "1":
                                                        echo '<span class="label label-warning">'.display('inprogress').'</span>';
                                                    break;
                                                case '3':
                                                        echo '<span class="label label-success">'.display('generated').'</span>';
                                                    break;
                                                case '2':
                                                        echo '<span class="label label-danger">'.display('cancelled').'</span>';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo (($pack->payment_status==1)?'<span class="label label-success">'.display('paid').'</span>':'<span class="label label-danger">'.display('unpaid').'</span>'); ?></td>
                                    <td><?php echo $pack->doctor_id == "other"?$pack->doctor_name:$doctor_list[$pack->doctor_id];?></td>
                                    <td><a href="<?php echo base_url()?>assets/reports/<?php echo $pack->report_doc; ?>" target="_blank"><?php echo $pack->report_doc; ?></a></td>
                                    <td class="center">
                                        <?php if($pack->status != 4){?><a href="<?php echo base_url("dashboard_laboratorist/lab_manager/appointment/form/$pack->appointment_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> <?php }?>
                                        <?php if($pack->status != 2){?><a href="javascript:;" onclick="uploadReport('<?php echo $pack->appointment_id ?>','<?php echo $pack->payment_status ?>')" class="btn btn-xs btn-info"><i class="fa fa-upload"></i></a><?php }?>
                                    </td>
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?> 
                        <?php } ?> 
                    </tbody>
                </table>  <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
<script>
function uploadReport(id,status){
    $(".modal-title").text("Upload Report");
    $("#appointment_id").val(id);
    $("#status").val(status);
    $("#id").text(id);
    $("#myModal").show();
}

$(document).on("click", "#close", function(event){
    $('#myModal').hide();
});
</script>
<div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <?php echo form_open_multipart('dashboard_laboratorist/lab_manager/appointment/report','class="form-inner"') ?> 
      <div class="modal-body">
      <i class="text-danger">(Reports can only be uploaded for paid appointments.)</i><br><br>
        <label> <?php echo display('appointment_id') ?>: <span id="id"></span></label><br>
        
            <input type="hidden" name="appointment_id" id="appointment_id" value="" />
            <input type="hidden" name="status" id="status" value="" />
            <input type = "file" name = "report" /> 
        
      </div>
      <div class="modal-footer">
        <div class="ui buttons">
            <button id="close" class="ui button"><?php echo display('cancel') ?></button>
            <div class="or"></div>
            <button class="ui positive button"><?php echo display('save') ?></button>
        </div>
      </div>
      <?php echo form_close() ?>
    </div>

  </div>
</div>