<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd billing-panel ">

            <div class="panel-heading no-print row">
                <div class="btn-group col-xs-2"> 
                    <a class="btn btn-primary" href="<?php echo base_url("billing/bill") ?>"> <i class="fa fa-list"></i>  <?php echo display('opd_list') ?> </a>  
                </div>
                <h2 class="col-xs-10 text-left text-success"><?php echo display('add_bill') ?></h2>
            </div> 
 
            <div class="panel-body">
            <?php echo form_open("billing/bill/add_opd_bill/$patient_id/$appointment_id", array('class'=>'billig-form')) ?>
                <div class="row">
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                        <input type="hidden" class="form-control" id="appointment_id" value="<?= $appointment_id?>"required/>
                                            <input type="text" class="form-control" id="patient_id" value="<?= $patient_id?>" placeholder="<?php echo display('patient_id') ?>" disabled required/>
                                            <span class="input-group-btn"></span>
                                        </div>
                                        <span id="errorMsg" style="color:red"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input name="bill_date" type="text" class="form-control datepicker" id="bill_date"  placeholder="<?php echo display('bill_date') ?>" required/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="<?php echo display('patient_name') ?>" readonly/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="date_of_birth" placeholder="<?php echo display('date_of_birth') ?>" disabled/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" placeholder="<?php echo display('address') ?>" id="address" disabled></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label for="sex" class="col-sm-4 col-md-2 col-form-label"><?php echo display('sex') ?></label>
                                    <div id="sex" class="col-sm-8 col-md-10">
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="male"  disabled>
                                            <label for="male"><?php echo display('male') ?></label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="female" disabled>
                                            <label for="female"><?php echo display('female') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="doctor_name"  placeholder="<?php echo display('doctor_name') ?>" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="avatar-img center-block">
                            <img id="picture" src="<?php echo base_url('assets/images/staff.png') ?>" style="max-height:178px; width:100%" class="img-responsive" alt="">
                        </div> 
                    </div>
                </div>

                <style>
                table tr th{
                    background-color: rgb(235, 237, 242) !important;
                }
                </style>
                <div id="bdservices" class="table-responsive">
                    <!-- bloog sell data load-->    
                </div>

                <input type="hidden" id="pre_service_charge">

                <div id="parentx" class="table-responsive">
                    <table id="fixTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="100"><i class="fa fa-cogs"></i></th>
                                <th><?php echo display('service_name') ?></th>
                                <th><?php echo display('quantity') ?></th>
                                <th><?php echo display('rate') ?></th>
                                <th><?php echo display('subtotal') ?></th>
                            </tr>
                        </thead>
                        <tbody id="services">
                        </tbody>
                    </table>
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <textarea name="note" class="form-control" rows="5" placeholder="<?php echo display('notes') ?>"></textarea>
                        </div> 
                    </div>



                    <div class="col-sm-4">
                        <div class="form-group row">
                            <label class="col-sm-4 col-md-4 col-form-label"><?php echo display('payment_method') ?></label>
                            <div class="col-sm-8 col-md-8">
                                <?php 
                                    $paymentList = array(
                                        ''    => display('select_option'),
                                        'Cash'=>display('cash'),
                                        'Card'=>display('card'),
                                        'Cheque'=>display('cheque'),
                                    );
                                    echo form_dropdown('payment_method', $paymentList, null, array('class'=>'form-control basic-single', 'required'=>'required'));
                                ?>  
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="card_cheque_no" class="col-sm-4 col-md-4 col-form-label"><?php echo display('card_cheque_no') ?></label>
                            <div class="col-sm-8 col-md-8">
                                <input name="card_cheque_no" class="form-control" type="text" id="card_cheque_no" placeholder="<?php echo display('card_cheque_no') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="receipt_no" class="col-sm-4 col-md-4 col-form-label"><?php echo display('receipt_no') ?></label>
                            <div class="col-sm-8 col-md-8">
                                <input name="receipt_no" class="form-control" type="text" value="" id="receipt_no" placeholder="<?php echo display('receipt_no') ?>">
                            </div>
                        </div> 
                    </div>



                    <div class="col-sm-4">
                        <div class="table-responsive m-b-20">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo display('total') ?></th>
                                        <th><?php echo display('receipt') ?></th>
                                    </tr>
                                </thead>
                                <tbody
                                    <tr>
                                        <td><?php echo display('total') ?></td>
                                        <td><input name="total" type="text" class="form-control grand-calc" id="total" value="0.00"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                              <div class="input-group-addon"><?php echo display('discount') ?> %</div>
                                              <input type="text" id="discountPercent" required="" autocomplete="off" class="form-control tax-discount-calc" value="0">
                                            </div>
                                        </td>
                                        <td><input name="discount" type="text" class="form-control grand-calc" id="discount" value="0.00"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                              <div class="input-group-addon"><?php echo display('tax') ?> %</div>
                                              <input type="text" id="taxPercent" required="" autocomplete="off" class="form-control tax-discount-calc" value="0">
                                            </div>
                                        </td>
                                        <td><input name="tax" type="text" class="form-control grand-calc" id="tax" value="0.00"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo display('pay_advance') ?></td>
                                        <td><input type="text" class="form-control grand-calc" id="pay_advance" value="0.00"></td> 
                                    </tr>
                                    <tr>
                                        <td><?php echo display('payable') ?></td>
                                        <td><input type="text" class="form-control grand-calc" id="payable" value="0.00"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="form-check">
                        <label class="radio-inline"><input type="radio" name="status" value="0" checked><?php echo display('unpaid') ?></label>
                        <label class="radio-inline"><input type="radio" name="status" value="1"><?php echo display('paid') ?></label>
                    </div>
                </div> 


                <div class="panel-footer text-center"> 
                    <button type="submit" class="btn btn-success w-md"><?php echo display('save') ?></button>
                </div>

            <?php echo form_close() ?>
            </div>

        </div>
    </div>
