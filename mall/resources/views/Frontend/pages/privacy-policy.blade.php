@extends('Frontend.layouts.default')
@section('content')
<section id="page-title">
      <div class="container clearfix">
        <h1>Privacy Policy</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">Privacy Policy</li>
        </ol>
      </div>
    </section>
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col_full nobottommargin contentHolder">
            <?php echo html_entity_decode($terms->description) ?>
            </div>
        </div>
      </div>
    </section>
@stop
