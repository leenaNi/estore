<div class="tab-container">


    <div class="panel panel-default nobottommargin popregtabscroll">
        <div class="panel-body" style="padding: 40px;">
            <form id="register-form" name="register-form" class="nobottommargin"  method="post" id="register-form" action="{{route('createStore')}}" >
                <div class="col_full">
                    <input type="text"  name="store_name" id="store_name" required="true" value="" class="sm-form-control" placeholder="Store Name *" />
                    <span id="store_name_re_validate"></span>
                </div>
                <!--                <div class="col_full">
                                    <input type="text"  name="url_key" id="url_key" value="" class="sm-form-control" placeholder="URL Key" />
                                </div>-->
                <div class="col_full">
                    <input type="email" name="email" id="email" required="true" value="" class="sm-form-control" placeholder="Email *" />
                    <span id="email_re_validate"></span>
                </div>
                <div class="col_full">
                    <input type="password" name="password" id="password" required="true" value="" class="sm-form-control" placeholder="Password *" />
                    <span id="password_re_validate"></span>
                </div>
                <div class="col_full">
                    <input type="password" name="cpassword" id="cpassword" required="true" value="" class="sm-form-control" placeholder="Confirm Password *" />
                    <span id="cpassword_re_validate"></span>
                </div>
                <div class="col_full">
                    <input type="text" name="first_name" id="password" required="true"class="sm-form-control" placeholder="First Name *" />
                </div>
                <div class="col_full">
                    <input type="text"  name="last_name"  required="true" class="sm-form-control" placeholder="Last Name *" />
                </div>
                <div class="col_full">
                    <input type="text"  name="telephone"  required="true"class="sm-form-control" placeholder="Mobile *" />
                </div>
                <input type="hidden" name="checkFromRegister" value="1">


                <div class="clearfix"></div>

                <div class="clear"></div>
                <div class="col_full nobottommargin">
                    <button class="button button-3d button-black nomargin w100 registerButton" id="register-form-submit" name="register-form-submit"  value="register">CREATE MY STORE<i class="icon-spinner icon-spin regLoader" style="display:none"></i></button>
                </div>
            </form>
        </div>
    </div>


</div>