<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd billing-panel ">

            <div class="panel-heading no-print row">
                <div class="btn-group col-xs-3"> 
                    <a class="btn btn-primary" href="<?php echo base_url("billing/bill") ?>"> <i class="fa fa-list"></i>  <?php echo display('bill_list') ?> </a>  
                    <a class="btn btn-success" href="<?php echo base_url("billing/bill/form") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_bill') ?> </a>  
                </div>
                <h2 class="col-xs-9 text-left text-success"><?php echo display('update_bill') ?></h2>
            </div> 
 
            <div class="panel-body">

            <?php echo form_open('billing/bill/edit/'.$bill->bill_id, array('class'=>'billig-form')) ?>
            <?php echo form_hidden('id', $bill->id) ?>
            <?php echo form_hidden('bill_id', $bill->bill_id) ?>
                <div class="row">
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="admission_id" value="<?php echo $bill->admission_id ?>" name="admission_id" placeholder="<?php echo display('admission_id') ?>" readonly/>
                                            <span class="input-group-btn"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="patient_id" value="<?php echo $bill->patient_id ?>" placeholder="<?php echo display('patient_id') ?>" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input name="bill_date" type="text" class="form-control datepicker" id="bill_date"  placeholder="<?php echo display('bill_date') ?>" value="<?php echo $bill->bill_date ?>" required/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="patient_name" placeholder="<?php echo display('patient_name') ?>" value="<?php echo $bill->patient_name ?>" disabled/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="date_of_birth" placeholder="<?php echo display('date_of_birth') ?>" value="<?php echo $bill->date_of_birth ?>" disabled/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" placeholder="<?php echo display('address') ?>" id="address" disabled><?php echo $bill->address ?></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group row">
                                    <label for="sex" class="col-sm-4 col-md-2 col-form-label"><?php echo display('sex') ?></label>
                                    <div id="sex" class="col-sm-8 col-md-10">
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="male"  disabled <?php echo (($bill->sex=="Male")?"checked":"") ?>>
                                            <label for="male"><?php echo display('male') ?></label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="female" <?php echo (($bill->sex=="Female")?"checked":"") ?>  disabled>
                                            <label for="female"><?php echo display('female') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="doctor_name"  placeholder="<?php echo display('doctor_name') ?>" value="<?php echo $bill->doctor_name ?>" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="avatar-img center-block">
                            <img id="picture" src="<?php echo (!empty($bill->picture)?base_url($bill->picture):base_url('assets/images/staff.png')) ?>" style="max-height:178px" class="img-responsive" alt="">
                        </div> 
                    </div>
                </div>

                <!--<hr>-->
                <div class="form-horizontal">
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group row">
                                <label for="admission_date" class="col-sm-4 col-form-label"><?php echo display('admission_date') ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="<?php echo $bill->admission_date ?>" placeholder="<?php echo display('admission_date') ?>" id="admission_date" disabled>
                                </div>
                            </div>
                        </div> 
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group row">
                                <label for="package_name" class="col-sm-4 col-form-label"><?php echo display('package_name') ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="package_name" type="text" value="<?php echo $bill->package_name ?>" placeholder="<?php echo display('package_name') ?>" id="package_name" disabled>
                                    <input name="package_id" type="hidden" id="package_id"  value="<?php echo $bill->package_id ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group row">
                                <label for="total_days" class="col-sm-4 col-form-label"><?php echo display('total_days') ?><br/>&nbsp;</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text"  placeholder="<?php echo display('total_days') ?>" value="<?php echo $bill->total_days ?>" id="total_days" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group row">
                                <label for="discharge_date" class="col-sm-4 col-form-label"><?php echo display('discharge_date') ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="<?php echo $bill->discharge_date ?>" placeholder="<?php echo display('discharge_date') ?>" id="discharge_date" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group row">
                                <label for="insurance_name" class="col-sm-4 col-form-label"><?php echo display('insurance_name') ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="<?php echo $bill->insurance_name ?>" placeholder="<?php echo display('insurance_name') ?>" id="insurance_name" disabled>
                                </div>
                            </div>
                        </div> 
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group row">
                                <label for="policy_no" class="col-sm-4 col-form-label"><?php echo display('policy_no') ?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="<?php echo $bill->policy_no ?>" placeholder="<?php echo display('policy_no') ?>" id="policy_no" disabled>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
                <?php
                $CI =& get_instance();
                
                $CI->load->helper('array');
                $CI->load->model('blood_bank/blood_model');
                $bloodDetails = $CI->blood_model->get_blood_sell($bill->admission_id);
                $bdcharge=0;
                $result = '<table  class="charge">
                            <thead>
                                    <tr>
                                        <th style="width: 371px;">'.display("blood_group").'</th>
                                        <th style="width:270px">'.display("quantity").'</th>
                                        <th style="width:270px">'. display("rate").'</th>
                                        <th>'.display("subtotal").'</th>
                                    </tr>
                            </thead>
                        <tbody>';
                foreach ($bloodDetails as $bd) {
                    $result .= "<tr>";
                    $result .= "<td>".element($bd->blood_type,$CI->config->item('blood_group'))."</td>";
                    $result .= "<td>$bd->qty</td>";
                    $result .= "<td>$bd->charge</td>";
                    $result .= "<td>".number_format((float)$bd->charge, 2, '.', '')."</td>";
                    $result .= "</tr>";
                    $bdcharge = $bdcharge + number_format((float)$bd->charge, 2, '.', '');
                } 
                $result.="<tr><td colspan='3'></td><td><b>".number_format((float)$bdcharge, 2, '.', '')."</b></td></tr></tbody></table>";
                
                $CI->load->model('bed_manager/bed_assign_model');
                $CI->load->model('billing/admission_model');
                $patient_details = $CI->admission_model->read_by_id($bill->admission_id);
                $pid = $patient_details->patient_id;
                $bedDetails = $CI->bed_assign_model->get_assigned_bed($pid);
                $bedcharge=0;
                $result1 = '<table class="charge">
                            <thead>
                                    <tr>
                                        <th style="width: 371px;">'.display("bed_type").'</th>
                                        <th style="width:270px">'.display("days").'</th>
                                        <th style="width:270px">'. display("rate").'</th>
                                        <th>'.display("subtotal").'</th>
                                    </tr>
                            </thead>
                        <tbody>';
                foreach ($bedDetails as $bedd) {
                    $result1 .= "<tr>";
                    $result1 .="<td>".$bedd->type."</td>";
                    $result1 .="<td>".$bedd->days."</td>";
                    $result1 .="<td>".$bedd->charge."</td>";
                    $result1 .="<td>".$bedd->days*$bedd->charge."</td>";
                    $result1 .= "</tr>";
                    $bedcharge = $bedcharge +$bedd->days*$bedd->charge;
                }
                $result1.="<tr><td colspan='3'></td><td><b>".number_format((float)$bedcharge, 2, '.', '')."</b></td></tr></tbody></table>";
                
                $CI->load->model('lab_manager/lab_model');
                $lab_details = $CI->lab_model->read_by_aid($bill->admission_id);
                $labcharge=0;
                $result2 = '<table class="charge">
                            <thead>
                                    <tr>
                                        <th style="width: 371px;">'.display("test").'</th>
                                        <th style="width:270px">'.display("quantity").'</th>
                                        <th style="width:270px">'. display("charge").'</th>
                                        <th>'.display("subtotal").'</th>
                                    </tr>
                            </thead>
                        <tbody>';		
                foreach ($lab_details as $lab) {
                    $name = $lab->test_name?$lab->test_name:$lab->package_name;
                    $result2 .= "<tr>";
                    $result2 .="<td>".$name."</td>";
                    $result2 .="<td>1</td>";
                    $result2 .="<td>".$lab->total_price."</td>";
                    $result2 .="<td>".$lab->total_price."</td>";
                    $result2 .= "</tr>";
                    $labcharge = $labcharge + $lab->total_price;
                }
                $result2.="<tr><td colspan='3'></td><td><b>".number_format((float)$labcharge, 2, '.', '')."</b></td></tr></tbody></table>";
                
                $CI->load->model('invoices');
                $invoice_details = $CI->invoices->invoice_by_aid($bill->admission_id);
                $invcharge=0;
                $result3 = '<table class="charge">
                            <thead>
                                    <tr>
                                        <th>'.display("product_name").'</th>
                                        <th>'.display("quantity").'</th>
                                        <th>'.display("rate").'</th>
                                        <th>'.display("total").'</th>
                                        <th>'.display("discount").'</th>
                                        <th>'.display("tax").'</th>
                                        <th>'.display("paid").'</th>
                                        <th>'.display("subtotal").'</th>
                                    </tr>
                            </thead>
                        <tbody>';		
                foreach ($invoice_details as $value) {
                    $result3 .= "<tr>";
                    $result3 .="<td>".$value->product_name."</td>";
                    $result3 .="<td>".$value->quantity."</td>";
                    $result3 .="<td>".$value->rate."</td>";
                    $result3 .="<td>".$value->total_price."</td>";
                    $result3 .="<td>".$value->total_discount."</td>";
                    $result3 .="<td>".$value->total_tax."</td>";
                    $result3 .="<td>".$value->paid_amount."</td>";
                    $result3 .="<td>".$value->due_amount."</td>";
                    $result3 .= "</tr>";
                    $invcharge = $invcharge +$value->due_amount;
                }
                $result3.="<tr><td colspan='7'></td><td><b>".number_format((float)$invcharge, 2, '.', '')."</b></td></tr></tbody></table>";
                
                $CI->load->model('patient_model');
                $patient_services = $CI->patient_model->patient_service($bill->admission_id);
                $patientcharge=0;
                $result4 = '<table class="charge">
                            <thead>
                                    <tr>
                                        <th>'.display("service_name").'</th>
                                        <th>'.display("quantity").'</th>
                                        <th>'. display("rate").'</th>
                                        <th>'.display("subtotal").'</th>
                                    </tr>
                            </thead>
                        <tbody>';		
                foreach ($patient_services as $value) {
                    $result4 .="<tr>";
                    $result4 .="<td>".$value->name."</td>";
                    $result4 .="<td>".$value->quantity."</td>";
                    $result4 .="<td>".$value->amount."</td>";
                    $result4 .="<td>".$value->amount."</td>";
                    $result4 .="</tr>";
                    $patientcharge = $patientcharge +$value->amount;
                }
                $result4.="<tr><td colspan='3'></td><td><b>".number_format((float)$patientcharge, 2, '.', '')."</b></td></tr></tbody></table>";
                
                $total_charge = number_format((float)($bdcharge + $bedcharge + $labcharge + $invcharge + $patientcharge), 2, '.', '');;
                ?>
