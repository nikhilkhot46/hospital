<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("blood_bank/blood/report") ?>"> <i class="fa fa-list"></i>  <?php echo display('report') ?> </a> 
                </div>
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("patient/create") ?>"> <i class="fa fa-list"></i>  <?php echo display('add_patient') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('blood_bank/blood/sell_blood/'.$sell->sell_id,'class="form-inner"') ?>
                            <?php echo form_hidden('sell_id',$sell->sell_id);?>
                            
                            <div class="form-group row">
                                <label for="patient_id" class="col-xs-3 col-form-label"><?php echo display('patient_id') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="patient_id"  type="text" class="form-control" id="patient_id" placeholder="<?php echo display('patient_id') ?>" value="<?php echo $sell->patient_id ?>" autocomplete="off">
                                    <span class="text-danger"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="blood_type" class="col-xs-3 col-form-label"><?php echo display('blood_group') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <?php $sell->blood_type = str_replace("+","plus",$sell->blood_type) ?>
                                    <?php $sell->blood_type = str_replace("-","minus",$sell->blood_type) ?>
                                    <?php echo form_dropdown('blood_type', $this->config->item('blood_group'), $sell->blood_type, 'class="form-control" onchange="checkQty(this.value)" id="blood_type"') ?>
                                    <span class="text-danger"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-xs-3 col-form-label"><?php echo display('quantity') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="quantity"  type="text" class="form-control" id="quantity" placeholder="<?php echo display('quantity') ?>" value="<?php echo $sell->qty ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="charge" class="col-xs-3 col-form-label"><?php echo display('charge') ?></label>
                                <div class="col-xs-9">
                                <input name="charge" onchange="calc()" type="text" class="form-control" id="charge" placeholder="<?php echo display('charge') ?>" value="<?php echo $sell->charge ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-xs-3 col-form-label"><?php echo display('discount') ?> (%)</label>
                                <div class="col-xs-9">
                                <input name="discount" onchange="calc()" type="text" class="form-control" id="discount" placeholder="<?php echo display('discount') ?>" value="<?php echo $sell->discount ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tax" class="col-xs-3 col-form-label"><?php echo display('tax') ?> (%)</label>
                                <div class="col-xs-9">
                                <input name="tax" onchange="calc()" type="text" class="form-control" id="tax" placeholder="<?php echo display('tax') ?>" value="<?php echo $sell->tax ?>">
                                </div>
                            </div>

                            <script>
                            calc()
                                function calc(){
                                    $("#discount").val("0")
                                    $("#tax").val("0")
                                    var charge = parseFloat($("#charge").val());
                                    var dis = parseFloat($("#discount").val());
                                    var tax = parseFloat($("#tax").val());
                                    var cal = charge - (charge*(dis/100));
                                    var taxcal = cal + (charge*(tax/100));
                                    setTimeout(function (){
                                        if(isNaN(parseFloat(taxcal))){
                                            $("#total").val("0");
                                        }else{
                                            $("#total").val(parseFloat(taxcal));
                                        }
                                    },100);
                                }

                                function checkQty(value) {
                                    $.ajax({
                                    url  : '<?= base_url('blood_bank/blood/bloodStock') ?>',
                                    type : 'post',
                                    //dataType : 'JSON',
                                    data : {
                                        '<?= $this->security->get_csrf_token_name(); ?>' : '<?= $this->security->get_csrf_hash(); ?>',
                                        'blood_group' : value
                                    },
                                    success : function(data) 
                                    {
                                        if(!isNaN(data)){
                                            $('#blood_type').next().next().text("Available Qty: "+data).addClass('text-success').removeClass('text-danger');
                                        }
                                        else{
                                            $('#blood_type').next().next().text(data).addClass('text-danger').removeClass('text-success');
                                        }
                                        
                                    }, 
                                    error : function()
                                    {
                                        alert('failed');
                                    }
                                });
                                }
                            </script>

                            <div class="form-group row">
                                <label for="total" class="col-xs-3 col-form-label"><?php echo display('total') ?></label>
                                <div class="col-xs-9">
                                <input name="total"  type="text" class="form-control" id="total" placeholder="<?php echo display('total') ?>" value="<?= $sell->total?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3"><?= display('status');?></label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                    <?php 
                                    if($sell->sell_id){
                                    ?>
                                     <label class="radio-inline">
                                        <input type="radio" <?= $sell->status==1?"checked":"" ?> name="status" value="1"><?= display('paid');?></label>
                                        <label class="radio-inline">
                                        <input type="radio" <?= $sell->status==0?"checked":"" ?> name="status" value="0"><?= display('unpaid');?></label>
                                    <?php
                                    }else{
                                    ?>
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="1"><?= display('paid');?></label>
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="0" checked><?= display('unpaid');?></label>
                                    <?php
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('onaid') ?></label>
                                <div class="col-xs-9">
                                    <div class="checkbox checkbox-success">
                                            <input id="admission_id" name="admission_id" type="checkbox" <?php if($sell->admission_id != '') echo 'checked'; ?>>
                                            <label for="admission_id"><?php echo display("onaid") ?></label>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            if($sell->bill_generated == 0){
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
                </div>
            </div>
        </div>
    </div>

</div>



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
 
 </script>