@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Salary</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content " id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

       

        <div class="panel-body hidden-print">
                                      @if(!empty($edit))
                                               <form name="form"  action="{{url('payroll/manage_salary')}}" method="post" class="form-horizontal">
                                                    @else
                                                {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}                                             
                                                @endif
          
    @csrf
            <div class="row">
 <div class="col-sm-12 ">
                                       
               <div class="form-group row">
                    <label class=""> Department   <span class="required"> *</span></label>  
               <div class="col-lg-10">                               
                   <select name="departments_id" class="form-control m-b select_box col-md-4" required>
                                        <option value="">Select Departments</option>
                                        <?php if (!empty($all_department_info)): foreach ($all_department_info as $v_department_info) :
                                                        if (!empty($v_department_info->name)) {
                                                            $deptname = $v_department_info->name;
                                                        }
                                                        ?>
                                        <option value="<?php echo $v_department_info->id; ?>" <?php
                                                            if (!empty($departments_id)) {
                                                                echo $v_department_info->id == $departments_id ? 'selected' : '';
                                                            }
                                                            ?>><?php echo $deptname ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                </div>
  
                                                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success" value="1" name="flag">Go</button>
                           @if(!empty($edit))
                                                  <a href="{{url('payroll/manage_salary')}}"class="btn btn-danger">Reset</a>
                                                    @else
                                                  <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>                                      
                                                @endif
                     

                </div>                  
                </div>
           </div>
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
@if(!empty($employee_info))
<?php $id=1; 
$a=0;

?>
        <div class="panel panel-white">
            <div class="panel-body ">
                      <form id="form_validation" role="form" enctype="multipart/form-data"
                            action="{{url('payroll/save_salary_details')}}" method="post"
                            class="form-horizontal form-groups-bordered">
                            @csrf
                            
                             <table class="table datatable-basic table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                            <th>Designation</th>
                                        <th>Monthly</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($employee_info as $v_employee)  
                               <?php
                                $a++;
                                $salary_info=App\Models\Payroll\EmployeePayroll::where('user_id',$v_employee->id)->get();
                                    ?>
                            <tr>
                                        <td><input type="hidden" name="user_id[]"  value="<?php echo $v_employee->id ?>"><?php echo $v_employee->name; ?></td>
                                         <td>
                                                   @if(!empty($v_employee->designation_id))
                                                  <?php echo $v_employee->designation->name ?>
                                                     @else
                                                        -
                                                          @endif
                                                      </td>        
                                             <td style="width: 35%">

                                             <div class="form-inline">
                                          <div class = "input-group"> 
                                               <input name="monthly_status[]"    id="<?php echo $v_employee->id ?>"  type="checkbox"  value="<?php echo $v_employee->id ?>"   class="child_absent"
                                                        
                                                    @foreach ($salary_info as $v_gsalary_info) 
                                                            @if ($v_employee->id == $v_gsalary_info->user_id) 
                                                              {{ $v_gsalary_info->salary_template_id ? 'checked ' : '' }}
                                                            @endif
                                                        @endforeach
                                                          >                              
                                             </div>&nbsp
 
                                                <div class = "input-group"> 
                                                 <select name="salary_template_id[]" class="form-control m-b template" id="template_id_{{$a}}"  data-sub_category_id="{{$a}}">
                                                           <option value="">Select Monthly Grade</option>
                                                      <?php if (!empty($salary_grade)) : foreach ($salary_grade as $v_salary_info) : ?>
                                                        <option value="<?php echo $v_salary_info->salary_template_id ?>" <?php

                                                         foreach ($salary_info as $v_gsalary_info) {
                                                            if (!empty($v_gsalary_info)) {
                                                                if ($v_employee->id == $v_gsalary_info->user_id) {
                                                                    echo $v_salary_info->salary_template_id == $v_gsalary_info->salary_template_id ? 'selected ' : '';
                                                                }
                                                            }
                                                        }
                                                   
                                                    ?>>
                                                            <?php echo $v_salary_info->salary_grade ?></option>;
                                                        <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select> 
                                        <div class="input-group-append">
                                                  <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model({{ $a }},'addtemplate')" value="{{ $a}}" data-target="#appFormModal"><i class="icon-plus-circle2"></i></button>
                                                  </div>
                                          </div>&nbsp
                      
                    </div>
                                           
                                     

                                 <!-- Hidden value when update  Start-->
                            <input type="hidden" name="departments_id" value="<?php echo $departments_id ?>" />
                            <?php
                                 if (!empty($salary_info)) {
                    foreach ($salary_info as $v_gsalary_info) {
                     
                            ?>
                            <input type="hidden" name="payroll_id[]"
                                value="<?php echo $v_gsalary_info->id ?>" />
                            <?php
                                                                  }
                                         }
                   
                                
                                 ?>
                          </td>
                              </tr>
                                
                            
                             
                         @endforeach
                           </tbody>
                             <tfoot>
                            <?php if (!empty($employee_info[0])) { ?>
                            <tr><td colspan="2"></td>
                             <td colspan="">
                                <button id="salery_btn" type="submit" class="btn btn-primary btn-block">Update</button>
                            </td>
                             </tr>
                            <?php } ?>
                                </tfoot>
                         </table>
                        </form>
            </div>
            <!-- /.panel-body -->
             </div>
    @endif              

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>


