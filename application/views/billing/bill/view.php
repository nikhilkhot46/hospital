<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">

            <div class="panel-heading no-print row">
                <div class="btn-group col-xs-4"> 
                    <a class="btn btn-primary" href="<?php echo base_url("billing/bill") ?>"> <i class="fa fa-list"></i>  <?php echo display('bill_list') ?> </a>  
                    <a class="btn btn-success" href="<?php echo base_url("billing/bill/form") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_bill') ?> </a>  
                    <button onclick="printContent('printMe')" type="button" class="btn btn-danger"><i class="fa fa-print"></i> <?php echo display("print") ?></button>
                </div>
                <h2 class="col-xs-8 text-left text-success"><?php echo display('bill_details') ?></h2>
            </div>  

            <div class="panel-body" id="printMe">
                <div class="row">
                    <div class="col-xs-6 logo_bar">
                        <img src="<?php echo base_url("$website->logo") ?>" class="img-responsive" alt=""></br>
                        <?php echo display('phone') ?>: <?php echo $website->phone; ?></br>
                        <?php echo display('email') ?>: <?php echo $website->email; ?>
                        <br>
                    </div>
                    <div class="col-xs-6 address_bar">
                        <div class="address_inner">
                            <address>
                                <strong><?php echo display('address') ?></strong><br>
                                <strong><?php echo $website->title; ?></strong><br>
                                <?php echo $website->description; ?>
                            </address>
                        </div>
                    </div>
                </div> <hr>
                <!-- Patient Info -->
                <div class="row patient_info">
                    <table class="info">
                        <tbody>
                            <tr>
                                <td><?php echo display('admission_id'); ?>:</td>
                                <td><?php echo $bill->admission_id; ?></td>
                                <td><?php echo display('bill_date'); ?>:</td>
                                <td><?php echo $bill->bill_date; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('patient_id'); ?>:</td>
                                <td><?php echo $bill->patient_id; ?></td>
                                <td><?php echo display('date_of_birth'); ?>:</td>
                                <td><?php echo $bill->date_of_birth; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('patient_name'); ?>:</td>
                                <td><?php echo $bill->patient_name; ?></td>
                                <td><?php echo display('sex'); ?>:</td>
                                <td><?php echo $bill->sex ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('address'); ?>:</td>
                                <td><?php echo $bill->address; ?></td>
                                <td><?php echo display('doctor_name'); ?>:</td>
                                <td><?php echo $bill->doctor_name; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Patient Package -->
                <div class="patient_package">
                    <table class="package">
                        <tbody>
                            <tr>
                                <td><?php echo display('admission_date'); ?>:</td>
                                <td><?php echo $bill->admission_date; ?></td>
                                <td><?php echo display('package_name'); ?>:</td>
                                <td><?php echo $bill->package_name; ?></td>
                                <td><?php echo display('total_days'); ?>:</td>
                                <td><?php echo $bill->total_days; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('discharge_date'); ?>:</td>
                                <td><?php echo $bill->discharge_date; ?></td>
                                <td><?php echo display('insurance_name'); ?>:</td>
                                <td><?php echo $bill->insurance_name; ?></td>
                                <td><?php echo display('policy_no'); ?>:</td>
                                <td><?php echo $bill->policy_no; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                $CI =& get_instance();
                
                $CI->load->helper('array');
                $CI->load->model('blood_bank/blood_model');
                $bloodDetails = $CI->blood_model->get_blood_sell($bill->admission_id,true);
                
                $bdcharge=0;
                $result = '<table  class="charge">
                            <thead>
                            <tr>
                                <th>'.display("blood_group").'</th>
                                <th>'.display("quantity").'</th>
                                <th>'. display("rate").'</th>
                                <th>'. display("discount").'</th>
                                <th>'. display("tax").'</th>
                                <th style="width: 151px;">'.display("subtotal").'</th>
                            </tr>
                            </thead>
                        <tbody>';
                foreach ($bloodDetails as $bd) {
                    $result .= "<tr>";
                    $result .= "<td>".element($bd->blood_type,$this->config->item('blood_group'))."</td>";
                    $result .= "<td>$bd->qty</td>";
                    $result .= "<td>$bd->charge</td>";
                    $result .= "<td>".number_format((float)$bd->discount, 2, '.', '')."</td>";
                    $result .= "<td>".number_format((float)$bd->tax, 2, '.', '')."</td>";
                    $result .= "<td>".number_format((float)$bd->total, 2, '.', '')."</td>";
                    $result .= "</tr>";
                    $bdcharge = $bdcharge + number_format((float)$bd->charge, 2, '.', '');
                } 
                $result.="<tr><td colspan='5'></td><td><b>".number_format((float)$bdcharge, 2, '.', '')."</b></td></tr></tbody></table>";
                
                $CI->load->model('bed_manager/bed_assign_model');
                $CI->load->model('billing/admission_model');
                $patient_details = $CI->admission_model->read_by_id($bill->admission_id);
                $pid = $patient_details->patient_id;
                $bedDetails = $CI->bed_assign_model->get_assigned_bed($pid,true);
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
                $lab_details = $CI->lab_model->read_by_aid($bill->admission_id,true);
                $labcharge=0;
                $result2 = '<table class="charge">
                            <thead>
                                    <tr>
                                        <th>'.display("test").'</th>
                                        <th>'.display("quantity").'</th>
                                        <th>'. display("charge").'</th>
                                        <th>'. display("discount").'</th>
								        <th>'. display("tax").'</th>
                                        <th style="width: 151px;">'.display("subtotal").'</th>
                                    </tr>
                            </thead>
                        <tbody>';		
                foreach ($lab_details as $lab) {
                    $name = $lab->test_name?$lab->test_name:$lab->package_name;
                    $result2 .= "<tr>";
                    $result2 .="<td>".$name."</td>";
                    $result2 .="<td>1</td>";
                    $result2 .="<td>".$lab->test_price."</td>";
                    $result2 .="<td>".$lab->discount."</td>";
                    $result2 .="<td>".$lab->tax."</td>";
                    $result2 .="<td>".$lab->total_price."</td>";
                    $result2 .= "</tr>";
                    $labcharge = $labcharge + $lab->total_price;
                }
                $result2.="<tr><td colspan='5'></td><td><b>".number_format((float)$labcharge, 2, '.', '')."</b></td></tr></tbody></table>";
                
                $CI->load->model('invoices');
                $invoice_details = $CI->invoices->invoice_by_aid($bill->admission_id,true);
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
                    $result3 .="<td>".($value->paid_amount-$value->old_due)."</td>";
                    $result3 .="<td>".$value->old_due."</td>";
                    $result3 .= "</tr>";
                    $invcharge = $invcharge +$value->old_due;
                }
                $result3.="<tr><td colspan='7'></td><td><b>".number_format((float)$invcharge, 2, '.', '')."</b></td></tr></tbody></table>";
                
                $CI->load->model('patient_model');
                $patient_services = $CI->patient_model->patient_service($bill->admission_id,true);
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

                <!-- Patient Charge -->
                <div class="patient_charge">
                <?php echo $result;?><br>
                <?php echo $result1;?><br>
                <?php echo $result2;?><br>
                <?php echo $result3;?><br>
                <?php echo $result4;?><br>
                    <table class="charge">
                        <thead>
                            <tr>
                                <th><?php echo display('serial'); ?></th>
                                <th><?php echo display('service_name'); ?></th>
                                <th><?php echo display('quantity'); ?></th>
                                <th><?php echo display('rate'); ?></th>
                                <th><?php echo display('subtotal'); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $subtotal = "0.00"; 
                        $sl = 1; 
                        foreach($services as $service)
                        {  
                            $subtotal+=($service->quantity*$service->amount);
                        ?>
                        <tr>
                            <td class="description">
                                <p><?php echo $sl++; ?></p> 
                            </td>
                            <td class="description">
                                <p><?php echo $service->name; ?></p> 
                            </td>
                            <td class="charge">
                                <p><?php echo $service->quantity; ?></p> 
                            </td>
                            <td class="discount">
                                <p><?php echo $service->amount; ?></p> 
                            </td>
                            <td class="ballance">
                                <p><?php echo ($service->quantity*$service->amount); ?></p> 
                            </td>
                        </tr>
                        <?php
                        } 
                        ?> 
                        </tbody> 
                    </table>
                </div>
                
                <div class="row">
                    <div class="col-xs-4">
                        <div class="advance_payment"> 
                            <table class="payment">
                                <thead>
                                    <tr>
                                        <th colspan="3"><h4><?php echo display('advance_payment'); ?></h4></th> 
                                    </tr>
                                    <tr>
                                        <th><?php echo display('date'); ?></th>
                                        <th><?php echo display('receipt_no'); ?></th>
                                        <th><?php echo display('amount'); ?></th>
                                    </tr> 
                                </thead>
                                <tbody>
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
                    <div class="col-xs-4">
                        <table class="payment">
                            <thead>
                                <tr>
                                    <th><?php echo display('payment_method'); ?></th>
                                    <th><?php echo $bill->payment_method ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo display('card_cheque_no'); ?></td>
                                    <td><?php echo $bill->card_cheque_no ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo display('receipt_no'); ?></td>
                                    <td><?php echo $bill->receipt_no ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-4">
                        <table class="payment">
                            <thead>
                                <tr>
                                    <td><?php echo display('total'); ?></td>
                                    <?php $subtotal = $subtotal + $total_charge;?>
                                    <th><?php echo  @sprintf("%.2f", (isset($subtotal)?$subtotal:"0.00")) ?></th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr> 
                                    <td><?php echo display('discount'); ?> (<?php echo  @sprintf("%.2f", (($bill->discount/$subtotal)*100)) ?>%)</td>
                                    <td><?php echo  @sprintf("%.2f", $bill->discount) ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo display('tax'); ?> (<?php echo  @sprintf("%.2f", (($bill->tax/$subtotal)*100)) ?>%)</td>
                                    <td><?php echo  @sprintf("%.2f", $bill->tax) ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo display('pay_advance'); ?></td>
                                    <td><?php echo  @sprintf("%.2f", (isset($pay_advance)?$pay_advance:"0.00")) ?></td>
                                </tr> 
                            </tbody>
                            <thead>
                                <tr>
                                    <td><?php echo display('payable'); ?></td>
                                    <th><?php echo  @sprintf("%.2f", ($subtotal-$bill->discount+$bill->tax-$pay_advance),2) ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="my_sign">
                    <span>___________________________</span>
                    <p><?php echo display('signature'); ?></p>
                </div>
            </div> 
        </div>
    </div>
</div>
