<?php
if(!defined('__PRAGYAN_CMS'))
{ 
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo "<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>";
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}

/**
 * @package pragyan
 * @copyright (c) 2012 Pragyan Team
 * @author shriram<vshriram93@gmail.com>
 * @author Abhishek Kaushik
 * @license http://www.gnu.org/licenses/ GNU Public License
 * For more details, see README
 */

function displayRegistrationForm() {
  $registerForm =<<<FORM
    <form action="./+view" method="post">
      <h1 align='center' style='color:brown'><u>Registration Form</u></h2>
      <center>
        <label for='name' style='font-size:20px;font-weight:bold'>Name:</label>
        <input type="Name" name="name_registrant" required autofocus placeholder="Enter Your Name"/ style='width:200px;height:24px;font-size:20px'/>
        <br/>
        <label for='Amount Plan' style='font-size:20px;font-weight:bold'> Amount:</label>
        <input type='radio'  name='amount_plan' value='700' onclick="document.getElementById('display_sizeTshirt').style.display='block'">700 (Food coupon + Pragyan T.Shirt) <br/>
       <input type='radio' name='amount_plan' value='500' onclick="document.getElementById('display_sizeTshirt').style.display='none' ">500 (only Food Coupon)
</br>
       <div id='display_sizeTshirt' style='display:none;'> <label for='size' style='font-weight:bold;font-size:20px'>T-shirt Size: </label>
         <input type='radio' name='size_tshirt' value='L' >Large
         <input type='radio' name='size_tshirt' value='S'>Small
         <input type='radio' name='size_tshirt' value='M'>Medium
         <input type='radio' name='size_tshirt' value='XL'>XL
         <input type='radio' name='size_tshirt' value='XXL'>XXL
      </div> <br/>
      <input type='submit' name='submit_reg_form' style='font-size:20px;z-index:2' Value='Register'>
    </center>
  </form>
FORM;
  return $registerForm;
}


function handleDistribution() {
  $distributionFlowHandle=<<<TABLE
    <div style="border:1px solid black; width:30%;">
       <form method="post" action="./+octeam&subaction=choose">
          <input type="checkbox" name="changeUserDetail[]" value="S"/> Small<br/>
          <input type="checkbox" name="changeUserDetail[]" value="M"/> Medium <br/>
          <input type="checkbox" name="changeUserDetail[]" value="L"/> Large<br/>
          <input type="checkbox" name="changeUserDetail[]" value="XL"/> XL<br/>
          <input type="checkbox" name="changeUserDetail[]" value="XXL"/> XXL<br/>
          <input type="checkbox" name="changeUserDetail[]" value="food_coupon"/> Food Coupon<br/>
          <input type="checkbox" name="changeUserDetail[]" value="extra"/> Extra<br/>
          Password: <input type="password" name="passwordChangeOption" /><br/>
          <input type="submit" value="change" style="font-size:15px;"/>
      </form>
     </div>
     <hr/>
     <h1>Enter User Detail</h1>
     <table id="tableDistribution" border="1">
       <thead>
         <td>INPUT</td>
         <td>STATUS</td>
       </thead>
     </table>
TABLE;
  $distributionFlowHandle.=<<<SCRIPTS
    <script type="text/javascript">
      var formIndex = 0,typed_into=false,chars=[];
    var pressed = false;
    function createBarCode(id){
    $("#"+id).keypress(function (e) {
    var changes = this;
    chars.push(String.fromCharCode(e.which));
        if (pressed == false) {
            setTimeout(function () {
                if (chars.length == 9) {
                  fIndex = $(changes).attr('id');
                  fIndex=fIndex.substr(17)
                  ajaxSendDetails(fIndex);
                }
                pressed = false;
                chars=[];
            }, 500);
        }
              pressed=true;
    });
}







      function ajaxSendDetails(fIndex) {
            var userDetail = $("#submitUserDetail_"+fIndex).val();
              $("#statusOC_"+fIndex).html('Processing...');
              $.ajax({
                type:"POST",
                url :"./+octeam",
                data:{
                  roll    : userDetail
                }
              }).done(function(msg){
                  $("#statusOC_"+fIndex).html(msg);
                  pressed=false;

              });
              formIndex=formIndex+1;
              appendRowForNewUser();  
              $("#submitUserDetail_"+formIndex).focus();
          
      }
      function sendDetails(e,fIndex){
            if(e.keyCode == 13) {
              ajaxSendDetails(fIndex);
            }            

         }
         function appendRowForNewUser() {
         var tableField="<tr class='submitInformation'>";
	 tableField+="<td><input class='submitUserDetail' style='height:25px;font-size:15px;' placeholder='Scan User Detail' onkeypress='return sendDetails(event,formIndex)' type='text' id='submitUserDetail_"+formIndex+"' /></td>";
             tableField+="<td id='statusOC_"+formIndex+"'>....</td>";
             tableField+="</tr>";
         $('#tableDistribution').append(tableField); 
         createBarCode('submitUserDetail_'+formIndex);
      }
      appendRowForNewUser();              
    </script>

SCRIPTS;
return $distributionFlowHandle;
}

function final_submit() {
    $form=<<<FORM
      <script type="text/javascript">
      function submitLatest() {
      val = document.getElementById("rolledValue").value;
              $.ajax({
                type:"POST",
                url :"./+octeam",
                data:{
		  roll_latest_submit    : val 
                }
              }).done(function(msg){
                  $("#submitFormLatest").parent().html(msg);
                  pressed=false;

              });
      
      return false;
      }
      </script>
FORM;
    return $form;
}