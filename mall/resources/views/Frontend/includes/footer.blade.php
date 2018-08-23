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
                            
                        </tr>
                        <tr>
                            
                        </tr>
                        <tr>
                            
                        </tr>
        </table>
        @endif
    </body>
</html>      
