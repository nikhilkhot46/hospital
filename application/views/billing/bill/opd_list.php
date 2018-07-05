<div class="row">
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-body">
                <table id="billList" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr> 
                            <th><?php echo display('serial') ?></th>
                            <th><?php echo display('patient_name') ?></th>
                            <th><?php echo display('patient_id') ?></th>
                            <th><?php echo display('date') ?></th>
                            <th><?php echo display('visiting_fees') ?></th>
                            <th><?php echo display('doctor_name') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($opd_list)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($opd_list as $bill) { ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $bill->patient_name; ?></td>
                                    <td><?php echo $bill->patient_id; ?></td>
                                    <td><?php echo $bill->date; ?></td>
                                    <td><?php echo $bill->visiting_fees ?></td>
                                    <td><?php echo $bill->doctor_name ?></td>
                                    <td class="center">
                                        <?php if($bill->status) btn_add("billing/bill/add_opd_bill/$bill->patient_id/$bill->appointment_id",display('add_opd_bill')) ?>
                                        <?php btn_view("prescription/prescription/view/$bill->id") ?>
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

<script type="text/javascript">
$(document).ready(function() {

    $('#billList').DataTable( {
        responsive: true, 
        paging:false,
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>tp", 
        buttons: [  
            {extend: 'copy', className: 'btn-sm'}, 
            {extend: 'csv', title: 'ExampleFile', className: 'btn-sm'}, 
            {extend: 'excel', title: 'ExampleFile', className: 'btn-sm', title: 'exportTitle'}, 
            {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'}, 
            {extend: 'print', className: 'btn-sm'} 
        ]
    });
});
</script>
