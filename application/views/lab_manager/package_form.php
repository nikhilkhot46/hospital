<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div class="panel panel-default thumbnail">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("lab_manager/package") ?>"> <i class="fa fa-list"></i>  <?php echo display('package_list') ?> </a>
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-12 col-sm-12">

                        <?php echo form_open('lab_manager/package/form/' . $package->package_id, 'class="form-inner"') ?>

                            <?php echo form_hidden('package_id', $package->package_id) ?>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <label for="package_name" class="col-xs-3 col-form-label"><?php echo display('package_name') ?> <i class="text-danger">*</i></label>
                                        <div class="col-xs-9">
                                            <input name="package_name"  type="text" class="form-control" id="package_name" placeholder="<?php echo display('package_name') ?>" value="<?php echo $package->package_name ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group row">
                                        <label class="col-sm-3"><?php echo display('status') ?></label>
                                        <div class="col-xs-9">
                                            <div class="form-check">
                                                <label class="radio-inline"><input type="radio" name="status" value="1" checked><?php echo display('active') ?></label>
                                                <label class="radio-inline"><input type="radio" name="status" value="0"><?php echo display('inactive') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <label class="col-sm-12"><?php echo display('tests') ?></label>
                            <?php if (count($tests_data) > 0) {?>
                                <?php foreach ($tests_data as $key => $value) {?>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <?php $arr=[];
                                                $data = explode(",",$package->package_tests);
                                                foreach ($data as $d) {
                                                    $arr[]=$d;
                                                }
                                            ?>
                                                <input type="checkbox" name="tests[]" id="<?=$value->test_name?>" class="package_tests"
                                                        value="<?php echo $value->test_id; ?>" data-testprice="<?php echo $value->test_price; ?>"
                                                <?php if (in_array($value->test_id, $arr)) {echo "checked";}?>>

                                                <label for="<?=$value->test_name?>"> <?php echo $value->test_name . " (" . $value->test_short_name . ")"; ?> </label>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php } else {?>
                                                <div class="col-md-4">
                                                    <span>Add Tests to create package.</span>
                                                </div>
                                                <?php }?>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="actual_price" class="col-xs-4 col-form-label"><?php echo display('actual_price') ?></label>
                                        <div class="col-xs-8">
                                        <input name="actual_price"  type="text" class="form-control" id="actual_price" placeholder="<?php echo display('actual_price') ?>" value="<?php echo $package->actual_price ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="discount" class="col-xs-4 col-form-label"><?php echo display('discount') ?> <i class="text-danger">*</i></label>
                                        <div class="col-xs-8">
                                            <input name="discount"  type="text" class="form-control" id="discount" placeholder="<?php echo display('discount') ?>" value="<?php echo $package->discount ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="final_price" class="col-xs-4 col-form-label"><?php echo display('final_price') ?> <i class="text-danger">*</i></label>
                                        <div class="col-xs-8">
                                            <input name="final_price"  type="text" class="form-control" id="final_price" placeholder="<?php echo display('final_price') ?>" value="<?php echo $package->final_price ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="package_description" class="col-xs-2 col-form-label"><?php echo display('description') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-10">
                                    <textarea id="package_description" name="package_description" placeholder="<?=display('description')?>" class="form-control"><?=$package->package_description?></textarea>
                                </div>
                            </div>


                            <!--Radio-->


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
<script>
$(document).on('change', '.package_tests', function() {
    event.preventDefault();
    var price = 0,
    discount_percent = Number($("#discount").val()),
    discount_price = 0;

    if($("#actual_price").val() != ""){
        price = Number($("#actual_price").val());
    }

    if($(this).is(":checked")) {
        price += Number($(this).data("testprice"));
    }else{
        price -= Number($(this).data("testprice"));
    }
    $("#actual_price").val(price.toFixed(2));
    discount_price = ((discount_percent/100)*price);
    $("#final_price").val((price-discount_price).toFixed(2));
});
$(document).on('change', '#discount', function() {
    event.preventDefault();
    var actual_price = Number($("#actual_price").val()),
    discount_percent = Number($("#discount").val()),
    discount_price = ((discount_percent/100)*actual_price);

    if(discount_percent < 0 || discount_percent > 100){
        $(this).val(0);
    }else{
        $("#final_price").val((actual_price-discount_price).toFixed(2));    
    }
});
</script>