<input type="hidden" id="pre_service_charge" value="<?= $total_charge ?>">
 <?php echo $result;?><br>
                <?php echo $result1;?><br>
                <?php echo $result2;?><br>
                <?php echo $result3;?><br>
                <?php echo $result4;?><br>
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
                           <?php 
                            $subtotal = "0.00"; 
                            $sl = 1;  
                            foreach($services as $service)
                            {  
                                $subtotal+=($service->quantity*$service->amount); 
                            ?>
                            <tr>
                                <td>
                                    <div class="btn btn-group">
                                        <button type="button" class="addMore btn btn-sm btn-success">+</button>
                                        <button type="button" class="remove btn btn-sm btn-danger">-</button>
                                    </div>
                                </td>
                                <td>
                                    <input name="service_name[]" class="form-control service_name service_data" type="text" placeholder="<?php echo display('service_name') ?>" value="<?php echo $service->name; ?>" required><input name="service_id[]" type="hidden" class="service_id" value="<?php echo $service->id; ?>" required>
                                </td>
                                <td>
                                    <input name="quantity[]" class="form-control quantity item-calc" type="text" placeholder="<?php echo display('quantity') ?>" value="<?php echo $service->quantity; ?>" required>
                                </td>
                                <td>
                                    <input name="amount[]" class="form-control amount item-calc" type="text" placeholder="<?php echo display('amount') ?>"  value="<?php echo $service->amount; ?>"  required>
                                </td>
                                <td>
                                    <input name="subtotal[]" class="form-control subtotal" type="text" placeholder="<?php echo display('subtotal') ?>"  value="<?php echo ($service->quantity*$service->amount); ?>" required>
                                </td>
                            </tr>
                            <?php
                            } 
                            ?> 
                        </tbody>
                    </table>
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <h3 class="block-title-2"><?php echo display('advance_payment') ?></h3>
                        <div class="table-responsive table-height">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo display('date') ?></th>
                                        <th><?php echo display('receipt_no') ?></th>
                                        <th><?php echo display('amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="advance_data"> 
                                <?php  
                                    $pay_advance = "0.00";
                                    foreach($advance as $adv)
                                    {
                                    $pay_advance+=$adv->amount;
                                    ?>
                                    <tr>
                                        <td><?php echo $adv->date ?></td>
                                        <td><?php echo $adv->receipt_no ?></td>
                                        <td><?php echo $adv->amount ?></td>
                                    </tr>
                                    <?php
                                    }
                                ?>
                                </tbody>
                            </table>
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
                                    echo form_dropdown('payment_method', $paymentList, $bill->payment_method, array('class'=>'form-control basic-single', 'required'=>'required'));
                                ?>  
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="card_cheque_no" class="col-sm-4 col-md-4 col-form-label"><?php echo display('card_cheque_no') ?></label>
                            <div class="col-sm-8 col-md-8">
                                <input name="card_cheque_no" value="<?php echo $bill->card_cheque_no; ?>" class="form-control" type="text" id="card_cheque_no" placeholder="<?php echo display('card_cheque_no') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="receipt_no" class="col-sm-4 col-md-4 col-form-label"><?php echo display('receipt_no') ?></label>
                            <div class="col-sm-8 col-md-8">
                                <input name="receipt_no" class="form-control" type="text" value="<?php echo $bill->receipt_no; ?>" id="receipt_no" placeholder="<?php echo display('receipt_no') ?>">
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
                                        <td><?php echo display('total') ?></td><?php $subtotal = $subtotal + $total_charge;?>
                                        <td><input name="total" type="text" class="form-control grand-calc" id="total" value="<?php echo @sprintf("%.2f",(isset($subtotal)?$subtotal:"0.00")) ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                              <div class="input-group-addon"><?php echo display('discount') ?> %</div>
                                              <input type="text" id="discountPercent" required="" autocomplete="off" class="form-control tax-discount-calc" value="<?php echo @sprintf("%.2f",(($bill->discount/$subtotal)*100)) ?>">
                                            </div>
                                        </td>
                                        <td><input name="discount" type="text" class="form-control grand-calc" id="discount" value="<?php echo @sprintf("%.2f", $bill->discount) ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                              <div class="input-group-addon"><?php echo display('tax') ?> %</div>
                                              <input type="text" id="taxPercent" required="" autocomplete="off" class="form-control tax-discount-calc" value="<?php echo @sprintf("%.2f", (($bill->tax/$subtotal)*100)) ?>">
                                            </div>
                                        </td>
                                        <td><input name="tax" type="text" class="form-control grand-calc" id="tax" value="<?php echo @sprintf("%.2f", $bill->tax) ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo display('pay_advance') ?></td>
                                        <td><input type="text" class="form-control grand-calc" id="pay_advance" value="<?php echo @sprintf("%.2f", (isset($pay_advance)?$pay_advance:"0.00")) ?>"></td> 
                                    </tr>
                                    <tr>
                                        <td><?php echo display('payable') ?></td>
                                        <td><input type="text" class="form-control grand-calc" id="payable" value="<?php echo @sprintf("%.2f", ($subtotal-$bill->discount+$bill->tax-$pay_advance)) ?>"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <textarea name="note" class="form-control" rows="5" placeholder="<?php echo display('notes') ?>"><?php echo $bill->note; ?></textarea>
                </div> 


                <div class="form-group">
                    <div class="form-check">
                        <label class="radio-inline"><input type="radio" name="status" value="0" <?php echo (($bill->status==0)?"checked":null) ?>><?php echo display('unpaid') ?></label>
                        <label class="radio-inline"><input type="radio" name="status" value="1" <?php echo (($bill->status==1)?"checked":null) ?>><?php echo display('paid') ?></label>
                    </div>
                </div> 


                <div class="panel-footer text-center"> 
                    <button type="submit" class="btn btn-success w-md"><?php echo display('update') ?></button>
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
    "<td><input name=\"service_name[]\" class=\"form-control service_name service_data\" type=\"text\" placeholder=\"<?php echo display('service_name') ?>\" required><input name=\"service_id[]\" type=\"hidden\" class=\"service_id\" required></td>"+
    "<td><input name=\"quantity[]\" class=\"form-control quantity item-calc\" type=\"text\" placeholder=\"<?php echo display('quantity') ?>\" value=\"1\" required></td>"+
    "<td><input name=\"amount[]\" class=\"form-control amount item-calc\" type=\"text\" placeholder=\"<?php echo display('amount') ?>\"  value=\"0.00\"  required></td>"+
    "<td><input name=\"subtotal[]\" class=\"form-control subtotal\" type=\"text\" placeholder=\"<?php echo display('subtotal') ?>\"  value=\"0.00\" required></td>"+
    "</tr>";

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
    var admission_date = $("#admission_date");
    var discharge_date = $("#discharge_date");
    var total_days     = $("#total_days");
    var patient_name   = $("#patient_name");
    var address        = $("#address");
    var date_of_birth  = $("#date_of_birth");
    var male           = $("#male");
    var female         = $("#female"); 
    var doctor_name    = $("#doctor_name"); 
    var insurance_name = $("#insurance_name"); 
    var policy_no      = $("#policy_no"); 
    var picture        = $("#picture"); 
    var package_id     = $("#package_id"); 
    var package_name   = $("#package_name"); 
    var total_days     = $("#total_days"); 
    var advance_data   = $("#advance_data"); 
    var pay_advance    = $("#pay_advance"); 
    var discount       = $("#discount"); 
    // #----------------------------------------------#



    var aid = $("#admission_id");
    aid.on('keyup change',function(){

        patient_id.val('');
        admission_date.val('');
        discharge_date.val('');
        total_days.val('');
        patient_name.val('');
        address.val('');
        male.val('');
        female.val('');
        doctor_name.val('');
        insurance_name.val('');
        policy_no.val('');
        picture.attr('src','');
        package_id.val('');
        package_name.val('');
        total_days.val(''); 
        advance_data.html(''); 
        pay_advance.val(''); 
        discount.val(''); 

        $.ajax({
            url: '<?php echo base_url('billing/bill/getInformation') ?>',
            method: 'post',
            dataType: 'json',
            data: {
                admission_id: $(this).val(),
                '<?= $this->security->get_csrf_token_name() ?>':'<?= $this->security->get_csrf_hash() ?>'
            },
            success: function(data)
            {  

                if (data.status==true)
                {
                    //patient information 
                    patient_id.val(data.result.patient_id);
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

                    // admission information
                    admission_date.val(data.result.admission_date);
                    discharge_date.val(data.result.discharge_date);
                    total_days.val(data.result.total_days);


                    //insurance information
                    insurance_name.val(data.result.insurance_name);
                    policy_no.val(data.result.policy_no);

                    //package information
                    package_id.val(data.result.package_id);
                    package_name.val(data.result.package_name);
                    discount.val(data.result.discount);
                    

                    var services_html = "";
                    var serviceObj = JSON.parse(data.result.services);
                    $.each(serviceObj, function(i,x){ 
                        services_html += "<tr>"+
                        "<td><div class=\"btn btn-group\">"+
                            "<button type=\"button\" class=\"addMore btn btn-sm btn-success\">+</button>"+
                            "<button type=\"button\" class=\"remove btn btn-sm btn-danger\">-</button>"+
                        "</div></td>"+
                        "<td><input name=\"service_name[]\" value='"+x.name+"' class=\"form-control service_name service_data\" type=\"text\" placeholder=\"<?php echo display('service_name') ?>\" required><input name=\"service_id[]\" type=\"hidden\" class=\"service_id\" value='"+x.id+"' required></td>"+
                        "<td><input name=\"quantity[]\" value='"+x.quantity+"' class=\"form-control quantity item-calc\" type=\"text\" placeholder=\"<?php echo display('quantity') ?>\" value=\"1\" required></td>"+
                        "<td><input name=\"amount[]\" value='"+x.amount+"' class=\"form-control amount item-calc\" type=\"text\" placeholder=\"<?php echo display('amount') ?>\"  value=\"0.00\" required></td>"+
                        "<td><input name=\"subtotal[]\" value='"+(x.quantity*x.amount).toFixed(2)+"' class=\"form-control subtotal\" type=\"text\" placeholder=\"<?php echo display('subtotal') ?>\"  value=\"0.00\" required></td>"+
                        "</tr>";
                    });
                    if (serviceObj.length > 0)
                    {
                        $("#services").html(services_html);
                    } 

                    //success state
                    aid.parent().removeClass('has-error').addClass('has-success');
                    aid.next().html('<button type="button" class="btn btn-success"><i class="fa fa-check"></i></button>');


                    //advance_data payment
                    advance_data.html(data.advance_data);
                    pay_advance.val(data.pay_advance.toFixed(2));
 

                    //total   
                    var total = 0;
                    $('.subtotal').each(function(){ 
                        total  += parseFloat($(this).val());
                        $('#total').val(total.toFixed(2));
                    });  
                    var xx = parseFloat($('#pre_service_charge').val())+parseFloat($('#total').val());
                    $('#total').val(xx.toFixed(2));
                    $("#discountPercent").val(parseFloat((data.result.discount/xx) * 100).toFixed(2)); 
                    
                    //$("#discount").val(parseFloat(xx*(parseFloat($("#discountPercent").val())/100).toFixed(2)));
                    $("#taxPercent").val("0.00");


                    $("#payable").val(
                        (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
                    );   
                }
                else
                {
                    aid.parent().addClass('has-error').removeClass('has-success');
                    aid.next().html('<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>');
                }
            },
            error: function(e)
            {
                alert('failed...');
            }
        });
    });


 
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
            var tempdiscount = $("#discountPercent").val();
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
        var disp = $("#discountPercent").val();
        if(disp > 0 ){
            discount = (parseFloat(xx)/100)*parseFloat(disp);
        }
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
        var total = parseFloat($("#total").val());
        var discountPercent = $("#discountPercent").val(); 

        $("#discount").val(parseFloat(((discountPercent)/100)*total).toFixed(2));

        var taxPercent = $("#taxPercent").val(); 
        $("#tax").val(((parseFloat(taxPercent)/100)*parseFloat(total)).toFixed(2));

        $("#payable").val(
            (parseFloat($("#total").val())+parseFloat($("#tax").val())-parseFloat($("#discount").val())-parseFloat($("#pay_advance").val())).toFixed(2)
        );  
    });


});
</script>