@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>

<script type="text/javascript">
    $(document).ready(function () {
        $(':checkbox').on('change', function () {
            var th = $(this), id = th.prop('id');
            if (th.is(':checked')) {
                $(':checkbox[id="' + id + '"]').not($(this)).prop('checked', false);
            }
        });
    });
</script>

<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("salary_template.show", ":id") }}';
        url = url.replace(':id', id)
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }


  function saveTemplate(e){
   var form = $('#addClientForm').serialize();
       var sub_category_id =  $('#category').val();;
          $.ajax({
            type: 'GET',
            url: '{{url("payroll/addTemplate")}}',
         data:  $('#addClientForm').serialize(),
              
          
                dataType: "json",
             success: function(response) {
                console.log(response);
  console.log(sub_category_id);
                               var id = response.salary_template_id;
                             var name = response.salary_grade;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#template_id_'+sub_category_id).append(option);
                              $('#appFormModal').hide();
                            $('.modal-backdrop').remove();
                                
               
            }
        });
}

    </script>

<script type="text/javascript">
$(document).ready(function() {
    var maxAppend = 0;
    $("#add_more").click(function() {
        var add_new = $(
            '<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="allowance_label[]" style="margin:5px 0px;height: 28px;width: 56%;" class="form-control"  placeholder="Enter Allowance label" required ></div>\n\
<div class="col-sm-9"><input  type="text" data-parsley-type="number" name="allowance_value[]" placeholder="Enter Allowance Value" required  value="<?php
                if (!empty($emp_salary->allowance_value)) {
                    echo $emp_salary->allowance_value;
                }
                ?>"  class="salary form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div></div>'
        );
        maxAppend++;
        $("#add_new").append(add_new);
    });

    $("#add_new").on('click', '.remCF', function() {
        $(this).parent().parent().parent().remove();
    });
});
</script>
<script type="text/javascript">
 $(document).ready(function () {
        var maxAppend = 0;
        $("#add_more_deduc").click(function () {
            var add_new = $('<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="deduction_label[]" style="margin:5px 0px;height: 28px;width: 56%;" class="form-control" placeholder="Enter Deductions Label" required></div>\n\
<div class="col-sm-9"><input  type="text" data-parsley-type="number" name="deduction_value[]" placeholder="Enter Deductions Value" required  value=""  class="deduction form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF_deduc"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div></div>');
            maxAppend++;
            $("#add_new_deduc").append(add_new);

        });

        $("#add_new_deduc").on('click', '.remCF_deduc', function () {
            $(this).parent().parent().parent().remove();
        });
    });
</script>
<script type="text/javascript">
 $(document).on("change", function () {
        var sum = 0;
        var basic_salary= 0;
        var deduc = 0;

        $(".salary").each(function () {
            sum += +$(this).val();
         console.log(sum);
        });
         $(".basic_salary").each(function () {
            basic_salary += +$(this).val();
        });
        
        var provident_fund = ((basic_salary * 10 / 100 )).toFixed(2);
        $(".NSSF").val(provident_fund);
        
              
        

      var sub_total=sum- provident_fund ;


        var total_tax = tax_deduction_rule(sub_total);

        $(".PAYE").val(total_tax);

    

        $(".deduction").each(function () {
            deduc += +$(this).val();
        });
        
        var ctc = $("#ctc").val();
        $("#total").val(sum.toFixed(2));

        $("#deduc").val(deduc.toFixed(2));
        var net_salary = 0;
        net_salary = (sum - deduc).toFixed(2);
        $("#net_salary").val(net_salary);
    });

    function tax_deduction_rule(tax) {
        if (tax < 270000) {
            return "0";
        }
        else if (tax >= 270000 && tax < 520000) {
            return (0.08 * (tax - 270000)).toFixed(2);
        }
        else if (tax >= 520000 && tax < 760000) {
            var tr = (tax - 520000);
            var ttotal = ( tr * 20 / 100 );
            return ((20000 + ttotal)).toFixed(2);
        }
        else if (tax >= 760000 && tax < 1000000) {
            var tr = (tax - 760000);
            var ttotal = ( tr * 25 / 100 );
            return ((68000 + ttotal)).toFixed(2);
        } else if (tax >= 1000000) {
            var tr = (tax - 1000000);
            var ttotal = ( tr * 30 / 100 );
            return ((128000 + ttotal)).toFixed(2);
        }
    }


</script>

<script>
$(document).ready(function() {

  

    $(document).on('change', '.amount', function() {
        var id = $(this).val();
        var user=$('#user_id').val();
        $.ajax({
            url: '{{url("payroll/findLoan")}}',
            type: "GET",
            data: {
                id: id,
                  user: user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });



$(document).on('change', '.monthyear', function() {
        var id = $(this).val();
    var user=$('#user_id').val();
        $.ajax({
            url: '{{url("payroll/findMonth")}}',
            type: "GET",
            data: {
                id: id,
                  user: user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#month_errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#month_errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });
  });


});
</script>
@endsection