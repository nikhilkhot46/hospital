<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-success" href="<?php echo base_url("billing/admission/form") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_admission') ?> </a>  
                </div>
                <div class="btn-group"> 
                    <a class="btn btn-success" href="<?php echo base_url("billing/service/extra_service") ?>"> <i class="fa fa-plus"></i>  <?php echo display('patient_service') ?> </a>  
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable2 table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead> 
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('admission_id') ?></th>
                            <th><?php echo display('patient_id') ?></th>
                            <th><?php echo display('admission_date') ?></th>
                            <th><?php echo display('discharge_date') ?></th>
                            <th><?php echo display('doctor_name') ?></th>
                            <th><?php echo display('package_name') ?></th>
                            <th><?php echo display('insurance_name') ?></th>
                            <th><?php echo display('policy_no') ?></th>
                            <th><?php echo display('agent_name') ?></th>
                            <th><?php echo display('guardian_name') ?></th>
                            <th><?php echo display('guardian_relation') ?></th>
                            <th><?php echo display('guardian_contact') ?></th>
                            <th><?php echo display('guardian_address') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($admissions)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($admissions as $admission) { ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $admission->admission_id; ?></td>
                                    <td><?php echo $admission->patient_id; ?></td>
                                    <td><?php echo $admission->admission_date; ?></td>
                                    <td><?php echo $admission->discharge_date; ?></td>
                                    <td><?php echo $admission->doctor_name; ?></td>
                                    <td><?php echo $admission->package_name; ?></td>
                                    <td><?php echo $admission->insurance_name; ?></td>
                                    <td><?php echo $admission->policy_no; ?></td>
                                    <td><?php echo $admission->agent_name; ?></td>
                                    <td><?php echo $admission->guardian_name; ?></td>
                                    <td><?php echo $admission->guardian_relation; ?></td>
                                    <td><?php echo $admission->guardian_contact; ?></td>
                                    <td><?php echo $admission->guardian_address; ?></td>
                                    <td><?php echo (($admission->status==1)?display('active'):display('inactive')); ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("billing/admission/edit/$admission->admission_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a> 
                                        <a href="<?php echo base_url("billing/admission/delete/$admission->admission_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a> 
                                        <button type="button" class="btn btn-info btn-xs" onclick="service('<?php echo $admission->admission_id ?>')" title="<?php echo display('service'); ?>" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
                                        <a href="<?php echo base_url("billing/admission/services/$admission->admission_id") ?>" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a> 
                                    </td>
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?> 
                        <?php } ?> 
                    </tbody>
                </table>  <!-- /.table-responsive -->
                <?php echo (!empty($links)?$links:null); ?>
            </div>
        </div>
    </div>
</div>
<script>
function service(admission_id){
    $("#admission_id").val(admission_id);
    $("#myModal").show();
}
$(document).on("click", ".close", function(event){
    $('#myModal').hide();
});

</script>
<div id="myModal" class="modal" role="dialog" style="background: rgba(0,0,0,.5); overflow:auto;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Service</h4>
      </div>
      <div class="modal-body">
        
        <?php echo form_open('billing/admission/add_servie/','class="form-inner"') ?>

            <?php echo form_input(array('name' => 'admission_id', 'type'=>'hidden', 'id' =>'admission_id'));?>

            <div class="form-group row">
                <label for="name" class="col-xs-3 col-form-label"><?php echo display('service_name') ?> <i class="text-danger">*</i></label>
                <div class="col-xs-9">
                    <input name="name"  type="text" class="form-control" id="name" placeholder="<?php echo display('service_name') ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-xs-3 col-form-label"><?php echo display('description') ?></label>
                <div class="col-xs-9">
                    <textarea name="description" class="form-control"  placeholder="<?php echo display('description') ?>" rows="7"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="quantity" class="col-xs-3 col-form-label"><?php echo display('quantity') ?> <i class="text-danger">*</i></label>
                <div class="col-xs-9">
                    <input name="quantity"  type="text" class="form-control" id="quantity" placeholder="<?php echo display('quantity') ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="amount" class="col-xs-3 col-form-label"><?php echo display('rate') ?> <i class="text-danger">*</i></label>
                <div class="col-xs-9">
                    <input name="amount"  type="text" class="form-control" id="amount" placeholder="<?php echo display('amount') ?>" required>
                </div>
            </div>

            <!--Radio-->
            <div class="form-group row">
                <label class="col-sm-3"><?php echo display('status') ?></label>
                <div class="col-xs-9"> 
                    <div class="form-check">
                        <label class="radio-inline"><input type="radio" name="status" value="1" checked><?php echo display('active') ?></label>
                        <label class="radio-inline"><input type="radio" name="status" value="0"><?php echo display('inactive') ?></label>
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