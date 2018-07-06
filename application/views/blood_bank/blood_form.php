<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("blood_bank/blood") ?>"> <i class="fa fa-list"></i>  <?php echo display('blood_stock') ?> </a> 
                </div>
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("blood_bank/blood/blood_doners") ?>"> <i class="fa fa-list"></i>  <?php echo display('add_doner') ?> </a> 
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('blood_bank/blood/form/'.$purchase->purchse_id,'class="form-inner"') ?>

                            <?php echo form_hidden('purchse_id',$purchase->purchse_id) ?>

                            <div class="form-group row">
                                <label for="blood_type" class="col-xs-3 col-form-label"><?php echo display('blood_group') ?><span class="text-danger">*</span> <?php echo form_error('blood_type') ?></label>
                                <div class="col-xs-9">
                                    <?php echo form_dropdown('blood_type', $this->config->item('blood_group'), $purchase->blood_type, 'class="form-control input-sm" id="blood_type"'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="donar_id" class="col-xs-3 col-form-label"><?php echo display('donar_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                <select name="donar_id" class="form-control dont-select-me" required>
                                </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="blood_qty" class="col-xs-3 col-form-label"><?php echo display('quantity') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="blood_qty"  type="text" class="form-control" id="blood_qty" placeholder="<?php echo display('quentity') ?>" value="<?php echo $purchase->blood_qty ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-xs-3 col-form-label"><?php echo display('price') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="price"  type="text" class="form-control" id="price" placeholder="<?php echo display('price') ?>" value="<?php echo $purchase->price ?>">
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
    </div>

</div>
<script type="text/javascript">


    $(document).ready(function() {
        $('select[name="blood_type"]').on('change', function() {
            var blood_type = $(this).val();
            if(blood_type) {
                var x = '<?php echo $purchase->donar_id; ?>';
                $.ajax({
                    url: '<?php echo base_url() ?>blood_bank/blood/getDonors/'+blood_type,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="donar_id"]').empty();
                        console.log(data);
                        $.each(data, function(key, value) {
                            console.log(value['donor_id']);
                            $('select[name="donar_id"]').append('<option value="'+ value['donor_id'] +'">'+ value['donar_name'] +'</option>');
                        });

                        setTimeout(() => {
                            $('select[name="donar_id"]').val(x);
                        }, 1000);
                    }
                });
            }else{
                $('select[name="donar_id"]').empty();
            }
        });
    });
</script>