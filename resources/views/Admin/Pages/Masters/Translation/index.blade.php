@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Translation</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Translation</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row"> 
                                {{ Form::open(['method'=>'get']) }}
                                {{ Form::hidden('search',1) }}
                                <div class="col-md-3">
                                    {{ Form::text('s_language',!empty(Input::get('s_language'))?Input::get('s_language'):null,['class'=>'form-control','placeholder'=>'Search Translation']) }}

                                </div>


                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>

                                </div>
                                {{ Form::close() }}
                            </div>
                        </div> 
                        <div class="col-md-2 text-right"> 

                            {!! Form::button('Add New Translation',['class'=>'btn btn-info add-trans']) !!}

                        </div>
                    </div>



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr style="text-transform: capitalize;">
                                @foreach($columns as $ky => $column)
                                <th <?= $ky == 0 ? 'style="display:none;"' : '' ?> >{{$column}}</th>                            
                                @endforeach
                                <th>Actions</th>        
                            </tr>
                        </thead>
                        <tbody class="listing">
                            @foreach($langs as $key=> $language)
                            <tr> 
                                @foreach($columns as $k=>$column)
                                <td <?= $k == 0 ? 'style="display:none;"' : '' ?>>
                                    <form>
                                        <span class="trans-text" data-name="{{$column}}">{{ $language->$column }}</span>
                                        <span style="display: none;" class="trans-input"><?= $k == 0 ? '<input type="hidden" name="id" value="' . $language->$column . '">' : '<input type="text" name="' . $column . '" value="' . $language->$column . '" class="validate[required]">'; ?></span>
                                    </form>
                                </td>                                   
                                @endforeach                            
                                <td>                              
                                    <button type="button" class="btn btn-success btn-xs edit-trans">Edit</button>
                                    <button style="display: none;" type="button" class="btn btn-primary btn-xs save-trans">Save</button>
                                    <button type="button" class="btn btn-danger btn-xs delete-trans">Delete</button>
                                    <i style="display: none;" class="fa fa-refresh fa-spin fa-fw loading"></i>
                                    <i title="Error! Translation not saved." style="display: none;color:red; margin-left:5px;" class="fa fa-exclamation warning"></i>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pull-right">
                        {{ $langs->links() }}
                    </div>

                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

@stop
@section('myscripts')
<script>
    $('body').on('click', '.edit-trans', function () {
        $(this).closest('tr').find('.trans-text').hide();
        $(this).closest('tr').find('span[data-name="id"]').show();
        $(this).closest('tr').find('.trans-input').show();
        $(this).closest('tr').find('.save-trans').show();
        $(this).hide();
    });
    $('body').on('click', '.delete-trans', function () {
        var confirm = window.confirm("Are you sure to delete Translation?");
        if (confirm == true) {
            var $this = $(this).closest('tr');
            $this.find('.loading').show();
            var id = $this.find('input[name="id"]').val();
            var formdata = new FormData();
            formdata.append('id', id);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.masters.translation.delete') }}",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status == 'success') {
                        $this.fadeOut();
                    }
                    $this.find('.loading').hide();
                },
                error: function (err) {
                    $this.find('.loading').hide();
                }

            });
        }
    });
    $('body').on('click', '.remove-trans', function () {
        $(this).closest('tr').remove();
    });
    $('body').on('click', '.save-trans', function () {
        saveTranslation($(this));
    });
    function saveTranslation($button) {
        var $this = $button.closest('tr');
        if ($this.find('form').validationEngine('validate')) {
            $this.find('.loading').show();
            var formdata = new FormData();
            $this.find('input').each(function (index) {
                if (!$(this).prop('disabled') == true)
                    formdata.append($(this).attr('name'), $(this).val());
            });
            $.ajax({
                type: "POST",
                url: "{{ route('admin.masters.translation.saveUpdate') }}",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status == 'success') {
                        $this.find('.trans-input').hide();
                        $this.find('input').each(function (index) {
                            $this.find('span[data-name="' + $(this).attr('name') + '"]').html($(this).val());
                            $this.find('span[data-name="id"]').html(data.id);
                            $this.find('input[name="id"]').val(data.id);
                            $this.find('input[name="id"]').prop('disabled', false);
                            $button.hide();
                            $this.find('.edit-trans').show();
                            $this.find('.delete-trans').show();
                            $this.find('.remove-trans').hide();
                            $this.find('.trans-text').show();
                        });
                    } else {
                        $this.find('.warning').show();
                    }
                    $this.find('.loading').hide();
                },
                error: function (err) {
                    $this.find('.loading').hide();
                    $this.find('.warning').show();
                }

            });
        }
    }

    $('.add-trans').click(function () {
        var row = '<tr class="new-row">';
<?php
foreach ($columns as $key => $column):
    if ($key == 0):
        ?>
                row += '<td style="display:none;"><form><span style="display:none;" class="trans-text" data-name="{{$column}}"></span><span class="trans-input"><input type="hidden" disabled name="id" value=""></span></form></td>';
    <?php else: ?>
                row += '<td><form><span style="display:none;" class="trans-text" data-name="{{$column}}"></span><span class="trans-input"><input type="text" name="<?= $column ?>" placeholder="<?= $column ?>" class="validate[required]" /></span></form></td>';
    <?php
    endif;
endforeach
?>
        row += '<td><button style="display:none;" type="button" class="btn btn-success btn-xs edit-trans">Edit</button><button type="button" class="btn btn-primary btn-xs save-trans">Save</button><button class="btn btn-danger btn-xs remove-trans">Remove</button><button style="display:none;" type="button" class="btn btn-danger btn-xs delete-trans">Delete</button><i style="display: none;" class="fa fa-refresh fa-spin fa-fw loading"></i><i title="Error! Translation not saved." style="display: none;color:red; margin-left:5px;" class="fa fa-exclamation warning"></i></td>';
        row += '</tr>';
        $('.listing').append(row);
    });

</script>
@stop