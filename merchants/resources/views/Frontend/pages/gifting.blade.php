<!DOCTYPE html>
<html>
<head>
        @include('Frontend.includes.head')
        @yield('mystyles')
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.js">
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    </head>
    <body ng-app="giftapp">
<center>
<div ng-controller="giftController">
    <form name="adduser" novalidate>
        <table border="2">
            <tr>
                <td>Sender Name:&nbsp;&nbsp;</td>
                <td><input type="text" id="sndrname" ng-required="true" name="sndrname" ng-model="user.sndrname" placeholder="Enter Name"/>
            </tr> 
            
            <tr>
                <td>Sender Email:&nbsp;&nbsp;</td>
                <td><input type="email" id="sndremail" ng-required="true" name="sndremail" ng-model="user.sndremail" placeholder="Enter email"/>
            </tr>
            
            <tr>
                <td>Sender Mobile No:&nbsp;&nbsp;</td>
                <td><input type="number" id="sndrmobile" ng-required="true" ng-pattern="/^[789]\d{9}$/"  name="sndrmobile" ng-model="user.sndrmobile" placeholder="Enter number"/>
                <td><span  ng-show="adduser.sndrmobile.$error.pattern">Not valid number!</span></td>
            </tr>
            
            <tr>
                <td>Amount:&nbsp;&nbsp;</td>
                <td><input type="number" id="gift" ng-required="true" ng-minlength="3" ng-maxlength="5" name="gift" ng-model="user.gift" placeholder="Enter Amount"/>
                    <td><span  ng-show="adduser.gift.$error.minlength">Invalid amount!</span></td>
            </tr>
            
            <tr>
                <td>Receiver Name:&nbsp;&nbsp;</td>
                <td><input type="text" id="receivrname" ng-required="true" name="receivrname"  ng-model="user.receivrname" placeholder="Enter name"/>
            </tr>
            
            <tr>
                <td>Receiver Email:&nbsp;&nbsp;</td>
                <td><input type="email" id="receivremail" ng-required="true" name="receivremail" ng-model="user.receivremail" placeholder="Enter email"/>
            </tr>
            
            <tr>
                <td>Receiver Mobile No:&nbsp;&nbsp;</td>
                <td><input type="number" id="receivrmobile" ng-required="true"  ng-pattern="/^[789]\d{9}$/" name="receivrmobile" ng-model="user.receivrmobile" placeholder="Enter number"/>
                <td><span  ng-show="adduser.receivrmobile.$error.pattern">Not valid number!</span></td>
            </tr>
            
            <tr>
                <td>Receiver Address:&nbsp;&nbsp;</td>
                <td><input type="text" id="receivradrs" ng-required="true" name="receivradrs" ng-model="user.receivradrs" placeholder="Enter address"/>
            </tr>
            
            <tr>
                <td colspan="2"><input type="submit" ng-click="AddUser(user)" ng-disabled="adduser.$invalid" id="submit" name="submit" value="Submit"/></td>
            </tr>
        </table>
         </form>
 </div>  
</center> 
</body>
</html>      
 
<script>
    var app = angular.module('giftapp',[]);
    app.config(['$interpolateProvider', function ($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }]);
    app.controller('giftController', function ($scope,$window) {
         $scope.user = {};
        var reset=angular.copy($scope.user);
        $scope.AddUser = function(usr)
            {
          if($scope.adduser.$valid===true) 
               {
            
            var res=confirm('All inputs are valid '+'\n\n\n'+'Do you confirm?');
            if(res===true)
                {
            var subject="Gift purchased";
             
            var message1="You have gifted <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> "+ $scope.user.gift +" amount through coupon code ";
            var message2=" to "+ $scope.user.receivrname +" whose mobile number is "+$scope.user.receivrmobile+".Using this coupon code you can shop anything that is available in our website within one month i.e till date ";
            var message3="Caution:This code is not reusable.";
            $.ajax({
              url:"giftemail",
              type:'get',
              data:{user:usr,subject:subject,message1:message1,message2:message2,message3:message3},
              dataType:'json',
              success: function(data){
                        if(data===1)
                            {
                             $window.alert('Check your mail');
                            }
                                    }
                    }); 
                    $scope.user="";
                }
              }
            }
        
    });
</script>
