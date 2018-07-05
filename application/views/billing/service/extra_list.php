<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-success" href="<?php echo base_url("billing/admission") ?>"> <i class="fa fa-list"></i>  <?php echo display('admission_list') ?> </a>  
                </div>
                <div class="btn-group"> 
                    <a class="btn btn-success" href="<?php echo base_url("billing/admission/form") ?>"> <i class="fa fa-list"></i>  <?php echo display('add_admission') ?> </a>  
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable2 table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('admission_id') ?></th>
                            <th><?php echo display('service_name') ?></th>
                            <th><?php echo display('description') ?></th>
                            <th><?php echo display('quantity') ?></th>
                            <th><?php echo display('rate') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($services)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($services as $service) { ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $service->patient_aid; ?></td>
                                    <td><?php echo $service->name; ?></td>
                                    <td><?php echo character_limiter($service->description, 60); ?></td>
                                    <td><?php echo $service->quantity; ?></td>
                                    <td><?php echo $service->amount; ?></td>
                                    <td><?php echo (($service->status==1)?display('active'):display('inactive')); ?></td>
                                    <td class="center">
                                        <a href="javascript:;" class="btn btn-xs btn-primary" onclick='service(<?php echo json_encode($service) ?>)'><i class="fa fa-edit"></i></a> 
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
function service(x){
    $("#id").val(x.id);
    $("#admission_id").val(x.patient_aid);
    $("#name").val(x.name);
    $("#description").val(x.description);
    $("#quantity").val(x.quantity);
    $("#amount").val(x.amount);
    $("input[name=status]").val([x.status]);
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
        <h4 class="modal-title">Edit Service</h4>
      </div>
      <div class="modal-body">
        
        <?php echo form_open('billing/service/update_servie/','class="form-inner"') ?>

            <?php echo form_input(array('name' => 'admission_id', 'type'=>'hidden', 'id' =>'admission_id'));?>
            <?php echo form_input(array('name' => 'id', 'type'=>'hidden', 'id' =>'id'));?>

            <div class="form-group row">
                <label for="name" class="col-xs-3 col-form-label"><?php echo display('service_name') ?> <i class="text-danger">*</i></label>
                <div class="col-xs-9">
                    <input name="name"  type="text" class="form-control" id="name" placeholder="<?php echo display('service_name') ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-xs-3 col-form-label"><?php echo display('description') ?></label>
                <div class="col-xs-9">
                    <textarea name="description" id="description" class="form-control"  placeholder="<?php echo display('description') ?>" rows="7"></textarea>
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
                        <label class="radio-inline"><input type="radio" name="status" id="status1" value="1"><?php echo display('active') ?></label>
                        <label class="radio-inline"><input type="radio" name="status" id="status0" value="0"><?php echo display('inactive') ?></label>
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