</div> 

<script type="text/javascript">
$(document).ready(function(){

    // Enable sidebar push menu
    if ($("body").hasClass('sidebar-collapse')) {
        $("body").removeClass('sidebar-collapse').trigger('expanded.pushMenu');
    } else {
        $("body").addClass('sidebar-collapse').trigger('collapsed.pushMenu');
    }


    // #---------------ADD OR REMOVE ITEM-------------------#
    var services_html = "<tr>"+
    "<td><div class=\"btn btn-group\">"+
        "<button type=\"button\" class=\"addMore btn btn-sm btn-success\">+</button>"+
        "<button type=\"button\" class=\"remove btn btn-sm btn-danger\">-</button>"+
    "</div></td>"+
    "<td><input name=\"service_name[]\" class=\"form-control service_name service_data\" type=\"text\" placeholder=\"<?php echo display('service_name') ?>\"><input name=\"service_id[]\" type=\"hidden\" class=\"service_id\"></td>"+
    "<td><input name=\"quantity[]\" class=\"form-control quantity item-calc\" type=\"text\" placeholder=\"<?php echo display('quantity') ?>\" value=\"1\"></td>"+
    "<td><input name=\"amount[]\" class=\"form-control amount item-calc\" type=\"text\" placeholder=\"<?php echo display('amount') ?>\"  value=\"0.00\"></td>"+
    "<td><input name=\"subtotal[]\" class=\"form-control subtotal\" type=\"text\" placeholder=\"<?php echo display('subtotal') ?>\"  value=\"0.00\"></td>"+
    "</tr>";

    $("#services").append(services_html);
    $('body').on('click', '.addMore', function() {
        $("#services").append(services_html); 

        //total   
        var total = 0;
        $('.subtotal').each(function(){ 
            total  += parseFloat($(this).val());
            $('#total').val(total.toFixed(2));
        });  

        var xx = parseFloat($('#pre_service_charge').val())+parseFloat($('#total').val());
        $('#total').val(xx.toFixed(2));

        $("#payable").val(
            (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
        );   

    });


    $('body').on('click', '.remove', function() {
       $(this).parent().parent().parent().remove();
 
        //total   
        var total = 0;
        $('.subtotal').each(function(){ 
            total  += parseFloat($(this).val());
            $('#total').val(total.toFixed(2));
        });  
        
        var xx = parseFloat($('#pre_service_charge').val())+total;
        $('#total').val(xx.toFixed(2));

        var tax = $("#tax").val();
        var discount = $("#discount").val();
        $("#taxPercent").val(parseFloat((tax/xx) * 100).toFixed(2)); 
        $("#discountPercent").val(parseFloat((discount/xx) * 100).toFixed(2));  

        $("#payable").val(
            (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
        );   
    });


    // #----------------------------------------------#
    var patient_id     = $("#patient_id");
    var appointment_id     = $("#appointment_id");
    var patient_name   = $("#patient_name");
    var address        = $("#address");
    var date_of_birth  = $("#date_of_birth");
    var male           = $("#male");
    var female         = $("#female"); 
    var doctor_name    = $("#doctor_name"); 
    var picture        = $("#picture"); 
    var discount       = $("#discount"); 
    // #----------------------------------------------#
    window.onload = codeAddress;
    var pid = $("#patient_id");
    function codeAddress(){
        patient_name.val('');
        address.val('');
        male.val('');
        female.val('');
        doctor_name.val('');
        picture.attr('src',''); 
        discount.val('0.00'); 

        $.ajax({
            url: '<?php echo base_url('billing/bill/getInformationForOpd') ?>',
            method: 'post',
            dataType: 'json',
            data: {
                patient_id: patient_id.val(),
                appointment_id: appointment_id.val(),
                '<?= $this->security->get_csrf_token_name() ?>':'<?= $this->security->get_csrf_hash() ?>'
            },
            success: function(data)
            {  

                if (data.status==true)
                {
                    //patient information 
                    patient_name.val(data.result.patient_name);
                    address.val(data.result.address);
                    date_of_birth.val(data.result.date_of_birth);
                    if(data.result.sex=="female")
                    {
                        male.removeAttr('checked');
                        female.attr('checked','checked'); 
                    }
                    else
                    {
                        male.attr('checked','checked');
                        female.removeAttr('checked');
                    }
                    picture.attr('src','<?= base_url() ?>'+data.result.picture);

                    //doctor information
                    doctor_name.val(data.result.doctor_name);

                    //blood details
                    $("#bdservices").html(data.bd_service);
                    
                    //success state
                    pid.parent().removeClass('has-error').addClass('has-success');
                    pid.next().html('<button type="button" class="btn btn-success"><i class="fa fa-check"></i></button>');


                    //advance_data payment
                    
                    var pre_service = parseFloat(data.pre_service_charge);
                    $('#pre_service_charge').val(pre_service.toFixed(2));
                    //total   
                    var total = 0;
                    $('.subtotal').each(function(){ 
                        total  += parseFloat($(this).val());
                        $('#total').val(total.toFixed(2));
                    });  
                    var xx = parseFloat($('#pre_service_charge').val())+parseFloat($('#total').val());
                    $('#total').val(parseFloat(xx));
                    
                    $("#discountPercent").val(parseFloat((data.result.discount/xx) * 100).toFixed(2)); 
                    $("#taxPercent").val("0.00");
                    $("#discount").val(parseFloat(($("#discountPercent").val()/100) * xx).toFixed(2));

                    $("#payable").val(
                        (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
                    );   
                }
                else if(data.status1 == false){
                    pid.parent().addClass('has-error').removeClass('has-success');
                    $("#errorMsg").text(data.result);
                    pid.next().html('<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>');
                }
                else
                {
                    pid.parent().addClass('has-error').removeClass('has-success');
                    pid.next().html('<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>');
                }
            },
            error: function(e)
            {
                alert('failed...');
            }
        });
    }


 
    // #---------------SERVICE LIST-------------------#
    var options = {
      minLength: 0,
      source: [
        <?php 
        foreach ($service_list as $service):
            echo "{label:'$service->name', service_id:'$service->id', quantity:'$service->quantity', amount:'$service->amount'}, "; 
        endforeach;
        ?>
        ],
        focus: function( event, ui ) {
            $(this).val(ui.item.label);
            return false;
        },
        select: function( event, ui ) {
            $(this).parent().parent().find(".service_name").val(ui.item.label);
            $(this).parent().parent().find(".service_id").val(ui.item.service_id);
            $(this).parent().parent().find(".quantity").val(ui.item.quantity);
            $(this).parent().parent().find(".amount").val(ui.item.amount);
            $(this).parent().parent().find(".subtotal").val(parseFloat(ui.item.amount)*parseFloat(ui.item.quantity));

            //total   
            var total = 0;
            $('.subtotal').each(function(){ 
                total  += parseFloat($(this).val());
                $('#total').val(total.toFixed(2));
            });  
            var xx = parseFloat($('#pre_service_charge').val())+parseFloat($('#total').val());
            $('#total').val(xx.toFixed(2));
            var tax = $("#tax").val();
            var discount = $("#discount").val();
            $("#taxPercent").val(parseFloat((tax/xx) * 100).toFixed(2)); 
            $("#discountPercent").val(parseFloat((discount/xx) * 100).toFixed(2)); 


            $("#payable").val(
                (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
            );  
            return false;
        }
    } 

    $('body').on('keydown.autocomplete', '.service_data', function() {
        $(this).autocomplete(options);
    });


    // total summation
    $('body').on('keyup', '.item-calc', function() {
        var qty = $(this).parent().parent().find(".quantity").val();
        var amt = $(this).parent().parent().find(".amount").val();
        $(this).parent().parent().find(".subtotal").val((qty*amt).toFixed(2));

        //total   
        var total = 0;
        $('.subtotal').each(function(){ 
            total  += parseFloat($(this).val());
            $('#total').val(total.toFixed(2));
        }); 

        var xx = parseFloat($('#pre_service_charge').val())+parseFloat($('#total').val());
        $('#total').val(xx.toFixed(2));
        
        var tax = $("#tax").val();
        var discount = $("#discount").val();
        $("#taxPercent").val(parseFloat((tax/xx) * 100).toFixed(2)); 
        $("#discountPercent").val(parseFloat((discount/xx) * 100).toFixed(2));  

        $("#payable").val(
            (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
        );  
    });
 
    
    // grand total summation
    $('body').on('keyup', '.grand-calc', function() {  

        var total       = $('#total').val();
        var tax         = $('#tax').val();
        var discount    = $('#discount').val(); 
        $("#taxPercent").val(parseFloat((tax/total) * 100).toFixed(2)); 
        $("#discountPercent").val(parseFloat((discount/total) * 100).toFixed(2)); 

        $("#payable").val(
            (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
        );  
    });

    // tax-discount-calc
    $('body').on('keyup', '.tax-discount-calc', function() 
    {   
        var total = $("#total").val();
        var discountPercent = $("#discountPercent").val(); 
        $("#discount").val(((parseFloat(discountPercent)/100)*parseFloat(total)).toFixed(2));

        var taxPercent = $("#taxPercent").val(); 
        $("#tax").val(((parseFloat(taxPercent)/100)*parseFloat(total)).toFixed(2));
 

        $("#payable").val(
            (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
        );  
    });
});
</script>