<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("dashboard_receptionist/bed_manager/bed_assign/create") ?>"> <i class="fa fa-plus"></i>  <?php echo display('bed_assign') ?> </a>  
                </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('patient_id') ?></th>
                            <th><?php echo display('bed_type') ?></th>
                            <th><?php echo display('description') ?></th>
                            <th><?php echo display('charge') ?></th> 
                            <th><?php echo display('day') ?></th> 
                            <th><?php echo display('total') ?></th> 
                            <th><?php echo display('assign_date') ?></th>
                            <th><?php echo display('discharge_date') ?></th>
                            <th><?php echo display('assign_by') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($beds)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($beds as $bed) { ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $bed->patient_id; ?></td>
                                    <td><?php echo $bed->bed_name; ?></td>
                                    <td><?php echo character_limiter($bed->description, 60); ?></td>
                                    <td><?php echo $bed->charge; ?></td>
                                    <td><?php echo $bed->days; ?></td>
                                    <td><?php echo number_format($bed->charge * $bed->days, 2); ?></td>
                                    <td><?php echo $bed->assign_date; ?></td>
                                    <td><?php echo $bed->discharge_date; ?></td>
                                    <td><?php echo $bed->assign_by; ?></td>
                                    <td><?php echo (($bed->status==1)?display('active'):display('inactive')); ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("dashboard_receptionist/bed_manager/bed_assign/edit/$bed->serial") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                        <a href="<?php echo base_url("dashboard_receptionist/bed_manager/bed_assign/delete/$bed->serial") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a> 
                                        <a href="javascript:;" data-toggle="tooltip" title="Transfer Bed" onclick='tranferbed(<?php echo json_encode($bed); ?>)' class="btn btn-xs  btn-success"><i class="fa fa-refresh"></i></a> 
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
function tranferbed(bed){
    $("input[name~='serial']").val(bed.serial);
    $("input[name~='patient_id']").val(bed.patient_id);
    document.getElementById('bed_id').value = bed.bed_id
    

    $("input[name~='assign_date']").val(bed.assign_date);
    $("input[name~='discharge_date']").val(bed.discharge_date);
    $("input[name~='description']").val(bed.description);
    if(bed.status == 1)
        $("#active").attr("checked","checked");
    else
        $("#inactive").attr("checked","checked");
    $('#myModal').show();
}

$(document).on("click", "#close", function(event){
    $('#myModal').hide();
});

</script>

<div id="myModal" class="modal" role="dialog" style="background: rgba(0,0,0,.5); overflow:auto;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="close" onclick="close()">&times;</button>
        <h4 class="modal-title">Transfer Bed</h4>
      </div>
      <div class="modal-body">
      <?php echo form_open('dashboard_receptionist/bed_manager/bed_assign/tranferbed','class="form-inner"') ?>

<input type="hidden" name="serial" id="serial">

<div class="form-group row">
    <label for="patient_id" class="col-xs-3 col-form-label"><?php echo display('patient_id') ?> <i class="text-danger">*</i></label>
    <div class="col-xs-9">
        <input name="patient_id"  type="text" class="form-control" id="patient_id" placeholder="<?php echo display('patient_id') ?>" autocomplete="off">
        <span class="text-danger"></span>
    </div>
</div>

<div class="form-group row">
    <label for="bed_id" class="col-xs-3 col-form-label"><?php echo display('bed_type') ?> <i class="text-danger">*</i></label>
    <div class="col-xs-9">
    <?php echo form_dropdown('bed_id', $bed_list, $bed->bed_id, 'class="form dateChange" id="bed_id" style="width: 100%;height: 34px;padding: 6px 12px;"') ?>
    </div>
</div> 

<div class="form-group row">
    <label for="assign_date" class="col-xs-3 col-form-label"><?php echo display('assign_date') ?> <i class="text-danger">*</i></label>
    <div class="col-xs-9">
        <input name="assign_date"  type="text" class="form-control cdatepicker dateChange" id="assign_date" placeholder="<?php echo display('assign_date') ?>" >
    </div>
</div>

<div class="form-group row">
    <label for="discharge_date" class="col-xs-3 col-form-label"><?php echo display('discharge_date') ?> <i class="text-danger">*</i></label>
    <div class="col-xs-9">
        <input name="discharge_date"  type="text" class="form-control cdatepicker dateChange" id="discharge_date" placeholder="<?php echo display('discharge_date') ?>" >
        <div class="help-block"></div>
    </div>
</div>

<div class="form-group row">
    <label for="description" class="col-xs-3 col-form-label"><?php echo display('description') ?></label>
    <div class="col-xs-9">
        <textarea name="description" class="form-control"  placeholder="<?php echo display('description') ?>" rows="4"></textarea>
    </div>
</div>


<!--Radio-->
<div class="form-group row">
    <label class="col-sm-3"><?php echo display('status') ?></label>
    <div class="col-xs-9"> 
        <div class="form-check">
            <label class="radio-inline"><input type="radio" name="status" id="active" value="1"><?php echo display('active') ?></label>
            <label class="radio-inline"><input type="radio" name="status" id="inactive" value="0"><?php echo display('inactive') ?></label>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-offset-3 col-sm-6">
        <div class="ui buttons">
            <button type="reset" class="ui button"><?php echo display('reset') ?></button>
            <div class="or"></div>
            <button class="ui positive button"><?php echo display('save') ?></button>
        </div>
    </div>
</div>

<?php echo form_close() ?>
      </div>
    </div>

  </div>
</div>