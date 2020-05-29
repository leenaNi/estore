@extends('Admin.layouts.default')

@section('content')

<section class="content-header">
    <h1>
      Subscription Program
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       
        <li class="active">Subscription Program  </li>
        <li class="active"> Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">   
                <div class="box-body">
                     @if(!empty(Session::get('message')))
                    <div class="alert {{(Session::get('aletC')== 1)?'alert-success':'alert-danger'}}" role="alert">
                        {{Session::get('message')}}
                    </div>
                      @endif
                  
                    {!! Form::model($settings, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
                    {!! Form::hidden('url_key',null) !!}
                    <div class="clearfix"></div>
                    <input type="hidden" name="type" value="{{ (Input::get('type'))?Input::get('type'):2 }}">
                    @if(!empty($settings->details))
                    <?php
                    $details = json_decode($settings->details);
                    // dd($details);
                    
                    ?>
                    @foreach($details as $detK => $detV)
                    <?php
                            $label = $detK;
                            if($label == 'period') {
                            // dd($details->period);
                            // foreach($details['period'] as $periodKey => $periodVal) {
                            ?>
                        <div class="col-md-6">
                            <h3>Subscription Period</h3>
                        <table class="table table-striped table-hover tableVaglignMiddle">
                            <thead>
                                <tr>
                                <th>Sr No </th>
                                <th>Period Val</th>
                                <th>Period Label</th>
                                <th>Action</th>                            
                                </tr>
                            </thead>
                            <tbody class="periods">
                                @foreach($details->period as $periodKey => $periodVal)
                                    <tr id="{{@$periodKey}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td><input type="hidden" name="period_key[]" value="{{$periodVal->period_key}}">{{$periodVal->period_key}}</td>
                                        <td><input type="hidden" name="period_val[]" value="{{$periodVal->period_val}}">{{$periodVal->period_val}}</td>
                                        <td><a class="removePeriod" data-toggle="tooltip" title="Delete"><i class="fa fa-trash fa-fw"></i></a> </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr><td colspan="4" class="text-right"><a class="btn btn-sm btn-success" id="addnewPeriod"><i class="fa fa-plus"></i> Add</a></td></tr>
                            </tfoot>
                        </table>
                        </div>
                            <?php }  ?>
                    @endforeach
                    @endif
                    <div class="col-md-12">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Update',["class" => "btn btn-primary noLeftMargin"]) !!}
                            {!! Form::close() !!}                       </div>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('myscripts')
<script>
    var periodCnt = 0;
    <?php if($details->period) { ?>
    periodCnt = <?php echo count($details->period); ?>;
    <?php } ?>
    $('a#addnewPeriod').click(function() {
        periodCnt++;
        var periodStrHtml = '<tr id="'+ periodCnt +'"><td>' + periodCnt + '</td><td><input type="number" name="period_key[]" value=""></td><td><input type="text" name="period_val[]" value=""></td><td><a class="removePeriod" title="Delete"><i class="fa fa-trash fa-fw"></i></a> </td></tr>';
        $('table tbody.periods').append(periodStrHtml);
    });
    $('table tbody.periods').delegate('a.removePeriod', 'click', function() {
        var rowId = $(this).parent().parent().attr('id');
        alert("Remove row " + rowId);
        if(confirm('Are you sure you want to delete this Record?')) {
            $('tr#'+rowId).remove();
            periodCnt--;
        }
    });
</script>
@stop

