<html lang="en-US" >

    <body >
       
        @if($notificationStatus=='1')
        <table ng-controller="myctrl" >
            <tr>
                <td colspan="2" style="text-align: center"><h3>Welcome to our website</h2>
                        <tr><td>Enter your email address. :&nbsp;&nbsp;
                            <td><input type="email" name="email" id="email" placeholder="enter Email" ng-model="getemail"  />
                            <!--<td><input type="email" name="email" id="email" placeholder="enter Email" ng-blur="checkemail()"/>-->
                        <tr>
                            <td colspan="2"><input type="button" name="notify" id="notify" value="Notify"  ng-click ="doentry()"/>
                            </td>
                        </tr>
                        <tr>
                            @if($socialmedialinks->count())
                            <td>Social Media Links</td>
                                @foreach($socialmedialinks as $link)
                                <td><a href="{{ $link->link }}" target="_blank" title="{{ $link->media }}"><img src="{{ asset('public/Admin/uploads/socialmedia/').'/'.$link->image }}" style="width: 50px;height: 50px;"></a></td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            @if($contacts->count())
                            <td>Contacts</td>
                                <tr>
                                    <td colspan="1">Contact No</td>
                                    <td colspan="1">Email ID</td>
                                    <td colspan="1">Address</td>
                                </tr>
                                @foreach($contacts as $contact)
                                <tr>
                                    <td colspan="1">{{ $contact->phone_no }}</td>
                                    <td colspan="1"><a href="mailto:{{$contact->email}}">{{$contact->email}}</a></td>
                                    <td colspan="1">{{ $contact->address }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            @if($staticpages->count())
                                @foreach($staticpages as $page)
                                    <td colspan="1"><a href="{{ route('staticpage',['id'=>$page->id]) }}">{{ $page->page_name }}</a></td>   
                                @endforeach
                            @endif
                        </tr>
                                </table>
                                @endif
                                </body>
                                </html>      
                                <script type="text/javascript">
                                    /*function doentry()
                                     {
                                     var emailvalue = $("#email").val();
                                     $.ajax({
                                     url:'{{route("notification")}}',
                                     type:'get',
                                     data:{emailvalue:emailvalue},
                                     dataType:'json',
                                     success: function(data){
                                     alert("Check your mail");
                                     }
                                     
                                     });
                                     }*/

                                    /*function checkemail()
                                     {
                                     var email = $("#email").val();
                                     $.ajax({
                                     url:'{{route("checkemail")}}',
                                     type:'get',
                                     data:{email:email},
                                     dataType:'json',
                                     success: function(data){
                                     if(data >= "1")
                                     {
                                     alert("Already Registered on website");
                                     }
                                     }
                                     
                                     });
                                     }*/
                                </script>